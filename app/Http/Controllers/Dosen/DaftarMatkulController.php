<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use Session;
use DB;

class DaftarMatkulController extends Controller
{
    public function daftarMatkul($nip, $klsSemId)
    {
    	$panda = new LoginController();
        if (!Session::get('login')) {
          return redirect()->route('sievaluasi.loginform');
        }
        else
        {
            if(Session::get('akses_dosen'))
            {
		    	$matkul = '
					
					{dosen(dsnPegNip:"'.Session::get('nip').'") {
					  dsnPegNip
					  pegawai {
					    pegNip
					    pegNama
					    pegGelarDepan
					    pegGelarBelakang
					    pegIsAktif
					  }
					  kelas(klsSemId:'.$klsSemId.') {
					    klsId
					    klsSemId
					    klsNama
					    klsIsBatal
					    klsMkkurId
					    matakuliah {
					      mkkurId
					      mkkurKode
					      mkkurNamaResmi
					      mkkurProdiKode
					      mkkurJumlahSksKurikulum
					      mkkurJumlahSksTeori
					      mkkurJumlahSksPraktikum
					      mkkurJumlahSksPraktikumLapangan
					    }
					  }
					}}
				
		    	';
		    	$mk = $panda->panda($matkul);
		                $data = array(
		                    'title'     => 'Data Mata Kuliah',
		                    'data'      => $mk,
		                );
		                // return response()->json($mk);
		                return view('dosen/daftar_matkul')->with('data',$data);
		    }
		    else
            {
                return redirect()->route('sievaluasi.loginform');
            }
		}
    }

    public function hasilEvaluasiDetail($nip, $klsSemId, $id_matkul, $id_kelas)
    {
    	$panda = new LoginController();
        if (!Session::get('login')) {
          return redirect()->route('sievaluasi.loginform');
        }
        else
        {
            if(!empty(Session::get('akses_dosen')))
            {

              $jenis = DB::table('tb_jenis_indikator')
                      ->select('nm_jenis_indikator')
                      ->get();


              $data_nilai = DB::table('tb_evaluasi')
                        ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                        ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                        ->select('tb_jenis_indikator.nm_jenis_indikator','tb_evaluasi.id_matkul','tb_evaluasi.id_kelas','tb_evaluasi.nip','tb_evaluasi.semester',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'))
                        ->where('tb_evaluasi.nip',$nip)
                        ->where('tb_evaluasi.id_matkul',$id_matkul)
                        ->where('tb_evaluasi.semester',$klsSemId)
                        ->where('tb_evaluasi.id_kelas',$id_kelas)
                        ->groupBy('tb_evaluasi.nip')
                        ->get();
                        // dd($matkul);


                        // return response()->json($data_detail);
                // $kelas = $klsId;
                // dd($kelas);
                $datas = '

                    {kelas(klsId:'.$id_kelas.') {
                      klsId
                      klsNama
                      
                      matakuliah {
                        mkkurKode
                        mkkurNamaResmi
                        prodi {
                          prodiKode
                          prodiNamaResmi
                        }
                      }
                    }}


                ';
                $matkul = $panda->panda($datas);
                // foreach($matkul['kelas'][0]['dosen'] as $arr){
                //     if($arr['pegawai']['pegNip']!=$nip){
                //         continue;
                //     }
                //     $nama = $arr['pegawai']['pegNama'];
                //     $nip = $arr['pegawai']['pegNip'];
                    
                // }
                // dd($matkul);
                $prodi = $matkul['kelas'][0]['matakuliah']['prodi']['prodiNamaResmi'];
                $matkul = $matkul['kelas'][0]['matakuliah']['mkkurNamaResmi'];
                // $id_matkul = $id_matkul;
                // $id_matkul = $matkul['kelas'][0]['matakuliah']['mkkurKode'];
                // dd($id_matkul);
                $data = array(
                    'title'     => 'Data Mata Kuliah',
                    'data'      => $matkul,
                    // 'nama'      => $nama,
                    'nip'      => $nip,
                    'isi'       => 'mahasiswa/daftar_matkul'
                );
                Session::put('prodi',$prodi);
                Session::put('matkul',$matkul);
                // Session::put('nip',$nip);
                // Session::put('id_matkul',$id_matkul);
                // dd($data);
                
                // dd($data);
                // dd($data['data']['kelas'][0]['dosen'][0]['pegawai']['pegNama']);
                // $a=1;
                return view('dosen/hasil_evaluasi_detail')->with('data',$data)->with('nilai',$data_nilai)->with('jenis',$jenis);
            }
        }
    }
}
