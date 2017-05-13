<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Bmt;
use App\Models\BmtAnggota;

use Auth;
use Validator;
use Image;
use DB;
use Hash;

class DaftarAnggotaController extends Controller
{

      public function index()
      {
          if(session('status') === 'bmt'){
            $getAnggota = BmtAnggota::where('bmt_id', '=', Auth::user()->bmt_id)->get();
          }else{
            $getAnggota = BmtAnggota::get();
          }

          return view('daftarAnggota.index', compact('getAnggota'));
      }

      public function tambah()
      {
          if(session('status') === 'pbmt'){
            $getBMT = Bmt::where('id', Auth::user()->bmt_id)->get();
          }

          return view('daftarAnggota.tambah', compact('getBMT'));
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
          ]);


        });

        return redirect()->route('anggota.index')->with('berhasil', "Berhasil Menambahkan Anggota BMT");


      }
}
