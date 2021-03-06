<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\User;
use Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $message = [
          'email.required' => 'Isi Email Anda',
          'email.email' => 'Format Email Tidak Sesuai',
          'password.required' => 'Isi Password Anda',
        ];

        $validator = Validator::make($request->all(), [
          'email'     =>  'required|email',
          'password'  =>  'required',
        ], $message);

        if($validator->fails())
        {
          return redirect('/')->withErrors($validator)->withInput();
        }

        if(Auth::attempt(['email' => $email, 'password' => $password, 'confirmed' => 1]))
        {
          $set = User::find(Auth::user()->id);
          $getCounter = $set->login_count;
          $set->login_count = $getCounter + 1;
          $set->update();

          if($set->login_count > 1){
            return redirect()->intended('home');
          }else{
            return redirect()->intended('account/profile')->with('gantiPassword', 'Harap Ganti Password Anda');
          }

          
        }
        else
        {
          return redirect()->intended('/')->with('failedLogin', 'Akun anda tidak aktif atau password salah')->withInput();
        }

    }
}
