<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akad;
use App\Models\Anggota;
use App\Models\Bmt;
use App\Models\Iuran;
use App\Models\Jurnal;
use App\Models\LogAkses;
use App\Models\Klaim;

use Auth;
use DB;
use Excel;
use Validator;
use DateTime;
use PDF;

class LaporanController extends Controller
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
          $getBmt = Bmt::get();
        }else{
          $getBmt = Auth::user()->id_bmt;
        }

        return view('laporan.index', compact('getBmt'));
    }

    public function store(Request $request)
    {
        $now = date('Y-m');
        if($request->pilih_bulan > $now){
          return redirect()->route('laporan.index')->with('gagal', 'Maximal Bulan Berjalan');
        }

        $getBmt = Bmt::find($request->id_bmt);
        if(!$getBmt){
          return redirect()->route('laporan.index')->with('gagal', 'BMT Tidak Ada');
        }

        $getAnggota = Anggota::where('id_bmt', $request->id_bmt)->get();
        $getAkad = Akad::whereHas('anggota.bmt',
                              function($query) use($request){
                                $query->where('id_bmt', $request->id_bmt);
                              })
                        ->get();

        $getIuran = Iuran::whereHas('akad.anggota.bmt',
                              function($query) use($request){
                                $query->where('id_bmt', $request->id_bmt);
                              })
                        ->where('tanggal_iuran', 'like', '%'.$request->pilih_bulan.'%')
                        ->get();

        $getKlaim = Klaim::whereHas('akad.anggota.bmt',
                              function($query) use($request){
                                $query->where('id_bmt', $request->id_bmt);
                              })
                        ->get();

        $jumlahPembiayaan = 0;
        $totalPlafon = 0;
        $totalIuran = 0;
        foreach ($getAkad as $akad) {
          $jumlahPembiayaan += 1;

          $rowdata = array();
          $rowdata['no_ktp'] = $akad->anggota->no_ktp;
          $rowdata['kode_anggota']  = $akad->anggota->kode_anggota;
          $rowdata['nama_anggota']  = $akad->anggota->nama_anggota;
          $rowdata['tanggal_lahir'] = $akad->anggota->tanggal_lahir;

          // Hitung Usia
          $bday = new DateTime($akad->anggota->tanggal_lahir);
          $today = new DateTime();
          $diff = $today->diff($bday);
          $rowdata['usia'] = $diff->y;

          $rowdata['pekerjaan'] = $akad->anggota->jenis_usaha;
          $rowdata['alamat'] = $akad->anggota->alamat;
          $rowdata['kode_pos'] = $akad->anggota->kode_pos;
          $rowdata['jenis_kelamin'] = $akad->anggota->jenis_kelamin;
          $rowdata['no_telp'] = $akad->anggota->no_telp;

          $rowdata['jenis_usaha'] = $akad->anggota->jenis_usaha;
          $rowdata['lokasi_usaha'] = $akad->anggota->lokasi_usaha;

          $rowdata['jenis_plafon']  = $akad->plafon->jenis_plafon;
          $rowdata['jumlah_pembiayaan']  = $akad->plafon->jumlah_pembiayaan;
          $totalPlafon += $rowdata['jumlah_pembiayaan'];

          $rowdata['jangka_waktu']  = $akad->plafon->bulan;

          // Status Akad
          if($akad->flag_status == "BA"){
            $rowdata['status_akad'] = "Belum Approve";
            $rowdata['approve_by'] = $akad->approved_by;
          }elseif($akad->flag_status == "A"){
            $rowdata['status_akad'] = "Approved";
            $rowdata['approve_by'] = $akad->approveBy->name;
          }elseif($akad->flag_status == "C") {
            $rowdata['status_akad'] = "Batal/Cancel";
            $rowdata['approve_by'] = $akad->approved_by;
          }elseif($akad->flag_status == "L") {
            $rowdata['status_akad'] = "Lunas";
            $rowdata['approve_by'] = $akad->approved_by;
          }else{
            $rowdata['status_akad'] = "Klaim";
            $rowdata['approve_by'] = $akad->approved_by;
          }

          // Tanggal Klaim
          $tanggal_klaim = null;
          foreach ($getKlaim as $klaim) {
            if($klaim->id_akad == $akad->id){
              $tanggal_klaim = $klaim->tanggal_musibah;
            }
          }
          $rowdata['tanggal_klaim'] = $tanggal_klaim;

          // Hitung Tempo
          $bulan = $akad->plafon->bulan;
          $date = new DateTime($akad->tanggal_akad);
          $date->modify('+'.$bulan.' month');
          $rowdata['jatuh_tempo']  = $date->format('Y-m-d');

          $jumlahIuran = 0;
          foreach ($getIuran as $iuran) {
            if($iuran->id_akad == $akad->id){
              $jumlahIuran += $iuran->nilai_iuran;
            }
          }
          $rowdata['jumlah_iuran'] = $jumlahIuran;
          $totalIuran += $rowdata['jumlah_iuran'];

          $rekap[] = $rowdata;
        }

        view()->share('rekap', $rekap);
        view()->share('jumlahPembiayaan', $jumlahPembiayaan);
        view()->share('totalPlafon', $totalPlafon);
        view()->share('totalIuran', $totalIuran);
        view()->share('nama_bmt', $getBmt->nama_bmt);
        view()->share('no_induk_bmt', $getBmt->no_induk_bmt);
        view()->share('laporan', $request->pilih_bulan);

        $pdf = PDF::loadView('laporan.export')->setPaper('legal', 'landscape');
        return $pdf->download('Laporan BMT - '.$getBmt->no_induk_bmt.' Bulan '.$request->pilih_bulan.'.pdf');

        return view('laporan.export', compact('rekap', 'jumlahPembiayaan', 'totalPlafon', 'totalIuran', 'getBmt', 'request'));

    }
}
