<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Bmt;
use App\Models\BmtAnggota;
use App\Models\LogAkses;

use Auth;
use Validator;
use Image;
use DB;
use Hash;

class DaftarBmtController extends Controller
{

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
        'no_induk.required' => 'Wajib Di isi',
        'no_induk.unique' => 'No Induk Sudah Terdaftar',
        'nama_bmt.required' => 'Wajib Di isi',
        'alamat_bmt.required' => 'Wajib Di isi',
        'mpd.required' => 'Wajib Di isi',
        'mpw.required' => 'Wajib Di isi',
        'telp.required' => 'Wajib Di isi',
        'nama_kontak.required' => 'Wajib Di isi',
        'nomor_kontak.required' => 'Wajib Di isi',
        'no_ktp.required' => 'Wajib Di isi',
        'no_ktp.unique' => 'No Ktp Sudah Terdaftar',
        'no_ktp.min' => 'Terlalu Pendek',
        'no_ktp.numeric' => 'Nomor Ktp',
        'nama_anggota.required' => 'Wajib Di isi',
        'alamat_anggota.required' => 'Wajib Di isi',
        'tempat_lahir.required' => 'Wajib Di isi',
        'tanggal_lahir.required' => 'Wajib Di isi',
        'lokasi_usaha.required' => 'Wajib Di isi',
        'jenis_usaha.required' => 'Wajib Di isi',
        'email.required' => 'Wajib Di isi',
        'email.email' => 'Format Email',
      ];

      $validator = Validator::make($request->all(), [
        'no_induk' => 'required|unique:fra_bmt',
        'nama_bmt' => 'required',
        'alamat_bmt' => 'required',
        'mpd' => 'required',
        'mpw' => 'required',
        'telp' => 'required|numeric',
        'nama_kontak' => 'required',
        'nomor_kontak' => 'required',
        'no_ktp' => 'required|numeric|min:15|unique:fra_bmt_anggota',
        'nama_anggota' => 'required',
        'alamat_anggota' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required',
        'lokasi_usaha' => 'required',
        'jenis_usaha' => 'required',
        'email' => 'required|email'
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('daftar.tambah')->withErrors($validator)->withInput();
      }
      // dd($request);

      DB::transaction(function() use($request){

        $bmt = Bmt::create([
          'no_induk' => $request->no_induk,
          'nama' => $request->nama_bmt,
          'alamat' => $request->alamat_bmt,
          'mpd' => $request->mpd,
          'mpw' => $request->mpw,
          'telp' => $request->telp,
          'nama_kontak' => $request->nama_kontak,
          'nomor_kontak' => $request->nomor_kontak,
          'email' => $request->email,
          'aktor' => Auth::user()->id,
        ]);

        $anggota = BmtAnggota::create([
          'bmt_id' => $bmt->id,
          'no_ktp' => $request->no_ktp,
          'nama' => $request->nama_anggota,
          'alamat' => $request->alamat_anggota,
          'tempat_lahir' => $request->tempat_lahir,
          'tanggal_lahir' => $request->tanggal_lahir,
          'lokasi_usaha' => $request->lokasi_usaha,
          'jenis_usaha' => $request->jenis_usaha,
          'email' => $request->email,
          'aktor' => Auth::user()->id,
        ]);

        $user = User::create([
          'nama' => $request->nama_anggota,
          'email' => $request->email,
          'role_id' => 2,
          'bmt_id'  => $bmt->id,
          'confirmed' => 0,
          'confirmation_code' => str_random(30).time(),
          'password'  => Hash::make('12345678QWER'),
        ]);

        $logAkses = LogAkses::create([
          'aksi'  => Auth::user()->bmt_id.' | '.Auth::user()->nama.' | Menambahkan BMT',
          'aktor' => Auth::user()->id,
        ]);

      });

      return redirect()->route('daftar.index')->with('berhasil', "Berhasil Menambahkan BMT");

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
          'no_induk.required' => 'Wajib Di isi',
          'no_induk.unique' => 'No Induk Sudah ada',
          'nama.required' => 'Wajib Di isi',
          'alamat.required' => 'Wajib Di isi',
          'mpd.required' => 'Wajib Di isi',
          'mpw.required' => 'Wajib Di isi',
          'telp.required' => 'Wajib Di isi',
          'nama_kontak.required' => 'Wajib Di isi',
          'nomor_kontak.required' => 'Wajib Di isi'
        ];

        $validator = Validator::make($request->all(), [
          'no_induk' => 'required|unique:fra_bmt,no_induk,'.$request->id,
          'nama' => 'required',
          'alamat' => 'required',
          'mpd' => 'required',
          'mpw' => 'required',
          'telp' => 'required|numeric',
          'nama_kontak' => 'required',
          'nomor_kontak' => 'required'
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('daftar.ubah', ['id' => $request->id])->withErrors($validator)->withInput();
        }


        $update = Bmt::findOrFail($request->id);
        $input = $request->all();
        $update->fill($input)->update();

        $logAkses = LogAkses::create([
          'aksi'  => Auth::user()->bmt_id.' | '.Auth::user()->nama.' | Mengubah BMT',
          'aktor' => Auth::user()->id,
        ]);

        return redirect()->route('daftar.index')->with('berhasil', "Berhasil Mengubah BMT");

    }
}
