<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bidang;
use App\Models\Posisi;
use App\Models\LogAkses;

use Validator;
use Auth;
use DB;

class PosisiController extends Controller
{
    public function index()
    {
        $getPosisi = Posisi::get();

        $getBidang = Bidang::where('flag_status', 1)->get();

        return view('posisi.index', compact('getPosisi', 'getBidang'));
    }

    public function tambah()
    {
        $tahun = date('y');
        $bulan = date('m');
        $rand = rand(10,99);

        $kode_posisi = 'PSS-'.$tahun.'-'.$bulan.'-'.$rand;

        $cek_kode = Posisi::where('kode_posisi', $kode_posisi)->first();

        if(!$cek_kode){
          $kode_posisi;
        }else{
          $kode_posisi = 'Kode Posisi Habis - Contact Fikri Please';
        }

        $getBidang = Bidang::where('flag_status', 1)->get();


        return view('posisi.tambah', compact('kode_posisi', 'getBidang'));
    }

    public function store(Request $request)
    {
        $message = [
          'kode_posisi.required' => 'Wajib di isi',
          'nama_posisi.required' => 'Wajib di isi',
          'nama_posisi.unique' => 'Bidang ini sudah ada',
          'id_bidang.required' => 'Wajib di isi',
        ];

        $validator = Validator::make($request->all(), [
          'kode_posisi' => 'required',
          'nama_posisi' => 'required|unique:bmt_posisi',
          'id_bidang' => 'required',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('posisi.tambah')->withErrors($validator)->withInput();
        }


        $save = new Posisi;
        $save->id_bidang = $request->id_bidang;
        $save->kode_posisi = $request->kode_posisi;
        $save->nama_posisi = $request->nama_posisi;
        $save->id_aktor = 1;
        $save->flag_status = 1;
        $save->save();

        $log = new LogAkses;
        $log->aksi = 'Menambahkan Posisi Baru '.$request->nama_posisi;
        $log->aktor = Auth::user()->id;
        $log->save();

        return redirect()->route('posisi.index')->with('berhasil', 'Berhasil Menambahkan Posisi Baru');

    }

    public function ubah($id)
    {
        $getPosisi = Posisi::find($id);

        if(!$getPosisi){
          abort(404);
        }

        return $getPosisi;
    }


    public function edit(Request $request)
    {
        $message = [
          'edit_kode_posisi.required' => 'Wajib di isi',
          'edit_nama_posisi.required' => 'Wajib di isi',
          'edit_nama_posisi.unique' => 'Bidang ini sudah ada',
          'edit_id_bidang.required' => 'Wajib di isi',
        ];

        $validator = Validator::make($request->all(), [
          'edit_kode_posisi' => 'required',
          'edit_nama_posisi' => 'required|unique:bmt_posisi,nama_posisi,'.$request->id,
          'edit_id_bidang' => 'required',
        ], $message);

        if($validator->fails())
        {
          return redirect()->route('posisi.index')->withErrors($validator)->withInput();
        }

        $update = Posisi::find($request->id);
        $update->id_bidang = $request->edit_id_bidang;
        $update->kode_bidang = $request->edit_kode_posisi;
        $update->nama_bidang = $request->edit_nama_posisi;
        $update->id_aktor = 1;
        $update->flag_status = 1;
        $update->update();

        $log = new LogAkses;
        $log->aksi = 'Mengubah Posisi '.$request->edit_nama_posisi;
        $log->aktor = Auth::user()->id;
        $log->save();

        return redirect()->route('posisi.index')->with('berhasil', 'Berhasil Mengubah Posisi');

    }


    public function publish($id)
    {
        $getPosisi = Posisi::find($id);

        if(!$getPosisi){
          return view('backend.errors.404');
        }

        if ($getPosisi->flag_status == 1) {
          $getPosisi->flag_status = 0;
          $getPosisi->update();

          $log = new LogAkses;
          $log->aksi = 'Unpublish Posisi '.$getPosisi->nama_posisi;
          $log->aktor = Auth::user()->id;
          $log->save();

          return redirect()->route('posisi.index')->with('berhasil', 'Berhasil Unpublish '.$getPosisi->nama_posisi);
        }else{
          $getPosisi->flag_status = 1;
          $getPosisi->update();

          $log = new LogAkses;
          $log->aksi = 'Publish Posisi '.$getPosisi->nama_posisi;
          $log->aktor = Auth::user()->id;
          $log->save();

          return redirect()->route('posisi.index')->with('berhasil', 'Berhasil Publish '.$getPosisi->nama_posisi);
        }
    }
}
