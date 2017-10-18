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
        $id_bmt = Auth::user()->id_bmt;

        if(Auth::user()->id_bmt == null){
          $getAkad = Akad::get();
        }else{
          $getAkad = Akad::whereHas('anggota.bmt', function($query) use($id_bmt){
                                  $query->where('id_bmt',$id_bmt);
                                })
                          ->get();
        }

        return view('akad.index', compact('getAkad'));
    }

    public function tambah()
    {
        $id_bmt = Auth::user()->id_bmt;

        if(Auth::user()->id_bmt == null){
          $getAnggota = Anggota::get();
        }else{
          $getAnggota = Anggota::where('id_bmt', $id_bmt)->get();
        }

        return view('akad.tambah', compact('getAnggota'));
    }

    public function store(Request $request)
    {

        $message = [
          'kode_akad.required' => 'Wajib di isi',
          'kode_akad.unique' => 'Kode Sudah Dipakai',
          'id_anggota.required' => 'Wajib di isi',
          'tanggal_akad.required' => 'Wajib di isi',
          'jenis_plafon.required' => 'Wajib di isi',
          'jumlah_pembiayaan.required' => 'Wajib di isi',
          'bulan.required' => 'Wajib di isi',
          'keterangan.required' => 'Wajib di isi',
          'jenis_pembayaran.required' => 'Wajib di isi',
        ];

        $validator = Validator::make($request->all(), [
          'kode_akad' => 'required|unique:fra_akad',
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
                        ->where('flag_status', 'A')
                        ->where('tanggal_lunas', null)
                        ->first();

        if($cekAkad){
          if($cekAkad->plafon->jenis_plafon == $request->jenis_plafon){
            return redirect()->route('akad.tambah')->withErrors($validator)->withInput()->with('gagal', 'Anggota Masih Memiliki Tanggungan '.$cekAkad->kode_akad.' Dan Belum Lunas');
          }
        }
        // End Cek Validasi


        DB::transaction(function() use($request){

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
          // Belum Approve = BA; Approve = A; Cancel = C; Lunas = L;
          $save->flag_status = 'BA';
          $save->save();

          $log = new LogAkses;
          $log->aksi = 'Membuat Akad baru '.$request->no_akad;
          $log->id_aktor = Auth::user()->id;
          $log->save();
        });


        return redirect()->route('akad.index')->with('berhasil', 'Berhasi Membuat Akad Baru');

    }

    public function approve($id)
    {
        $getAkad = Akad::find($id);

        if(!$getAkad){
          abort(404);
        }

        return view('akad.approve', compact('getAkad'));
    }

    public function approveStore(Request $request)
    {

        $getAkad = Akad::find($request->id);

        if(!$getAkad){
          abort(404);
        }

        // Cek Validasi Akad Anggota
        $cekAkad = Akad::where('id_anggota', $request->id_anggota)
                        ->where('flag_status', 'A')
                        ->where('tanggal_lunas', null)
                        ->first();

        if($cekAkad && ($request->approval == 'A')){
          if($cekAkad->plafon->jenis_plafon == $request->jenis_plafon){
            return redirect()->route('akad.approve', $request->id)->withInput()->with('gagal', 'Anggota Masih Memiliki Tanggungan '.$cekAkad->kode_akad.' Dan Belum Lunas');
          }
        }
        // End Cek Validasi

        DB::transaction(function () use($getAkad, $request) {

          $tahun = date('y');
          $bulan = date('m');
          $hari = date('d');
          $rand = rand(1000,9999);

          $no_persetujuan = 'APP/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$rand;

          $save = new Persetujuan;
          $save->id_akad = $getAkad->id;
          $save->no_persetujuan = $no_persetujuan;
          $save->tangal_persetujuan = date('Y-m-d');
          $save->status_persetujuan = $request->approval;
          $save->keterangan = 'Self Approved';
          $save->id_aktor = Auth::user()->id;
          $save->save();

          $getAkad->approved_by = Auth::user()->id;
          $getAkad->approved_date = date('Y-m-d');
          $getAkad->flag_status = $request->approval;
          $getAkad->update();

          $log = new LogAkses;
          if($request->approval == 'A'){
            $log->aksi = 'Menyetujui Akad '.$getAkad->kode_akad;
          }else{
            $log->aksi = 'Membatalkan Akad '.$getAkad->kode_akad;
          }
          $log->id_aktor = Auth::user()->id;
          $log->save();

        });

        return redirect()->route('akad.index')->with('berhasil', 'Akad berhasil disetujui');
    }


}
