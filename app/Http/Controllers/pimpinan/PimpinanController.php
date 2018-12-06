<?php

namespace App\Http\Controllers\pimpinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Auth;
use App\Http\Controllers\LoginController;

class PimpinanController extends Controller
{
    public function prodi()
    {
    	if(Session::get('login')) {
            if(isset(Auth::guard()->user()->level) && Auth::guard()->user()->level == "prodi") {
                return view('pimpinan/dashboard_prodi');
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

    public function prodiDaftarDosen($prodiKode)
    {
    	$panda = new LoginController();
    	$data_dosen = '
			{prodi(prodiKode:'.Session::get('kode_prodi').') {
			  prodiKode
			  dosen {
			    dsnPegNip
			    dsnNidn
			    dsnSikjKode
			    ikatanKerja
			    dsnJbakrId
			    jabatanAkademik
			    dsnSadrKode
			    statusAktif
			    pegawai {
			      pegNip
			      pegNama
			      pegGelarDepan
			      pegGelarBelakang
			      pegIsAktif
			    }
			  }
			}}
    	';

    	 $dosen = $panda->panda($data_dosen);
    	 // dd($dosen);
    	 $data = array(
		    'title'     => 'Data Mata Kuliah',
		    'data'      => $dosen,
		);

    	return view('pimpinan/prodi_daftar_dosen')->with('dosen',$dosen);
    }

    public function prodiLaporanDosen($pegNip,$pegNama)
    {
    	$panda = new LoginController();
    	// dd($pegNama);
    	// dd(Session::get('nip_dosen'));
    	$lp_pimpinan_dosen = DB::table('tb_evaluasi')
    						->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
    						->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
    						->select('tb_evaluasi.nip','tb_evaluasi.nm_dosen','tb_jenis_indikator.nm_jenis_indikator',DB::raw('SUM(nilai)/count(npm) as rata'))
    						->where('tb_evaluasi.nip',$pegNip)
    						->groupBy('tb_jenis_indikator.id_jenis_indikator')
    						->get();
    						// return response()->json($lp_pimpinan_dosen);

					    	Session::put('nip_dosen',$pegNip);
					    	Session::put('nm_dosen',$pegNama);
    	return view('pimpinan/prodi_laporan_dosen')->with('lp_pimpinan_dosen',$lp_pimpinan_dosen);
    }

    public function fakultas()
    {
        if(Session::get('login')) {
            if(isset(Auth::guard()->user()->level) && Auth::guard()->user()->level == "fakultas") {
                return view('pimpinan/dashboard_fakultas');
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

    public function fakultasDaftarDosen($fakKode)
    {
        $panda = new LoginController();
        $data_fakultas = '
            {fakultas(fakKode:'.Session::get('kode_fak').') {
              fakKode
              fakKodeUniv
              fakNamaResmi
              prodi {
                prodiKode
                prodiNamaResmi
                prodiFakKode
                prodiKodeUniv
                count_mahasiswa
                dosen {
                  dsnPegNip
                  ikatanKerja
                  statusAktif
                  jabatanAkademik
                  pegawai {
                    pegNip
                    pegNama
                    pegGelarDepan
                    pegGelarBelakang
                    pegIsAktif
                  }
                }
              }
            }}
        ';

         $dosen = $panda->panda($data_fakultas);
         // dd($dosen);
         $data = array(
            'title'     => 'Data Mata Kuliah',
            'data'      => $dosen,
        );

        return view('pimpinan/fakultas_daftar_dosen')->with('dosen',$dosen);
    }

    public function fakultasLaporanDosen($pegNip,$pegNama,$prodiKode)
    {
        // $panda = new LoginController();
        // dd($pegNama);
        // dd(Session::get('nip_dosen'));
        $lp_pimpinan_dosen = DB::table('tb_evaluasi')
                            ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                            ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                            ->select('tb_evaluasi.nip','tb_evaluasi.nm_dosen','tb_evaluasi.id_prodi','tb_jenis_indikator.nm_jenis_indikator',DB::raw('SUM(nilai)/count(npm) as rata'))
                            ->where('tb_evaluasi.nip',$pegNip)
                            // ->where('tb_evaluasi.id_prodi',$prodiKode)
                            ->groupBy('tb_jenis_indikator.id_jenis_indikator')
                            ->get();
                            // return response()->json($lp_pimpinan_dosen);

                            Session::put('nip_dosen',$pegNip);
                            Session::put('nm_dosen',$pegNama);
        return view('pimpinan/fakultas_laporan_dosen')->with('lp_pimpinan_dosen',$lp_pimpinan_dosen);
    }

    public static function getProdi($prodiKode)
    {
        $panda = new LoginController();

        $data_prodi = '
            {prodi(prodiKode:'.$prodiKode.') {
              prodiKode
              prodiNamaResmi
            }}
        ';

        $prodi = $panda->panda($data_prodi);

        return $prodi['prodi'][0]['prodiNamaResmi'];

    }

}
