<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Jurnal;
use App\Models\Akad;
use App\Models\Iuran;
use App\Models\Bmt;

use Auth;
use DB;

class JurnalController extends Controller
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
          $getBmt = Bmt::find(Auth::user()->id_bmt);
        }

        return view('jurnal.index', compact('getBmt'));
    }

    public function post(Request $request)
    {
        if($request->id_bmt == 'ALL'){
          $getJurnal = Jurnal::where('tanggal_jurnal', 'like', '%'.$request->tanggal_jurnal.'%')->get();
        }else{
          $getJurnal = Jurnal::whereHas('akad.anggota.bmt', function($query) use($request){
                                        $query->where('id_bmt', $request->id_bmt);
                                      })
                              ->where('tanggal_jurnal', 'like', '%'.$request->tanggal_jurnal.'%')
                              ->get();
        }

        $bulan = $request->tanggal_jurnal;

        $getBmt = Bmt::get();

        return view('jurnal.index', compact('getJurnal', 'bulan', 'getBmt'));
    }
}
