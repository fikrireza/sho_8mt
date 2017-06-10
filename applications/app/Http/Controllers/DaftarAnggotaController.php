<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Posisi;
use App\Models\Bidang;
use App\Models\LogAkses;

use Auth;
use Validator;
use Image;
use DB;
use Hash;

class DaftarAnggotaController extends Controller
{

      // Anggota = 1; PBMT
      // Peserta = 2; BMT

      public function index()
      {
          if(session('status') === 'bmt'){
            $getAnggota = Anggota::where('status', 2)->get();
          }else{
            $getAnggota = Anggota::get();
          }

          return view('daftarAnggota.index', compact('getAnggota'));
      }

      public function tambah()
      {
          $getPosisi = Posisi::get();
          $getBidang = Bidang::get();



          return view('daftarAnggota.tambah', compact('getPosisi', 'getBidang'));
      }

      public function store(Request $request)
      {

        $message = [
          'bmt_id.required' => 'Wajib Di isi',
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
          'bmt_id' => 'required',
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
          return redirect()->route('anggota.tambah')->withErrors($validator)->withInput();
        }

        DB::transaction(function() use($request){

          $anggota = BmtAnggota::create([
            'bmt_id' => $request->bmt_id,
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

          $logAkses = LogAkses::create([
            'aksi'  => Auth::user()->bmt_id.' | '.Auth::user()->nama.' | Menambahkan Anggota BMT',
            'aktor' => Auth::user()->id,
          ]);
        });

        return redirect()->route('anggota.index')->with('berhasil', "Berhasil Menambahkan Anggota BMT");

      }

      public function ubah($id)
      {
          if(session('status') === 'pbmt'){
            $getBMT = Bmt::where('flag_status', 1)->get();
          }

          $getAnggota = BmtAnggota::find($id);

          return view('daftarAnggota.ubah', compact('getBMT', 'getAnggota'));
      }

      public function edit(Request $request)
      {
          $message = [
            'bmt_id.required' => 'Wajib Di isi',
            'no_ktp.required' => 'Wajib Di isi',
            'no_ktp.unique' => 'No Ktp Sudah Terdaftar',
            'no_ktp.min' => 'Terlalu Pendek',
            'no_ktp.numeric' => 'Nomor Ktp',
            'nama.required' => 'Wajib Di isi',
            'alamat.required' => 'Wajib Di isi',
            'tempat_lahir.required' => 'Wajib Di isi',
            'tanggal_lahir.required' => 'Wajib Di isi',
            'lokasi_usaha.required' => 'Wajib Di isi',
            'jenis_usaha.required' => 'Wajib Di isi',
            'email.required' => 'Wajib Di isi',
            'email.email' => 'Format Email',
          ];

          $validator = Validator::make($request->all(), [
            'bmt_id' => 'required',
            'no_ktp' => 'required|numeric|min:15|unique:fra_bmt_anggota,no_ktp,'.$request->anggota_id,
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'lokasi_usaha' => 'required',
            'jenis_usaha' => 'required',
            'email' => 'required|email'
          ], $message);

          if($validator->fails())
          {
            return redirect()->route('anggota.ubah', ['id' => $request->anggota_id])->withErrors($validator)->withInput();
          }

          $update = BmtAnggota::findOrFail($request->anggota_id);
          $input = $request->all();
          $update->fill($input)->save();

          $logAkses = LogAkses::create([
            'aksi'  => Auth::user()->bmt_id.' | '.Auth::user()->nama.' | Mengubah Data Anggota BMT',
            'aktor' => Auth::user()->id,
          ]);

          return redirect()->route('anggota.index')->with('berhasil', 'Berhasil Mengubah Data Anggota BMT');

      }
}
