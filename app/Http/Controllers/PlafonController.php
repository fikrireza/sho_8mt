<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plafon;
use App\Models\LogAkses;

use DB;
use Auth;
use Validator;
use Excel;
use Input;

class PlafonController extends Controller
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

    public function jiwa()
    {
        $getPlafonJiwaJumlah = Plafon::select('jumlah_pembiayaan')->where('jenis_plafon', 'JIWA')->groupBy('jumlah_pembiayaan')->get();
        $getPlafonJiwa = Plafon::where('jenis_plafon', 'JIWA')->orderBy('bulan', 'asc')->get();


        return view('plafon.jiwa', compact('getPlafonJiwaJumlah','getPlafonJiwa'));
    }

    public function kebakaran()
    {
        $getPlafonKebakaranJumlah = Plafon::select('jumlah_pembiayaan')->where('jenis_plafon', 'KEBAKARAN')->groupBy('jumlah_pembiayaan')->get();
        $getPlafonKebakaran = Plafon::where('jenis_plafon', 'KEBAKARAN')->orderBy('bulan', 'asc')->get();

        return view('plafon.kebakaran', compact('getPlafonKebakaranJumlah', 'getPlafonKebakaran'));
    }

    public function tambahJiwa()
    {
        $jenis_plafon = "JIWA";

        return view('plafon.tambah', compact('jenis_plafon'));
    }

    public function tambahKebakaran()
    {
        $jenis_plafon = "KEBAKARAN";

        return view('plafon.tambah', compact('jenis_plafon'));
    }

    public function store(Request $request)
    {
        $message = [
          'jenis_plafon.required' => 'Wajib di isi',
          'jumlah_pembiayaan.required' => 'Wajib di isi',
          'iuran.*.required' => 'Wajib di isi',
        ];

        $validator = Validator::make($request->all(), [
          'jenis_plafon' => 'required',
          'jumlah_pembiayaan' => 'required',
          'iuran.*' => 'required',
        ], $message);

        if($validator->fails())
        {
          if($request->jenis_plafon == "JIWA"){
            return redirect()->route('plafon.tambah.jiwa')->withErrors($validator)->withInput();
          }else{
            return redirect()->route('plafon.tambah.kebakaran')->withErrors($validator)->withInput()->with('jenis_plafon');
          }
        }

        //Check Biaya Plafon
        $check = Plafon::where('jenis_plafon', $request->jenis_plafon)->where('jumlah_pembiayaan',  str_replace('.','',$request->jumlah_pembiayaan))->first();
        if($check){
          if($request->jenis_plafon == "JIWA"){
            return redirect()->route('plafon.tambah.jiwa')->withErrors($validator)->withInput()->with('gagal', 'Jumlah Pembiayaan Sudah Terdaftar. Harap Edit jika ingin mengubah data.');
          }else{
            return redirect()->route('plafon.tambah.kebakaran')->withErrors($validator)->withInput()->with('gagal', 'Jumlah Pembiayaan Sudah Terdaftar. Harap Edit jika ingin mengubah data.');
          }
        }

        DB::transaction(function() use($request){
          $iurans = $request->input('iuran');
          $i = 3;
          foreach($iurans as $iuran){
            $save  = new Plafon;
            $save->jenis_plafon = $request->jenis_plafon;
            $save->jumlah_pembiayaan = str_replace('.','',$request->jumlah_pembiayaan);
            $save->bulan        = $i;
            $save->iuran        = str_replace('.', '',$iuran);
            $save->deskripsi    = 'iuran';
            $save->id_aktor     = Auth::user()->id;
            $save->save();
          $i++;
          }

          $log = new LogAkses;
          $log->aksi = 'Menambahkan Plafon '.$request->jenis_plafon.' - '.$request->jumlah_pembiayaan;
          $log->id_aktor = Auth::user()->id;
          $log->save();
        });

        if($request->jenis_plafon == "JIWA"){
          return redirect()->route('plafon.jiwa')->with('berhasil', 'Berhasil Menambahkan Skema Plafon Jiwa');
        }else{
          return redirect()->route('plafon.kebakaran')->with('berhasil', 'Berhasil Menambahkan Skema Plafon Kebakaran dan Jiwa');
        }

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

        $check = Plafon::where('jenis_plafon', $request->jenis_plafon)
                      ->where('jumlah_pembiayaan', str_replace('.','',$request->jumlah_pembiayaan))
                      ->first();

        if(!$check){
          abort(404);
        }

        DB::transaction(function() use($request){
          $id_plafon = $request->input('cicilan');

          for ($i=0; $i <= 33; $i++) {
            $update  = Plafon::find($id_plafon['id'][$i]);
            $update->jenis_plafon = $request->jenis_plafon;
            $update->jumlah_pembiayaan = str_replace('.','',$request->jumlah_pembiayaan);
            $update->bulan        = $id_plafon['bulan'][$i];
            $update->iuran        = str_replace('.','',$id_plafon['iuran'][$i]);
            $update->deskripsi    = 'iuran';
            $update->id_aktor     = Auth::user()->id;
            $update->save();
          }

          $log = new LogAkses;
          $log->aksi = 'Mengubah Skema Plafon '.$request->jenis_plafon.' - '.$request->jumlah_pembiayaan;
          $log->id_aktor = Auth::user()->id;
          $log->save();
        });

        if($request->jenis_plafon == "JIWA"){
          return redirect()->route('plafon.jiwa')->with('berhasil', 'Mengubah Skema Plafon '.$request->jenis_plafon.' - '.$request->jumlah_pembiayaan);
        }else{
          return redirect()->route('plafon.kebakaran')->with('berhasil', 'Mengubah Skema Plafon '.$request->jenis_plafon.' - '.$request->jumlah_pembiayaan);
        }

    }

    public function template()
    {
        return view('plafon.upload');
    }

    public function download()
    {

        return Excel::create('Template Upload Skema Plafon', function ($excel) {
          $excel->sheet('Data-Import-Jiwa', function ($sheet) {
              $sheet->row(1, array('jumlah_pembiayaan', 'bln_3', 'bln_4', 'bln_5', 'bln_6', 'bln_7', 'bln_8', 'bln_9', 'bln_10', 'bln_11', 'bln_12', 'bln_13', 'bln_14', 'bln_15', 'bln_16', 'bln_17', 'bln_18', 'bln_19', 'bln_20', 'bln_21', 'bln_22', 'bln_23', 'bln_24', 'bln_25', 'bln_26', 'bln_27', 'bln_28', 'bln_29', 'bln_30', 'bln_31', 'bln_32', 'bln_33', 'bln_34', 'bln_35', 'bln_36'));
              $sheet->setColumnFormat(array(
                  'A' => '0', 'B' => '0', 'C' => '0', 'D' => '0', 'E' => '0', 'F' => '0', 'G' => '0', 'H' => '0', 'I' => '0', 'J' => '0',
                  'K' => '0', 'L' => '0', 'M' => '0', 'N' => '0', 'O' => '0', 'P' => '0', 'Q' => '0', 'R' => '0', 'S' => '0', 'T' => '0',
                  'U' => '0', 'V' => '0', 'W' => '0', 'X' => '0', 'Y' => '0', 'Z' => '0', 'AA' => '0', 'AB' => '0', 'AC' => '0', 'AD' => '0',
                  'AE' => '0', 'AF' => '0', 'AG' => '0', 'AH' => '0', 'AI' => '0',
              ));
          });

          $excel->sheet('Data-Import-Kebakaran', function ($sheet) {
              $sheet->row(1, array('jumlah_pembiayaan', 'bln_3', 'bln_4', 'bln_5', 'bln_6', 'bln_7', 'bln_8', 'bln_9', 'bln_10', 'bln_11', 'bln_12', 'bln_13', 'bln_14', 'bln_15', 'bln_16', 'bln_17', 'bln_18', 'bln_19', 'bln_20', 'bln_21', 'bln_22', 'bln_23', 'bln_24', 'bln_25', 'bln_26', 'bln_27', 'bln_28', 'bln_29', 'bln_30', 'bln_31', 'bln_32', 'bln_33', 'bln_34', 'bln_35', 'bln_36'));
              $sheet->setColumnFormat(array(
                  'A' => '0', 'B' => '0', 'C' => '0', 'D' => '0', 'E' => '0', 'F' => '0', 'G' => '0', 'H' => '0', 'I' => '0', 'J' => '0',
                  'K' => '0', 'L' => '0', 'M' => '0', 'N' => '0', 'O' => '0', 'P' => '0', 'Q' => '0', 'R' => '0', 'S' => '0', 'T' => '0',
                  'U' => '0', 'V' => '0', 'W' => '0', 'X' => '0', 'Y' => '0', 'Z' => '0', 'AA' => '0', 'AB' => '0', 'AC' => '0', 'AD' => '0',
                  'AE' => '0', 'AF' => '0', 'AG' => '0', 'AH' => '0', 'AI' => '0',
              ));
          });

          $excel->sheet('Keterangan', function ($sheet) {
              $sheet->row(1, array('Isi Rupiah Tanpa Menggunakan Titik atau Koma dan Bilangan Bulat'));
              $sheet->mergeCells('A1:K3');

              $sheet->cells('A1:K3', function ($cells) {
                  $cells->setBackground('#5c92e8');
                  $cells->setFontColor('#000000');
                  $cells->setFontWeight('bold');
                  $cells->setFontSize(20);
              });
          });

        })->download('xls');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
          $path = Input::file('file')->getRealPath();
          $dataJiwa = Excel::selectSheets('Data-Import-Jiwa')->load($path, function ($reader){})->get();
          $dataKebakaran = Excel::selectSheets('Data-Import-Kebakaran')->load($path, function ($reader){})->get();

          if (!empty($dataJiwa) && $dataJiwa->count()) {
              foreach ($dataJiwa as $jiwa) {
                $collectJiwa[] = [
                  'jumlah_pembiayaan' => $jiwa->jumlah_pembiayaan,
                  'bln_3' => $jiwa->bln_3, 'bln_4' => $jiwa->bln_4, 'bln_5' => $jiwa->bln_5, 'bln_6' => $jiwa->bln_6,
                  'bln_7' => $jiwa->bln_7, 'bln_8' => $jiwa->bln_8, 'bln_9' => $jiwa->bln_9, 'bln_10' => $jiwa->bln_10,
                  'bln_11' => $jiwa->bln_11, 'bln_12' => $jiwa->bln_12, 'bln_13' => $jiwa->bln_13, 'bln_14' => $jiwa->bln_14,
                  'bln_15' => $jiwa->bln_15, 'bln_16' => $jiwa->bln_16, 'bln_17' => $jiwa->bln_17, 'bln_18' => $jiwa->bln_18,
                  'bln_19' => $jiwa->bln_19, 'bln_20' => $jiwa->bln_20, 'bln_21' => $jiwa->bln_21, 'bln_22' => $jiwa->bln_22,
                  'bln_23' => $jiwa->bln_23, 'bln_24' => $jiwa->bln_24, 'bln_25' => $jiwa->bln_25, 'bln_26' => $jiwa->bln_26,
                  'bln_27' => $jiwa->bln_27, 'bln_28' => $jiwa->bln_28, 'bln_29' => $jiwa->bln_29, 'bln_30' => $jiwa->bln_30,
                  'bln_31' => $jiwa->bln_31, 'bln_32' => $jiwa->bln_32, 'bln_33' => $jiwa->bln_33, 'bln_34' => $jiwa->bln_34,
                  'bln_35' => $jiwa->bln_35, 'bln_36' => $jiwa->bln_36,
                ];
              }
          } else {
              return view('plafon.upload')->with('gagal', 'Silahkan Donload Template');
          }

          if(!empty($dataKebakaran) && $dataKebakaran->count()) {
            foreach ($dataKebakaran as $kebakaran) {
              $collectKebakaran[] = [
                'jumlah_pembiayaan' => $kebakaran->jumlah_pembiayaan,
                'bln_3' => $kebakaran->bln_3, 'bln_4' => $kebakaran->bln_4, 'bln_5' => $kebakaran->bln_5, 'bln_6' => $kebakaran->bln_6,
                'bln_7' => $kebakaran->bln_7, 'bln_8' => $kebakaran->bln_8, 'bln_9' => $kebakaran->bln_9, 'bln_10' => $kebakaran->bln_10,
                'bln_11' => $kebakaran->bln_11, 'bln_12' => $kebakaran->bln_12, 'bln_13' => $kebakaran->bln_13, 'bln_14' => $kebakaran->bln_14,
                'bln_15' => $kebakaran->bln_15, 'bln_16' => $kebakaran->bln_16, 'bln_17' => $kebakaran->bln_17, 'bln_18' => $kebakaran->bln_18,
                'bln_19' => $kebakaran->bln_19, 'bln_20' => $kebakaran->bln_20, 'bln_21' => $kebakaran->bln_21, 'bln_22' => $kebakaran->bln_22,
                'bln_23' => $kebakaran->bln_23, 'bln_24' => $kebakaran->bln_24, 'bln_25' => $kebakaran->bln_25, 'bln_26' => $kebakaran->bln_26,
                'bln_27' => $kebakaran->bln_27, 'bln_28' => $kebakaran->bln_28, 'bln_29' => $kebakaran->bln_29, 'bln_30' => $kebakaran->bln_30,
                'bln_31' => $kebakaran->bln_31, 'bln_32' => $kebakaran->bln_32, 'bln_33' => $kebakaran->bln_33, 'bln_34' => $kebakaran->bln_34,
                'bln_35' => $kebakaran->bln_35, 'bln_36' => $kebakaran->bln_36,
              ];
            }
          }else{
            return view('plafon.upload')->with('gagal', 'Silahkan Donload Template');
          }

          if (!empty($collectJiwa) || !empty($collectKebakaran)) {
              $collectJiwa = collect($collectJiwa);
              $collectKebakaran = collect($collectKebakaran);

              return view('plafon.upload', compact('collectJiwa', 'collectKebakaran'));
          }
        } else {
            return view('plafon.upload')->with('gagal', 'Pilih Template yang Sudah ditentukan');
        }
    }


    public function plafonList($jenis_plafon)
    {
      $plafon = DB::table('fra_plafon')->where('jenis_plafon',$jenis_plafon)->distinct()->pluck('jumlah_pembiayaan');

      return json_encode($plafon);
    }

    public function plafonListBulan($jenis_plafon, $jumlah_pembiayaan)
    {
      $plafon = DB::table('fra_plafon')
      ->where('jumlah_pembiayaan',$jumlah_pembiayaan)
      ->where('jenis_plafon',$jenis_plafon)
      ->orderBy('bulan', 'asc')
      ->pluck('bulan', 'iuran');

      return json_encode($plafon);
    }



}
