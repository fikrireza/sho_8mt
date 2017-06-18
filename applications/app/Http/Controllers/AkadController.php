<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akad;
use App\Models\Plafon;
use App\Models\Anggota;
use App\Models\Bmt;
use App\Models\Pembayaran;
use App\Models\Persetujuan;
use App\Models\User;
use App\Models\LogAkses;

use Validator;
use DB;
use Auth;


class AkadController extends Controller
{

    public function index()
    {
        $getAkad = Akad::get();

        return view('akad.index', compact('getAkad'));
    }

    public function tambah()
    {
        $id_bmt = Auth::user()->id_bmt;

        if(session('status') == 'pbmt'){
          $getAnggota = Anggota::get();
        }else{
          $getAnggota = Anggota::where('id_bmt', $id_bmt)->get();
        }

        $getPlafon = Plafon::get();

        $getBmt = BMT::where('id', $id_bmt)->first();

        $tahun = date('y');
        $bulan = date('m');
        $hari = date('d');
        $rand = rand(1000,9999);

        $kode_akad = $getBmt->no_induk_bmt.'/AKAD/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$rand;
        $cek_kode_akad = Akad::where('kode_akad', $kode_akad)->first();

        if(!$cek_kode_akad){
          $kode_akad;
        }else{
          $kode_akad = 'Kode Akad BMT Habis - Contact Fikri Please';
        }

        return view('akad.tambah', compact('getAnggota', 'getPlafon', 'kode_akad'));
    }

    public function store(Request $request)
    {

        $message = [
          'kode_akad.required' => 'Wajib di isi',
          'id_anggota.required' => 'Wajib di isi',
          'tanggal_akad.required' => 'Wajib di isi',
          'jenis_plafon.required' => 'Wajib di isi',
          'jumlah_pembiayaan.required' => 'Wajib di isi',
          'bulan.required' => 'Wajib di isi',
          'keterangan.required' => 'Wajib di isi',
          'jenis_pembayaran.required' => 'Wajib di isi',
        ];

        $validator = Validator::make($request->all(), [
          'kode_akad' => 'required',
          'id_anggota' => 'required',
          'tanggal_akad' => 'required',
          'jenis_plafon' => 'required',
          'jumlah_pembiayaan' => 'required',
          'bulan' => 'required',
          'keterangan' => 'required',
          'jenis_pembayaran' => 'required',
        ], $message);

        if($validator->fails())
        {
            return redirect()->route('akad.tambah')->withErrors($validator)->withInput();
        }

        // Cek Validasi Akad Anggota
        $cekAkad = Akad::where('id_anggota', $request->id_anggota)
                        ->where('flag_status', 1)
                        ->where('flag_lunas', 0)
                        ->first();
// dd($cekAkad);
        if($cekAkad){
          return redirect()->route('akad.tambah')->withErrors($validator)->withInput()->with('gagal', 'Anggota Masih Memiliki Tanggungan '.$cekAkad->kode_akad);
        }
        // End Cek Validasi

        $getPlafon = Plafon::where('jenis_plafon', $request->jenis_plafon)
                            ->where('jumlah_pembiayaan', $request->jumlah_pembiayaan)
                            ->where('bulan', $request->bulan)
                            ->first();

        $save = new Akad;
        $save->id_plafon = $getPlafon->id;
        $save->id_anggota = $request->id_anggota;
        $save->kode_akad = $request->kode_akad;
        $save->tanggal_akad = $request->tanggal_akad;
        $save->keterangan = $request->keterangan;
        $save->jenis_pembayaran  = $request->jenis_pembayaran;
        $save->id_aktor = Auth::user()->id;
        // 1 = akif
        $save->flag_status = 1;
        $save->save();

        $log = new LogAkses;
        $log->aksi = 'Membuat Akad baru '.$request->no_akad;
        $log->aktor = Auth::user()->id;
        $log->save();


        return redirect()->route('akad.index')->with('berhasil', 'Berhasi Membuat Akad Baru');

    }

    public function approve($id)
    {
        $getAkad = Akad::find($id);

        if(!$getAkad){
          abort(404);
        }

        DB::transaction(function () use($getAkad) {

          $tahun = date('y');
          $bulan = date('m');
          $hari = date('d');
          $rand = rand(1000,9999);

          $no_persetujuan = Auth::user()->bmt->no_induk_bmt.'/APP/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$rand;
          $cek_no_persetujuan = Persetujuan::where('no_persetujuan', $no_persetujuan)->first();

          if(!$cek_no_persetujuan){
            $no_persetujuan;
          }else{
            $no_persetujuan = 'Kode Approve Akad BMT Habis - Contact Fikri Please';
          }

          $save = new Persetujuan;
          $save->no_persetujuan = $no_persetujuan;
          $save->tangal_persetujuan = date('Y-m-d');
          $save->keterangan = 'Self Approved';
          $save->id_akad = $getAkad->id;
          $save->status_akad = 1;
          $save->flag_status = 1;
          $save->id_anggota = Auth::user()->id;
          $save->id_aktor = Auth::user()->id;
          $save->save();

          $getAkad->approved_by = Auth::user()->id;
          $getAkad->approved_date = date('Y-m-d');
          $getAkad->update();

          $log = new LogAkses;
          $log->aksi = 'Menyetujui Akad '.$getAkad->kode_akad;
          $log->aktor = Auth::user()->id;
          $log->save();

        });

        return redirect()->route('akad.index')->with('berhasil', 'Akad berhasil disetujui');
    }


}
