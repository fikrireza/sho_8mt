<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LogAkses;

class LogAksesController extends Controller
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

        $getLog = LogAkses::where('created_at', 'like', '%'.$tahun.'%')->get();

        $request = $request->tahun;

        return view('logakses.index', compact('getLog','request'));
    }
}
