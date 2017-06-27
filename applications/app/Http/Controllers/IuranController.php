<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bmt;
use App\Models\Jurnal;
use App\Models\Akad;
use App\Models\Plafon;
use App\Models\Anggota;
use App\Models\Iuran;
use App\Models\LogAkses;

use Auth;
use DB;
use Validator;
use Image;
use Carbon\Carbon;

class IuranController extends Controller
{

    public function index()
    {
        $getIuran = Iuran::get();

        return view('iuran.index', compact('getIuran'));
    }

    public function tambah()
    {
        $getBmt = BMT::where('id', Auth::user()->id_bmt)->first();

        $tahun = date('y');
        $bulan = date('m');
        $hari = date('d');
        $rand = rand(1000,9999);

        $kode_iuran = $getBmt->no_induk_bmt.'/IURAN/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$rand;
        $cek_kode_iuran = Iuran::where('kode_iuran', $kode_iuran)->first();

        if(!$cek_kode_iuran){
          $kode_iuran;
        }else{
          $kode_iuran = 'Kode Iuran BMT Habis - Contact Fikri Please';
        }

        $getAkad = Akad::where('flag_lunas', '=', '0')
                        ->where('approved_by', '!=', null)
                        ->get();

        return view('iuran.tambah', compact('getAkad', 'kode_iuran'));
    }

    public function getAkad($id)
    {
        $getPlafon = Plafon::join('bmt_akad', 'bmt_akad.id_plafon', '=', 'bmt_plafon.id')
                          ->select('bmt_plafon.jumlah_pembiayaan', 'bmt_plafon.bulan', 'bmt_plafon.iuran')
                          ->where('bmt_akad.id', $id)
                          ->first();
        $getPlafon = collect($getPlafon);

        $getIuran = Iuran::where('id_akad', $id)->sum('nilai_iuran');

        $getSisaPlafon = Akad::join('bmt_plafon', 'bmt_plafon.id', '=', 'bmt_akad.id_plafon')
                        ->select('bmt_plafon.bulan', 'bmt_akad.tanggal_akad')
                        ->where('bmt_akad.id', $id)
                        ->first();

        $tanggal_akad = $getSisaPlafon->tanggal_akad;
        $jumlah_bulan = "+".$getSisaPlafon->bulan." months";
        $due_date = strtotime($jumlah_bulan, strtotime($tanggal_akad));


        $get = $getPlafon->put('nilai_iuran', $getIuran);
        $get = $getPlafon->put('jatuh_tempo', date('Y-m-d',$due_date));

        return $get;
    }

    public function store(Request $request)
    {
        $message = [
          'kode_iuran.unique' => 'Kode Iuran Habis',
          'id_akad.required' => 'Wajib di isi',
          'tanggal_iuran.required' => 'Wajib di isi',
          'jenis_pembayaran.required' => 'Wajib di isi',
          'img_struk.max'  => 'Max 1Mb',
          'img_struk.mimes' => 'Format didukung jpeg,bmp,png',
          'nilai_iuran.required'  => 'Wajib di isi',
          'nilai_iuran.numeric'  => 'Wajib angka',
          'keterangan.required' => 'Wajib di isi'
        ];

        $validator = Validator::make($request->all(), [
          'kode_iuran' => 'required|unique:bmt_iuran',
          'id_akad'  => 'required',
          'tanggal_iuran'  => 'required',
          'img_struk'  => 'image|mimes:jpeg,bmp,png|max:1000',
          'jenis_pembayaran' => 'required',
          'nilai_iuran' => 'required|numeric',
          'keterangan' => 'required',
        ], $message);


        if($validator->fails()){
          return redirect()->route('iuran.tambah')->withErrors($validator)->withInput();
        }


        DB::transaction(function() use($request){

          $image = $request->file('img_struk');

          $save = new Iuran;
          $save->kode_iuran = $request->kode_iuran;
          $save->tanggal_iuran   = $request->tanggal_iuran;
          $save->keterangan = $request->keterangan;
          $save->jenis_pembayaran = $request->jenis_pembayaran;
          if($image){
            $salt = str_random(4);

            $img_url = $request->kode_iuran.' - '.str_slug($request->tanggal_iuran,'-').' - '.$salt. '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('documents/struk_iuran/'. $img_url);

            $save->img_struk  = $img_url;
          }
          $save->id_akad  = $request->id_akad;
          $save->id_aktor = Auth::user()->id;
          $save->nilai_iuran = $request->nilai_iuran;
          $save->flag_status = 1;
          $save->save();

          $log = new LogAkses;
          $log->aksi = 'Input Iuran Akad '.$request->kode_iuran;
          $log->aktor = Auth::user()->id;
          $log->save();
        });

        return redirect()->route('iuran.index')->with('berhasil', 'Berhasil input iuran');

    }
}
