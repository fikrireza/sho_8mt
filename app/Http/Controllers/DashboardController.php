<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bmt;
use App\Models\Anggota;
use App\Models\Iuran;
use App\Models\Klaim;
use App\Models\Akad;

use Auth;
use DB;

class DashboardController extends Controller
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
        $date = date('Y-m');

        if(Auth::user()->id_bmt == null){
          $getBmt = Bmt::get();

          $getAnggota = Anggota::get();

          $getAkad = Akad::get();

          $getIuran = Iuran::where('tanggal_iuran', 'like', '%'.$date.'%')->get();

          $getKlaim = Klaim::where('created_at', 'like', '%'.$date.'%')->get();

        }else{
          $getAnggota = Anggota::where('id_bmt', Auth::user()->id_bmt)->get();

          $getAkad = Akad::whereHas('anggota', function($query){
                                    $query->where('id_bmt', Auth::user()->id_bmt);
                                    })
                          ->get();

          $getIuran = Iuran::where('tanggal_iuran', 'like', '%'.$date.'%')
                            ->whereHas('akad.anggota', function($query){
                              $query->where('id_bmt', Auth::user()->id_bmt);
                            })
                            ->get();

          $getKlaim = Klaim::where('created_at', 'like', '%'.$date.'%')
                            ->whereHas('akad.anggota', function($query){
                              $query->where('id_bmt', Auth::user()->id_bmt);
                            })
                            ->get();

        }

        return view('dashboard.index', compact('getBmt', 'getAnggota', 'getIuran', 'getKlaim', 'getAkad'));
    }
}
