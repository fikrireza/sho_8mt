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

      public function store(Request $request)
      {

          // $save = Plafon::create([
          //   'jenis_plafon' => $request->jenis_plafon,
          //   'jumlah_pembiayaan' => $request->jumlah_pembiayaan,
          //   'bulan' => $request->input('bulan'),
          //   'iuran' => $request->input('iuran'),
          //   'deskripsi' => 'iuran',
          //   'id_aktor'  => Auth::user()->id,
          //   'flag_status' => 1,
          // ]);

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

          return redirect()->route('plafon.index')->with('berhasil', 'Berhasil Menambahkan Tabel Baru');

      }
}
