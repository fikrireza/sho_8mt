<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

class DashboardController extends Controller
{


    public function index()
    {
        // dd(session('status'));
        return view('dashboard.index');
    }
}
