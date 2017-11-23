<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Bmt;
use App\Models\Anggota;
use App\Models\Posisi;
use App\Models\LogAkses;

use Auth;
use Validator;
use Image;
use DB;
use Hash;

class DaftarBmtController extends Controller
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
        $getBMT = Bmt::get();

        return view('daftarBmt.index', compact('getBMT'));
    }

    public function tambah()
    {

        return view('daftarBmt.tambah');
    }

    public function store(Request $request)
    {
        $message = [
          'no_induk_bmt.required' => 'Wajib Di isi',
          'nama_bmt.unique' => 'Nama BMT Sudah Terdaftar',
          'nama_bmt.required' => 'Wajib Di isi',
          'alamat_bmt.required' => 'Wajib Di isi',
          'mpd_bmt.required' => 'Wajib Di isi',
          'mpw_bmt.required' => 'Wajib Di isi',
          'telp_bmt.required' => 'Wajib Di isi',
          'nama_kontak_bmt.required' => 'Wajib Di isi',
          'nomor_kontak_bmt.required' => 'Wajib Di isi',
          'email_bmt.required' => 'Wajib Di isi',
          'email_bmt.email' => 'Format Email'
        ];

        $validator = Validator::make($request->all(), [
          'nama_bmt' => 'required|unique:fra_bmt',
          'no_induk_bmt' => 'required',
          'alamat_bmt' => 'required',
          'mpd_bmt' => 'required',
          'mpw_bmt' => 'required',
          'telp_bmt' => 'required|numeric',
          'nama_kontak_bmt' => 'required',
          'nomor_kontak_bmt' => 'required',
          'email_bmt' => 'required|email',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('daftar.tambah')->withErrors($validator)->withInput();
        }

        DB::transaction(function() use($request){

          $bmt = Bmt::create([
            'no_induk_bmt' => $request->no_induk_bmt,
            'nama_bmt' => $request->nama_bmt,
            'alamat_bmt' => $request->alamat_bmt,
            'mpd_bmt' => $request->mpd_bmt,
            'mpw_bmt' => $request->mpw_bmt,
            'telp_bmt' => $request->telp_bmt,
            'nama_kontak_bmt' => $request->nama_kontak_bmt,
            'nomor_kontak_bmt' => $request->nomor_kontak_bmt,
            'email_bmt' => $request->email_bmt,
            'id_aktor' => Auth::user()->id,
            'flag_aktif' => 'Y',
          ]);

          $user = User::create([
            'name' => $request->nama_bmt,
            'email' => $request->email_bmt,
            'id_bmt' => $bmt->id,
            'confirmed' => 1,
            'confirmation_code' => str_random(30).time(),
            'login_count' => 0,
            'password'  => Hash::make('12345678qwer!'),
          ]);

          $logAkses = LogAkses::create([
            'aksi'  => 'Menambahkan BMT '.$request->nama_bmt,
            'id_aktor' => Auth::user()->id,
          ]);

        });

        return redirect()->route('daftar.index')->with('berhasil', "Berhasil Menambahkan BMT, Silahkan Ke Menu Manage User Untuk Memberikan Akses Login");

    }

    public function ubah($id)
    {
        $getBMT = Bmt::find($id);

        if(!$getBMT){
          abort('errors.404');
        }

        return view('daftarBmt.ubah', compact('getBMT'));
    }

    public function edit(Request $request)
    {

        $message = [
          'no_induk_bmt.required' => 'Wajib Di isi',
          'nama_bmt.unique' => 'Nama BMT Sudah ada',
          'nama_bmt.required' => 'Wajib Di isi',
          'alamat_bmt.required' => 'Wajib Di isi',
          'mpd_bmt.required' => 'Wajib Di isi',
          'mpw_bmt.required' => 'Wajib Di isi',
          'telp_bmt.required' => 'Wajib Di isi',
          'nama_kontak_bmt.required' => 'Wajib Di isi',
          'nomor_kontak_bmt.required' => 'Wajib Di isi',
          'email_bmt.required' => 'Wajib Di isi',
        ];

        $validator = Validator::make($request->all(), [
          'nama_bmt' => 'required|unique:bmt_bmt,nama_bmt,'.$request->id,
          'no_induk_bmt' => 'required',
          'alamat_bmt' => 'required',
          'mpd_bmt' => 'required',
          'mpw_bmt' => 'required',
          'telp_bmt' => 'required|numeric',
          'nama_kontak_bmt' => 'required',
          'nomor_kontak_bmt' => 'required',
          'email_bmt' => 'required'
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('daftar.ubah', ['id' => $request->id])->withErrors($validator)->withInput();
        }

        $update = Bmt::findOrFail($request->id);
        $input = $request->all();
        $update->fill($input)->update();

        $logAkses = LogAkses::create([
          'aksi'  => Auth::user()->kode_anggota.' | '.Auth::user()->nama_anggota.' | Mengubah Data BMT '.$request->nama_bmt,
          'aktor' => Auth::user()->id,
        ]);

        return redirect()->route('daftar.index')->with('berhasil', "Berhasil Mengubah BMT");

    }
}
