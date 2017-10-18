<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Iuran;
use App\Models\Klaim;
use App\Models\Akad;
use App\Models\Plafon;
use App\Models\Jurnal;
use App\Models\LogAkses;

use Auth;
use DB;
use Mail;
use Validator;

class KlaimController extends Controller
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
          $getAkad = Akad::where('flag_status', 'A')->get();
        }else{
          $getAkad = Akad::where('flag_status', 'A')
          ->whereHas('anggota', function($query){
            $query->where('id_bmt', Auth::user()->id_bmt);
          })
          ->get();
        }


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

        DB::transaction(function() use($request){
          $save = new Klaim;
          $save->id_akad = $request->id_akad;
          $save->no_permohonan = $request->no_permohonan;
          $save->tanggal_musibah = $request->tanggal_musibah;
          $save->keterangan_musibah = $request->keterangan_musibah;
          $save->sisa_bayar = str_replace('.','',$request->sisa_bayar);
          $save->total_bayar = str_replace('.','',$request->total_bayar);
          $save->flag_status = 1;
          $save->id_aktor = Auth::user()->id;
          $save->save();

          $update = Akad::find($request->id_akad);
          $update->flag_status = 'K';
          $update->tanggal_lunas = date('Y-m-d');
          $update->update();

          $tahun = date('y');
          $bulan = date('m');
          $hari = date('d');
          $rand = rand(1000,9999);

          $iuran = Iuran::create([
            'id_akad' => $request->id_akad,
            'kode_iuran'  => 'LUNAS-KLAIM'.$tahun.$bulan.$hari.'-'.$rand,
            'tanggal_iuran' => date('Y-m-d'),
            'keterangan'  => 'Lunas Klaim Akad',
            'jenis_pembayaran' => 'CASH',
            'nilai_iuran' => str_replace('.','',$request->total_bayar),
            'id_aktor'  => Auth::user()->id,
          ]);

          // Jurnal DEBIT
          $jurnal = new Jurnal;
          $jurnal->id_akad = $request->id_akad;
          $jurnal->id_iuran = $iuran->id;
          $jurnal->tanggal_jurnal = date('Y-m-d');
          $jurnal->keterangan_jurnal = 'LUNAS-KLAIM';
          $jurnal->jumlah = str_replace('.','',$request->total_bayar);
          $jurnal->jenis_jurnal = 'D';
          $jurnal->id_aktor = Auth::user()->id;
          $jurnal->save();

          //Jurnal KREDIT
          $jurnal = new Jurnal;
          $jurnal->id_akad = $request->id_akad;
          $jurnal->id_iuran = $iuran->id;
          $jurnal->tanggal_jurnal = date('Y-m-d');
          $jurnal->keterangan_jurnal = 'KLAIM';
          $jurnal->jumlah = str_replace('.','',$request->jumlah_pembiayaan);
          $jurnal->jenis_jurnal = 'K';
          $jurnal->id_aktor = Auth::user()->id;
          $jurnal->save();

          $log = new LogAkses;
          $log->aksi = 'Klaim Akad';
          $log->id_aktor = Auth::user()->id;
          $log->save();
        });


        return redirect()->route('klaim.index')->with('berhasil', 'Berhasil Klaim');

    }

}
