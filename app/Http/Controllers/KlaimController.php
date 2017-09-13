<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Iuran;
use App\Models\Klaim;
use App\Models\Akad;
use App\Models\Plafon;

use Auth;
use DB;
use Mail;
use Validator;

class KlaimController extends Controller
{

    public function index()
    {
        $getAkad = Akad::where('flag_lunas', 0)
                        ->where('flag_status', 1)
                        ->where('approved_by', '!=', null)
                        ->whereHas('anggota', function($query){
                          $query->where('id_bmt', Auth::user()->id_bmt);
                        })
                        ->get();

        return view('klaim.index', compact('getAkad'));
    }


    public function check(Request $request)
    {
        $getAkadnya = Akad::find($request->id_akad);
        if(!$getAkadnya){
          abort(404);
        }

        $getIuran = Iuran::where('id_akad', $request->id_akad)->get();
        if(!$getIuran){
          abort(404);
        }

        $getPlafon = Plafon::find($getAkadnya->id_plafon);
        if(!$getPlafon){
          abort(404);
        }

        $getAkad = $this->index()->getAkad;

        return view('klaim.index', compact('getAkad','getAkadnya', 'getIuran', 'getPlafon'));

    }

    public function store(Request $request)
    {
        $message = [
          'id_akad.required' => 'Wajib di isi',
          'keterangan_musibah.required' => 'Wajib di isi',
          'tanggal_musibah.required' => 'Wajib di isi',
          'sisa_bayar.required'  => 'Wajib di isi',
          'total_bayar.required' => 'Wajib di isi'
        ];

        $validator = Validator::make($request->all(), [
          'id_akad' => 'required',
          'keterangan_musibah'  => 'required',
          'tanggal_musibah'  => 'required',
          'sisa_bayar' => 'required',
          'total_bayar' => 'required',
        ], $message);


        if($validator->fails()){
          return redirect()->route('klaim.index')->withErrors($validator)->withInput();
        }

          $save = new Klaim;
          $save->id_anggota = $request->id_anggota;
          $save->id_akad = $request->id_akad;
          $save->no_permohonan = $request->no_permohonan;
          $save->tanggal_musibah = $request->tanggal_musibah;
          $save->keterangan_musibah = $request->keterangan_musibah;
          $save->sisa_bayar = str_replace('.','',$request->sisa_bayar);
          $save->total_bayar = str_replace('.','',$request->total_bayar);
          $save->id_aktor = Auth::user()->id;
          $save->flag_status = 1;
          $save->save();

          $update = Akad::find($request->id_akad);
          $update->flag_status = 3;
          $update->flag_lunas = 1;
          $update->tanggal_lunas = date('Y-m-d');
          $update->update();

        return redirect()->route('klaim.index')->with('berhasil', 'Berhasil Klaim');

    }

}
