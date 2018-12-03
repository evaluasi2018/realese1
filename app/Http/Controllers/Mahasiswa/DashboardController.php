<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class DashboardController extends Controller
{
	// public function __construct()
 //    {
 //        $this->middleware('auth:mahasiswa');
 //    }

    public function index()
    {
        if (Session::get('login')) {
          if (Session::get('akses_mahasiswa')) {
            return view('mahasiswa/dashboard'); 
          }
          else
          {
            return redirect()->route('sievaluasi.loginform');
          }
        }
        else
        {
            return redirect()->route('sievaluasi.loginform');
        }
    }
}
