<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Bmt;
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
        if(Auth::user()->id_bmt == null){
          $getAnggota = Anggota::get();
        }else{
          $getAnggota = Anggota::where('id_bmt', Auth::user()->id_bmt)->get();
        }

        return view('daftarAnggota.index', compact('getAnggota'));
    }

    public function tambah()
    {
        $getBmt = BMT::where('flag_aktif', 'Y')->get();
        $getPosisi = Posisi::where('flag_aktif', 'Y')->get();
        $getBidang = Bidang::where('flag_aktif', 'Y')->get();

        return view('daftarAnggota.tambah', compact('getBmt', 'getPosisi', 'getBidang'));
    }

    public function store(Request $request)
    {
        $message = [
          'id_bmt.required' => 'Wajib Di isi',
          'no_ktp.required' => 'Wajib Di isi',
          'no_ktp.unique' => 'No Ktp Sudah Terdaftar',
          'no_ktp.min' => 'Terlalu Pendek',
          'no_ktp.numeric' => 'Nomor Ktp',
          'nama_anggota.required' => 'Wajib Di isi',
          'kode_anggota.required' => 'Wajib Di isi',
          'kode_pos.required' => 'Wajib Di isi',
          'alamat_anggota.required' => 'Wajib Di isi',
          'no_telp.required' => 'Wajib Di isi',
          'jenis_kelamin.required' => 'Wajib Di isi',
          'tempat_lahir.required' => 'Wajib Di isi',
          'tanggal_lahir.required' => 'Wajib Di isi',
          'lokasi_usaha.required' => 'Wajib Di isi',
          'jenis_usaha.required' => 'Wajib Di isi',
          'email.required' => 'Wajib Di isi',
          'email.email' => 'Format Email',
        ];

        $validator = Validator::make($request->all(), [
          'id_bmt' => 'required',
          'id_posisi' => 'nullable',
          'kode_anggota'  => 'required|unique:fra_anggota',
          'no_ktp' => 'required|numeric|min:15|unique:fra_anggota',
          'nama_anggota' => 'required',
          'jenis_kelamin' => 'required',
          'kode_pos'  => 'required',
          'alamat_anggota' => 'required',
          'no_telp' => 'required',
          'tempat_lahir' => 'required',
          'tanggal_lahir' => 'required',
          'status_pernikahan' => 'required',
          'lokasi_usaha' => 'required',
          'jenis_usaha' => 'required',
          'email' => 'required|email'
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('anggota.tambah')->withErrors($validator)->withInput();
        }


        DB::transaction(function() use($request){

          $anggota = Anggota::create([
            'id_bmt' => $request->id_bmt,
            'id_posisi' => $request->id_posisi,
            'kode_anggota' => $request->kode_anggota,
            'no_ktp' => $request->no_ktp,
            'nama_anggota' => $request->nama_anggota,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat_anggota,
            'no_telp' => $request->no_telp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_pernikahan' => $request->status_pernikahan,
            'lokasi_usaha' => $request->lokasi_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'email' => $request->email,
            'id_aktor' => Auth::user()->id,
            'flag_aktif' => 'Y',
          ]);

          $logAkses = LogAkses::create([
            'aksi'  => 'Menambahkan Anggota BMT '.$request->nama_anggota,
            'id_aktor' => Auth::user()->id,
          ]);
        });

        return redirect()->route('anggota.index')->with('berhasil', "Berhasil Menambahkan Anggota BMT ".$request->nama_anggota);

    }

    public function ubah($id)
    {
        if(Auth::user()->id_bmt == null){
          $getBMT = Bmt::where('flag_aktif', 'Y')->get();
          $getPosisi = Posisi::where('flag_aktif', 'Y')->get();
          $getBidang = Bidang::where('flag_aktif', 'Y')->get();
        }

        $getAnggota = Anggota::find($id);

        return view('daftarAnggota.ubah', compact('getBMT', 'getAnggota', 'getPosisi', 'getBidang'));
    }

    public function edit(Request $request)
    {
        $message = [
          'id_bmt.required' => 'Wajib Di isi',
          'no_ktp.required' => 'Wajib Di isi',
          'no_ktp.unique' => 'No Ktp Sudah Terdaftar',
          'no_ktp.min' => 'Terlalu Pendek',
          'no_ktp.numeric' => 'Nomor Ktp',
          'nama_anggota.required' => 'Wajib Di isi',
          'alamat.required' => 'Wajib Di isi',
          'tempat_lahir.required' => 'Wajib Di isi',
          'tanggal_lahir.required' => 'Wajib Di isi',
          'lokasi_usaha.required' => 'Wajib Di isi',
          'jenis_usaha.required' => 'Wajib Di isi',
          'jenis_kelamin.required' => 'Wajib Di isi',
          'status_pernikahan.required' => 'Wajib Di isi',
          'no_telp.required' => 'Wajib Di isi',
          'email.required' => 'Wajib Di isi',
          'email.email' => 'Format Email',
        ];

        $validator = Validator::make($request->all(), [
          'id_bmt' => 'required',
          'kode_anggota'  => 'required|unique:fra_anggota,no_ktp,'.$request->id,
          'no_ktp' => 'required|numeric|min:15|unique:fra_anggota,no_ktp,'.$request->id,
          'nama_anggota' => 'required',
          'jenis_kelamin' => 'required',
          'alamat' => 'required',
          'kode_pos'  => 'required',
          'no_telp' => 'required',
          'tempat_lahir' => 'required',
          'tanggal_lahir' => 'required',
          'lokasi_usaha' => 'required',
          'jenis_usaha' => 'required',
          'status_pernikahan' => 'required',
          'email' => 'required|email'
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('anggota.ubah', ['id' => $request->anggota_id])->withErrors($validator)->withInput();
        }

        DB::transaction(function() use($request){
          $update = Anggota::findOrFail($request->id);
          $input = $request->all();
          $update->fill($input)->save();

          $logAkses = LogAkses::create([
            'aksi'  => 'Mengubah Data Anggota '.$request->nama_anggota,
            'id_aktor' => Auth::user()->id,
          ]);
        });

        return redirect()->route('anggota.index')->with('berhasil', 'Berhasil Mengubah Data Anggota BMT');

    }
}
