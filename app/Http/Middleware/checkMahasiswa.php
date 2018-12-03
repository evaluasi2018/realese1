<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class checkMahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->get('akses_mahasiswa') !=== 'Mahasiswa')
        {
            return redirect()->route('sievaluasi.loginform');
        }
        elseif($request->session()->get('akses_mahasiswas') === 'Mahasiswa')
        {
            return view('mahasiswa/dashboard');
        }
        return $next($request);

        
    }
}
