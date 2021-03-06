<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\BMT;
use App\Models\LogAkses;

use DB;
use Auth;
use Validator;
use Hash;
use Image;
use Mail;

class AccountController extends Controller
{

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $getUser = User::with('roles')->get();

        return view('account.index', compact('getUser'));
    }

    public function tambah()
    {
        $getRole = Role::get();
        
        if(Auth::user()->id_bmt == null){
          $getBMT = Bmt::where('flag_aktif', 'Y')->get();
        }

        return view('account.tambah', compact('getBMT','getRole'));
    }

    public function store(Request $request)
    {
        $message = [
          'name.required' => 'This field is required',
          'name.unique' => 'The name has already taken',
          'email.required' => 'This field is required',
          'email.email' => 'Format email not supported',
          'email.unique' => 'Email has already taken',
          'avatar.image' => 'Format not supported',
          'avatar.max' => 'File Size Too Big',
        ];

        $validator = Validator::make($request->all(), [
          'name' => 'required|unique:fra_users',
          'id_bmt' => 'nullable',
          'email' => 'required|email|unique:fra_users',
          'avatar' => 'image|mimes:jpeg,bmp,png|max:1000'
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('account.userTambah')->withErrors($validator)->withInput();
        }

        DB::transaction(function() use($request){

          if($request->file('avatar')){
            $img_url = str_slug($request->file('avatar'),'-').'.' . $request->file('avatar')->getClientOriginalExtension();
            Image::make($request->file('avatar'))->fit(250,250)->save('images/profile/'. $img_url);
          }else{
            $img_url = 'user.png';
          }

          if($request->id_bmt == null) {
            $password = Hash::make('12345678');
          }else{
            $password = Hash::make('12345678qwert!');
          }

          $confirmation_code = str_random(30).time();
          $userSave = User::create([
            'name' => $request->name,
            'avatar' => $img_url,
            'email' => $request->email,
            'id_bmt'  => $request->id_bmt,
            'password' => $password,
            'confirmed' => $request->active,
            'login_count' => 0,
            'confirmation_code' => $confirmation_code,
            'api_token' => rtrim(base64_encode(md5(microtime())),"="),
          ]);

          foreach ($request->role as $key) {
            $role = RoleUser::firstOrCreate(['user_id' => $userSave->id, 'role_id' => $key]);
          }

          $data = array([
              'name' => $request->name,
              'email' => $request->email,
            ]);

          try {
            Mail::send('email.confirm', ['data' => $data], function($message) use ($data) {
              $message->to($data[0]['email'], $data[0]['name'])->subject('Aktivasi Akun Web Admin');
            });
          } catch (\Exception $e) {
            return redirect()->route('account.userIndex')->with('berhasil', 'New Account has been created, email '.$request->email.' cannot reached');
          }

          $logAkses = LogAkses::create([
            'aksi'  => 'Menambah User Akun '.$request->name,
            'id_aktor' => Auth::user()->id,
          ]);

        });

        return redirect()->route('account.userIndex')->with('berhasil', 'New Account has been created, check '.$request->email.' for verification');
    }

    public function ubah($id)
    {
      $getUser = User::find($id);

      if(!$getUser){
        abort(404);
      }

      $getRole = Role::get();

      return view('account.ubah', compact('getUser', 'getRole'));
    }

    public function update(Request $request)
    {
      $message = [
        'name.required' => 'This field is required.',
        'name.unique' => 'The name has already taken',
        'email.required' => 'This field is required.',
        'email.email' => 'Format not supported',
        'email.unique' => 'Email has already taken',
        'avatar.image' => 'Format not supported',
        'avatar.max' => 'File Size Too Big',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:fra_users,name,'.$request->id,
        'email' => 'required|email|unique:fra_users,email,'.$request->id,
        'avatar' => 'image|mimes:jpeg,bmp,png|max:1000'
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('account.userUbah', ['id' => $request->id ])->withErrors($validator)->withInput();
      }

      DB::transaction(function() use($request){
        $image = $request->file('avatar');

        if($request->active == 1){
          $confirmed = 1;
        }else{
          $confirmed = 0;
        }

        $update = User::find($request->id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->confirmed = $confirmed;
        if($image){
          $img_url = 'web-admin-'.str_slug($request->name,'-').'.'. $image->getClientOriginalExtension();
          Image::make($image)->fit(250,250)->save('images/profile/'. $img_url);
          $update->avatar = $img_url;
        }
        $update->update();

        $rolesUpdate = RoleUser::where('user_id', $request->id)->delete();

        foreach ($request->role as $key) {
          $role = RoleUser::firstOrCreate(['user_id' => $request->id, 'role_id' => $key]);
        }

        $logAkses = LogAkses::create([
          'aksi'  => 'Mengubah Data User Akun '.$request->name,
          'id_aktor' => Auth::user()->id,
        ]);
      });


      return redirect()->route('account.userIndex')->with('berhasil', 'User has been successfully updated');

    }

    public function reset($id)
    {
      $getUser = User::find($id);

      if(!$getUser){
        abort(404);
      }

      $getUser->password = Hash::make('12345678qwer');
      $getUser->save();

      if($getUser->id == Auth::user()->id){
          auth()->logout();
      }

      $data = array([
        'name' => $getUser->name,
        'email' => $getUser->email,
        'password' => '12345678qwer',
      ]);

      Mail::send('email.reset', ['data' => $data], function($message) use ($data) {
        $message->from('administrator@amadeo.id', 'Administrator')
                ->to($data[0]['email'], $data[0]['name'])
                ->subject('Reset Password Akun Web Admin');
      });

      return redirect()->route('account.index')->with('berhasil', 'Password user '.$getUser->name.' Has been reset');
    }


    //---------- Controller For Role Users ----------//
    public function role()
    {
        $getRole = Role::get();

        return view('account.role', compact('getRole'));
    }

    public function roleCreate()
    {
        return view('account.role-tambah');
    }

    public function rolePost(Request $request)
    {
        $message = [
          'name.required' => 'This field is required',
          'name.unique' => 'Role has already taken',
          'permissions.required' => 'This field is required',
        ];

        $validator = Validator::make($request->all(),[
          'name' => 'required|unique:fra_roles',
          'permissions' => 'required',
        ],$message);


        if($validator->fails())
        {
          return redirect()->route('account.roleCreate')->withErrors($validator)->withInput();
        }

        $new = new Role;
        $new->name = $request->name;
        $new->slug = str_slug($request->name);
        $new->permissions = $request->input('permissions');
        $new->save();

        $logAkses = LogAkses::create([
          'aksi'  => 'Menambah Role Akses '.$request->name,
          'id_aktor' => Auth::user()->id,
        ]);

        return redirect()->route('account.roleIndex')->with('berhasil', 'Data Role has been successfully create');
    }

    public function roleUbah($slug)
    {
        $getRole = Role::where('slug', $slug)->first();

        if(!$getRole){
          return view('errors.404');
        }

        $can = array();
        foreach ($getRole->permissions as $key => $value) {
          $can[] = $key;
        }

        return view('account.role-edit', compact('getRole', 'can'));
    }

    public function roleEdit(Request $request)
    {
        $message = [
          'permissions.required' => 'This field is required',
        ];

        $validator = Validator::make($request->all(),[
          'permissions' => 'required',
        ],$message);


        if($validator->fails())
        {
          return redirect()->route('account.roleUbah', ['slug' => $request->slug])->withErrors($validator)->withInput()->with('gagal', 'Please at least give one access');
        }


        $update = Role::find($request->id);
        $update->permissions = $request->input('permissions');
        $update->update();

        $logAkses = LogAkses::create([
          'aksi'  => 'Mengubah Role Akses '.$update->name,
          'id_aktor' => Auth::user()->id,
        ]);

        return redirect()->route('account.roleIndex')->with('berhasil', 'Data Role has been successfully updated');
    }

    public function profile()
    {
        $getProfile = User::find(Auth::user()->id);

        if(!$getProfile){
          abort(404);
        }

        return view('account.profile', compact('getProfile'));
    }

    public function postProfile(Request $request)
    {
      $message = [
          'name.required' => 'This field is required',
          // 'email.unique' => 'Email ini sudah digunakan',
          // 'email.email' => 'Format harus Email',
          'avatar.image' => 'Format Gambar Tidak Sesuai',
          'avatar.max' => 'File Size Terlalu Besar',
        ];

        $validator = Validator::make($request->all(), [
          'name' => 'required',
          // 'email' => 'required|email|unique:fra_users,email,'.$request->id,
          'avatar' => 'image|mimes:jpeg,bmp,png|max:1000',
        ], $message);


        if($validator->fails())
        {
          return redirect()->route('account.profile')->withErrors($validator)->withInput();
        }


        $image = $request->file('avatar');

        if (!$image) {
          $update = User::find($request->id);
          $update->name = $request->name;
          $update->email = $request->email;
          $update->update();
        }else{
          $img_url = str_slug($request->name,'-'). '.' . $image->getClientOriginalExtension();
          Image::make($image)->fit(250,250)->save('images/profile/'. $img_url);

          $update = User::find($request->id);
          $update->name = $request->name;
          $update->email = $request->email;
          $update->avatar  = $img_url;
          $update->update();
        }

        $logAkses = LogAkses::create([
          'aksi'  => 'Mengubah Profil '.Auth::user()->name,
          'id_aktor' => Auth::user()->id,
        ]);

        return redirect()->route('account.profile')->with('berhasil', 'Your Profile Has Been Changes');
    }

    public function changePassword(Request $request)
    {
        $getUser = User::where('id', $request->id)->first();

        $messages = [
          'oldpass.required' => "This field is required",
          'newpass.required' => "This field is required",
          'newpass.min' => "Too Short",
          'newpass_confirmation.required' => "This field is required",
          'newpass_confirmation.confirmed' => "Password did not match",
        ];

        $validator = Validator::make($request->all(), [
          'oldpass' => 'required',
          'newpass' => 'required|min:8',
          'newpass_confirmation' => 'required|same:newpass'
        ], $messages);

        if ($validator->fails()) {
          return redirect()->route('account.profile')->withErrors($validator)->withInput();
        }

        if(Hash::check($request->oldpass, $getUser->password))
        {
          $getUser->password = Hash::make($request->newpass);
          $getUser->save();

          $logAkses = LogAkses::create([
            'aksi'  => 'Mengubah Password '.$getUser->name,
            'id_aktor' => Auth::user()->id,
          ]);

          return redirect()->route('account.profile')->with('berhasil', 'Your password has been changed');
        }
        else {
          return redirect()->route('account.profile')->with('erroroldpass', 'Your current password did not match');
        }
    }
}
