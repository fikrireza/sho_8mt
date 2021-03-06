<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bidang;
use App\Models\LogAkses;

use Validator;
use Auth;
use DB;

class BidangController extends Controller
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
        $getBidang = Bidang::get();

        return view('bidang.index', compact('getBidang'));
    }

    public function tambah()
    {
      $tahun = date('y');
      $bulan = date('m');
      $rand = rand(10,99);

      $kode_bidang = 'BDG-'.$tahun.'-'.$bulan.'-'.$rand;

      $cek_kode = Bidang::where('kode_bidang', $kode_bidang)->first();

      if(!$cek_kode){
        $kode_bidang;
      }else{
        $kode_bidang = 'Kode Bidang Habis - Contact Fikri Please';
      }


        return view('bidang.tambah', compact('kode_bidang'));

    }

    public function store(Request $request)
    {
        $message = [
          'kode_bidang.required' => 'Wajib di isi',
          'nama_bidang.required' => 'Wajib di isi',
          'nama_bidang.unique' => 'Bidang ini sudah ada',
          'deskripsi.required' => 'Wajib di isi',
        ];

        $validator = Validator::make($request->all(), [
          'kode_bidang' => 'required',
          'nama_bidang' => 'required|unique:fra_bidang',
          'deskripsi' => 'required',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('bidang.tambah')->withErrors($validator)->withInput();
        }

        DB::transaction(function() use($request){
          $save = new Bidang;
          $save->kode_bidang = $request->kode_bidang;
          $save->nama_bidang = $request->nama_bidang;
          $save->deskripsi = $request->deskripsi;
          $save->id_aktor = Auth::user()->id;
          $save->flag_aktif = 'Y';
          $save->save();

          $log = new LogAkses;
          $log->aksi = 'Menambahkan Bidang '.$request->nama_bidang;
          $log->id_aktor = Auth::user()->id;
          $log->save();
        });

        return redirect()->route('bidang.index')->with('berhasil', 'Berhasil Menambahkan Bidang Baru');

    }

    public function ubah($id)
    {
        $getBidang = Bidang::find($id);

        if(!$getBidang){
          abort(404);
        }

        return $getBidang;
    }

    public function edit(Request $request)
    {
        $message = [
          'edit_kode_bidang.required' => 'Wajib di isi',
          'edit_nama_bidang.required' => 'Wajib di isi',
          'edit_nama_bidang.unique' => 'Bidang ini sudah ada',
          'edit_deskripsi.required' => 'Wajib di isi',
        ];

        $validator = Validator::make($request->all(), [
          'edit_kode_bidang' => 'required',
          'edit_nama_bidang' => 'required|unique:fra_bidang,nama_bidang,'.$request->id,
          'edit_deskripsi' => 'required',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('bidang.index')->withErrors($validator)->withInput();
        }

        DB::transaction(function() use($request){
          $update = Bidang::find($request->id);
          $update->kode_bidang = $request->edit_kode_bidang;
          $update->nama_bidang = $request->edit_nama_bidang;
          $update->deskripsi = $request->edit_deskripsi;
          $update->id_aktor = 1;
          $update->flag_aktif = 'Y';
          $update->update();

          $log = new LogAkses;
          $log->aksi = 'Mengubah Bidang '.$request->edit_nama_bidang;
          $log->id_aktor = Auth::user()->id;
          $log->save();
        });

        return redirect()->route('bidang.index')->with('berhasil', 'Berhasil Mengubah Bidang');

    }

    public function publish($id)
    {
      $getBidang = Bidang::find($id);

        if(!$getBidang){
          return view('backend.errors.404');
        }

        if ($getBidang->flag_aktif == "Y") {
          $getBidang->flag_aktif = "N";
          $getBidang->update();

          $log = new LogAkses;
          $log->aksi = 'Unpublish Bidang '.$getBidang->nama_bidang;
          $log->id_aktor = Auth::user()->id;
          $log->save();

          return redirect()->route('bidang.index')->with('berhasil', 'Berhasil Unpublish '.$getBidang->nama_bidang);
        }else{
          $getBidang->flag_aktif = "Y";
          $getBidang->update();

          $log = new LogAkses;
          $log->aksi = 'Publish Bidang '.$getBidang->nama_bidang;
          $log->id_aktor = Auth::user()->id;
          $log->save();

          return redirect()->route('bidang.index')->with('berhasil', 'Berhasil Publish '.$getBidang->nama_bidang);
        }
    }
}
