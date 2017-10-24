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
        $getPlafonJiwa = Plafon::where('jenis_plafon', 'JIWA')->get();


        return view('plafon.jiwa', compact('getPlafonJiwaJumlah','getPlafonJiwa'));
    }

    public function kebakaran()
    {
        $getPlafonKebakaranJumlah = Plafon::select('jumlah_pembiayaan')->where('jenis_plafon', 'KEBAKARAN')->groupBy('jumlah_pembiayaan')->get();
        $getPlafonKebakaran = Plafon::where('jenis_plafon', 'KEBAKARAN')->get();

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
                  'A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@', 'F' => '@', 'G' => '@', 'H' => '@', 'I' => '@', 'J' => '@',
                  'K' => '@', 'L' => '@', 'M' => '@', 'N' => '@', 'O' => '@', 'P' => '@', 'Q' => '@', 'R' => '@', 'S' => '@', 'T' => '@',
                  'U' => '@', 'V' => '@', 'W' => '@', 'X' => '@', 'Y' => '@', 'Z' => '@', 'AA' => '@', 'AB' => '@', 'AC' => '@', 'AD' => '@',
                  'AE' => '@', 'AF' => '@', 'AG' => '@', 'AH' => '@', 'AI' => '@',
              ));
          });

          $excel->sheet('Data-Import-Kebakaran', function ($sheet) {
              $sheet->row(1, array('jumlah_pembiayaan', 'bln_3', 'bln_4', 'bln_5', 'bln_6', 'bln_7', 'bln_8', 'bln_9', 'bln_10', 'bln_11', 'bln_12', 'bln_13', 'bln_14', 'bln_15', 'bln_16', 'bln_17', 'bln_18', 'bln_19', 'bln_20', 'bln_21', 'bln_22', 'bln_23', 'bln_24', 'bln_25', 'bln_26', 'bln_27', 'bln_28', 'bln_29', 'bln_30', 'bln_31', 'bln_32', 'bln_33', 'bln_34', 'bln_35', 'bln_36'));
              $sheet->setColumnFormat(array(
                  'A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@', 'F' => '@', 'G' => '@', 'H' => '@', 'I' => '@', 'J' => '@',
                  'K' => '@', 'L' => '@', 'M' => '@', 'N' => '@', 'O' => '@', 'P' => '@', 'Q' => '@', 'R' => '@', 'S' => '@', 'T' => '@',
                  'U' => '@', 'V' => '@', 'W' => '@', 'X' => '@', 'Y' => '@', 'Z' => '@', 'AA' => '@', 'AB' => '@', 'AC' => '@', 'AD' => '@',
                  'AE' => '@', 'AF' => '@', 'AG' => '@', 'AH' => '@', 'AI' => '@',
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

          if (!empty($dataJiwa) && $dataJiwa->count()) {
            $getPlafonJiwa = Plafon::select('jumlah_pembiayaan')->where('jenis_plafon', 'JIWA')->distinct()->get();
            $getPlafonJiwa = $getPlafonJiwa->toArray();

            foreach ($dataJiwa->toArray() as $baris) {
              $biji = (int)$baris['jumlah_pembiayaan'];
              $check = in_array(['jumlah_pembiayaan' => $biji], $getPlafonJiwa);

              if($check == true)
              continue;

              $bulan3 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>3,"iuran"=>(int)$baris['bln_3'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan4 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>4,"iuran"=>(int)$baris['bln_4'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan5 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>5,"iuran"=>(int)$baris['bln_5'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan6 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>6,"iuran"=>(int)$baris['bln_6'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan7 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>7,"iuran"=>(int)$baris['bln_7'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan8 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>8,"iuran"=>(int)$baris['bln_8'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan9 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>9,"iuran"=>(int)$baris['bln_9'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan10 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>10,"iuran"=>(int)$baris['bln_10'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan11 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>11,"iuran"=>(int)$baris['bln_11'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan12 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>12,"iuran"=>(int)$baris['bln_12'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan13 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>13,"iuran"=>(int)$baris['bln_13'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan14 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>14,"iuran"=>(int)$baris['bln_14'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan15 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>15,"iuran"=>(int)$baris['bln_15'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan16 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>16,"iuran"=>(int)$baris['bln_16'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan17 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>17,"iuran"=>(int)$baris['bln_17'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan18 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>18,"iuran"=>(int)$baris['bln_18'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan19 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>19,"iuran"=>(int)$baris['bln_19'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan20 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>20,"iuran"=>(int)$baris['bln_20'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan21 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>21,"iuran"=>(int)$baris['bln_21'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan22 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>22,"iuran"=>(int)$baris['bln_22'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan23 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>23,"iuran"=>(int)$baris['bln_23'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan24 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>24,"iuran"=>(int)$baris['bln_24'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan25 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>25,"iuran"=>(int)$baris['bln_25'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan26 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>26,"iuran"=>(int)$baris['bln_26'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan27 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>27,"iuran"=>(int)$baris['bln_27'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan28 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>28,"iuran"=>(int)$baris['bln_28'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan29 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>29,"iuran"=>(int)$baris['bln_29'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan30 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>30,"iuran"=>(int)$baris['bln_30'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan31 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>31,"iuran"=>(int)$baris['bln_31'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan32 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>32,"iuran"=>(int)$baris['bln_32'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan33 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>33,"iuran"=>(int)$baris['bln_33'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan34 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>34,"iuran"=>(int)$baris['bln_34'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan35 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>35,"iuran"=>(int)$baris['bln_35'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bulan36 = array("jenis_plafon"=>"JIWA","jumlah_pembiayaan"=>$biji,"bulan"=>36,"iuran"=>(int)$baris['bln_36'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);

              $simpan = Plafon::insert(array($bulan3,$bulan4,$bulan5,$bulan6,$bulan7,$bulan8,$bulan9,$bulan10,$bulan11,
                                            $bulan12,$bulan13,$bulan14,$bulan15,$bulan16,$bulan17,$bulan18,$bulan19,$bulan20,
                                            $bulan21,$bulan22,$bulan23,$bulan24,$bulan25,$bulan26,$bulan27,$bulan28,$bulan29,
                                            $bulan30,$bulan31,$bulan32,$bulan33,$bulan34,$bulan35,$bulan36));

            }
          } else {
            return view('plafon.upload')->with('gagal', 'Silahkan Donload Template');
          }

          $dataKebakaran = Excel::selectSheets('Data-Import-Kebakaran')->load($path, function ($reader){})->get();

          if(!empty($dataKebakaran) && $dataKebakaran->count()) {
            $getPlafonKebakaran = Plafon::select('jumlah_pembiayaan')->where('jenis_plafon', 'KEBAKARAN')->distinct()->get();
            $getPlafonKebakaran = $getPlafonKebakaran->toArray();

            foreach ($dataKebakaran->toArray() as $baris) {
              $biji = (int)$baris['jumlah_pembiayaan'];
              $check = in_array(['jumlah_pembiayaan' => $biji], $getPlafonKebakaran);

              if($check == true)
              continue;

              $bln3 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>3,"iuran"=>(int)$baris['bln_3'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln4 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>4,"iuran"=>(int)$baris['bln_4'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln5 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>5,"iuran"=>(int)$baris['bln_5'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln6 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>6,"iuran"=>(int)$baris['bln_6'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln7 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>7,"iuran"=>(int)$baris['bln_7'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln8 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>8,"iuran"=>(int)$baris['bln_8'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln9 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>9,"iuran"=>(int)$baris['bln_9'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln10 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>10,"iuran"=>(int)$baris['bln_10'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln11 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>11,"iuran"=>(int)$baris['bln_11'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln12 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>12,"iuran"=>(int)$baris['bln_12'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln13 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>13,"iuran"=>(int)$baris['bln_13'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln14 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>14,"iuran"=>(int)$baris['bln_14'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln15 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>15,"iuran"=>(int)$baris['bln_15'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln16 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>16,"iuran"=>(int)$baris['bln_16'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln17 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>17,"iuran"=>(int)$baris['bln_17'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln18 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>18,"iuran"=>(int)$baris['bln_18'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln19 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>19,"iuran"=>(int)$baris['bln_19'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln20 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>20,"iuran"=>(int)$baris['bln_20'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln21 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>21,"iuran"=>(int)$baris['bln_21'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln22 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>22,"iuran"=>(int)$baris['bln_22'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln23 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>23,"iuran"=>(int)$baris['bln_23'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln24 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>24,"iuran"=>(int)$baris['bln_24'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln25 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>25,"iuran"=>(int)$baris['bln_25'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln26 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>26,"iuran"=>(int)$baris['bln_26'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln27 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>27,"iuran"=>(int)$baris['bln_27'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln28 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>28,"iuran"=>(int)$baris['bln_28'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln29 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>29,"iuran"=>(int)$baris['bln_29'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln30 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>30,"iuran"=>(int)$baris['bln_30'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln31 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>31,"iuran"=>(int)$baris['bln_31'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln32 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>32,"iuran"=>(int)$baris['bln_32'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln33 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>33,"iuran"=>(int)$baris['bln_33'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln34 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>34,"iuran"=>(int)$baris['bln_34'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln35 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>35,"iuran"=>(int)$baris['bln_35'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);
              $bln36 = array("jenis_plafon"=>"KEBAKARAN","jumlah_pembiayaan"=>$biji,"bulan"=>36,"iuran"=>(int)$baris['bln_36'],"deskripsi"=>"Sistem Upload","id_aktor"=>Auth::user()->id);

              $simpen = Plafon::insert(array($bln3,$bln4,$bln5,$bln6,$bln7,$bln8,$bln9,$bln10,$bln11,
                                            $bln12,$bln13,$bln14,$bln15,$bln16,$bln17,$bln18,$bln19,$bln20,
                                            $bln21,$bln22,$bln23,$bln24,$bln25,$bln26,$bln27,$bln28,$bln29,
                                            $bln30,$bln31,$bln32,$bln33,$bln34,$bln35,$bln36));

            }
          }else{
            return view('plafon.upload')->with('gagal', 'Silahkan Donload Template');
          }

          return redirect()->route('plafon.upload')->with('berhasil', 'Sukses Upload Skema Baru');

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
