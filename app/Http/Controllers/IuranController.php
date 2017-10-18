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
use File;
use Carbon\Carbon;

class IuranController extends Controller
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

    public function index(Request $request)
    {
        if($request->tahun == null){
          $tahun = date('Y');
        }else{
          $tahun = $request->tahun;
        }

        if(Auth::user()->id_bmt != null){
          $getIuran = Iuran::where('created_at', 'like', '%'.$tahun.'%')
                          ->wherehas('akad.anggota', function($query){
                                    $query->where('id_bmt', Auth::user()->id_bmt);
                                  })
                          ->get();
        }else{
          $getIuran = Iuran::where('created_at', 'like', '%'.$tahun.'%')->get();
        }

        $request = $request->tahun;

        return view('iuran.index', compact('getIuran','request'));
    }

    public function tambah()
    {
        if(Auth::user()->id_bmt == null){
          abort(403);
        }

        $getBmt = BMT::where('id', Auth::user()->id_bmt)->first();

        $tahun = date('y');
        $bulan = date('m');
        $hari = date('d');
        $rand = rand(1000,9999);

        $kode_iuran = $getBmt->no_induk_bmt.'-IURAN-'.$tahun.$bulan.$hari.'-'.$rand;
        $cek_kode_iuran = Iuran::where('kode_iuran', $kode_iuran)->first();

        if(!$cek_kode_iuran){
          $kode_iuran;
        }else{
          $kode_iuran = 'Kode Iuran BMT Habis - Contact Fikri Please';
        }

        $getAkad = Akad::where('flag_status', '=', 'A')
                        ->where('approved_by', '!=', null)
                        ->whereHas('anggota.bmt',
                            function($query){
                              $query->where('id_bmt', Auth::user()->id_bmt);
                            })
                        ->get();

        return view('iuran.tambah', compact('getAkad', 'kode_iuran'));
    }

    public function getAkad($id)
    {
        $getPlafon = Plafon::join('fra_akad', 'fra_akad.id_plafon', '=', 'fra_plafon.id')
                          ->select('fra_plafon.jumlah_pembiayaan', 'fra_plafon.bulan', 'fra_plafon.iuran')
                          ->where('fra_akad.id', $id)
                          ->first();

        $getPlafon = collect($getPlafon);

        $getIuran = Iuran::where('id_akad', $id)->sum('nilai_iuran');

        $getSisaPlafon = Akad::join('fra_plafon', 'fra_plafon.id', '=', 'fra_akad.id_plafon')
                        ->select('fra_plafon.bulan', 'fra_akad.tanggal_akad')
                        ->where('fra_akad.id', $id)
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
          'kode_iuran' => 'required|unique:fra_iuran',
          'id_akad'  => 'required',
          'tanggal_iuran'  => 'required',
          'img_struk'  => 'nullable|image|mimes:jpeg,bmp,png|max:1000',
          'jenis_pembayaran' => 'required',
          'nilai_iuran' => 'required|numeric',
          'keterangan' => 'required',
        ], $message);


        if($validator->fails()){
          return redirect()->route('iuran.tambah')->withErrors($validator)->withInput();
        }


        DB::transaction(function() use($request){

          $image = $request->file('img_struk');
          if($image){
            $salt = str_random(4);

            $img_url = str_replace('/','-',$request->kode_iuran).'-'.str_slug($request->tanggal_iuran,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('documents/struk_iuran/'. $img_url);
          }else{
            $img_url = null;
          }

          $Iuran = Iuran::create([
            'id_akad' => $request->id_akad,
            'kode_iuran' => $request->kode_iuran,
            'tanggal_iuran' => $request->tanggal_iuran,
            'keterangan' => $request->keterangan,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'img_struk' => $img_url,
            'nilai_iuran' => str_replace('.','',$request->nilai_iuran),
            'id_aktor'  => Auth::user()->id,
          ]);

          $log = new LogAkses;
          $log->aksi = 'Input Iuran Akad '.$request->kode_iuran.' Sejumlah : '.$request->nilai_iuran;
          $log->id_aktor = Auth::user()->id;
          $log->save();

          $jurnal = new Jurnal;
          $jurnal->id_akad = $request->id_akad;
          $jurnal->id_iuran = $Iuran->id;
          $jurnal->tanggal_jurnal = $request->tanggal_iuran;
          $jurnal->jumlah = str_replace('.','',$request->nilai_iuran);
          $jurnal->jenis_jurnal = 'D';
          $jurnal->id_aktor = Auth::user()->id;
          $jurnal->save();
        });

        return redirect()->route('iuran.index')->with('berhasil', 'Berhasil input iuran');

    }

    public function hapus($kode_iuran)
    {
        $getIuran = Iuran::where('kode_iuran', $kode_iuran)->first();

        if(!$getIuran){
          abort(404);
        }

        return view('iuran.ubah', compact('getIuran'));
    }

    public function delete(Request $request)
    {

        $cekIuran = Iuran::find($request->id);

        if(!$cekIuran){
          abort(404);
        }

        DB::transaction(function() use($cekIuran){
          $deleteJurnal = Jurnal::where('id_iuran', $cekIuran->id)->delete();

          File::delete('documents/struk_iuran/' .$cekIuran->img_struk);
          $cekIuran->delete();


          $log = new LogAkses;
          $log->aksi = 'Menghapus Iuran beserta Jurnal dengan Kode Iuran '.$cekIuran->kode_iuran;
          $log->id_aktor = Auth::user()->id;
          $log->save();
        });

        return redirect()->route('iuran.index')->with('berhasil', 'Data Iuran dan Jurnal Telah Berhasil Dihapus.');

    }

}
