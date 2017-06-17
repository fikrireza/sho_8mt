<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plafon;
use App\Models\LogAkses;

use DB;
use Auth;
use Validator;

class PlafonController extends Controller
{
      public function index()
      {
          $getPlafonKebakaranJumlah = Plafon::select('jumlah_pembiayaan')->where('jenis_plafon', 0)->groupBy('jumlah_pembiayaan')->get();
          $getPlafonKebakaran = Plafon::where('jenis_plafon', 0)->orderBy('bulan', 'asc')->get();
          $getPlafonJiwaJumlah = Plafon::select('jumlah_pembiayaan')->where('jenis_plafon', 1)->groupBy('jumlah_pembiayaan')->get();
          $getPlafonJiwa = Plafon::where('jenis_plafon', 1)->orderBy('bulan', 'asc')->get();


          return view('plafon.index', compact('getPlafonJiwaJumlah','getPlafonJiwa', 'getPlafonKebakaranJumlah', 'getPlafonKebakaran'));
      }

      public function tambahJiwa()
      {
          $jenis_plafon = 1;

          return view('plafon.tambah', compact('jenis_plafon'));
      }

      public function tambahKebakaran()
      {
          $jenis_plafon = 0;

          return view('plafon.tambah', compact('jenis_plafon'));
      }

      public function plafonList($jenis_plafon)
      {
          $plafon = DB::table('bmt_plafon')->where('jenis_plafon',$jenis_plafon)->distinct()->pluck('jumlah_pembiayaan');

          return json_encode($plafon);
      }

      public function plafonListBulan($jenis_plafon, $jumlah_pembiayaan)
      {
          $plafon = DB::table('bmt_plafon')
                        ->where('jumlah_pembiayaan',$jumlah_pembiayaan)
                        ->where('jenis_plafon',$jenis_plafon)
                        ->orderBy('bulan', 'asc')
                        ->pluck('bulan', 'iuran');

          return json_encode($plafon);
      }



      public function store(Request $request)
      {

          $message = [
            'jenis_plafon.required' => 'Wajib di isi',
            'jumlah_pembiayaan.required' => 'Wajib di isi',
            'iuran.*.required' => 'Wajib di isi',
            'iuran.*.numeric' => 'Wajib isi Angka',
          ];

          $validator = Validator::make($request->all(), [
            'jenis_plafon' => 'required',
            'jumlah_pembiayaan' => 'required',
            'iuran.*' => 'required|numeric',
          ], $message);

          if($validator->fails())
          {
            if($request->jenis_plafon == 1){
              return redirect()->route('plafon.tambah.jiwa')->withErrors($validator)->withInput();
            }else{
              return redirect()->route('plafon.tambah.kebakaran')->withErrors($validator)->withInput()->with('jenis_plafon');
            }
          }

          $bulan = $request->input('iuran');
          $i = 3;
          foreach($bulan as $bln){
            $save  = new Plafon;
            $save->jenis_plafon = $request->jenis_plafon;
            $save->jumlah_pembiayaan = $request->jumlah_pembiayaan;
            $save->bulan        = $i;
            $save->iuran        = $bln;
            $save->deskripsi    = 'iuran';
            $save->id_aktor     = Auth::user()->id;
            $save->flag_status  = 1;
            $save->save();
          $i++;
          }

          $log = new LogAkses;
          $log->aksi = 'Menambahkan Plafon Baru '.$request->jenis_plafon.' - '.$request->jumlah_pembiayaan;
          $log->aktor = Auth::user()->id;
          $log->save();

          return redirect()->route('plafon.index')->with('berhasil', 'Berhasil Menambahkan Tabel Baru');

      }

      public function ubah($jenis_plafon, $jumlah_pembiayaan)
      {
          $getPlafon = Plafon::where('jenis_plafon', $jenis_plafon)->where('jumlah_pembiayaan', $jumlah_pembiayaan)->get();

          if($getPlafon->isEmpty()){
            return view('errors.404');
          }

          return view('plafon.ubah', compact('getPlafon'));
      }

      public function edit(Request $request)
      {
          $id_plafon = $request->input('cicilan');

          for ($i=0; $i <= 33; $i++) {
            $update  = Plafon::find($id_plafon['id'][$i]);
            $update->jenis_plafon = $request->jenis_plafon;
            $update->jumlah_pembiayaan = $request->jumlah_pembiayaan;
            $update->bulan        = $id_plafon['bulan'][$i];
            $update->iuran        = $id_plafon['iuran'][$i];
            $update->deskripsi    = 'iuran';
            $update->id_aktor     = Auth::user()->id;
            $update->flag_status  = 1;
            $update->save();
          }

          $log = new LogAkses;
          $log->aksi = 'Mengubah Plafon '.$request->jenis_plafon.' - '.$request->jumlah_pembiayaan;
          $log->aktor = Auth::user()->id;
          $log->save();

          return redirect()->route('plafon.index')->with('berhasil', 'Berhasil Mengubah Plafon '.$request->jumlah_pembiayaan);

      }
}
