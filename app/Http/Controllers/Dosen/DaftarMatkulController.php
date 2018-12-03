<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use Session;

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
                // $kelas = $klsId;
                // dd($kelas);
                $datas = '

                    {kelas(klsId:'.$id_kelas.') {
                      klsId
                      klsNama
                      klsSemId
                      dosen {
                        dsnPegNip
                        dsnNidn
                        pegawai {
                          pegNip
                          pegNama
                          pegGelarDepan
                          pegGelarBelakang
                          pegIsAktif
                          pegTanggalLahir
                          pegGolrKodePns
                        }
                      }
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
                foreach($matkul['kelas'][0]['dosen'] as $arr){
                    if($arr['pegawai']['pegNip']!=$nip){
                        continue;
                    }
                    $nama = $arr['pegawai']['pegNama'];
                    $nip = $arr['pegawai']['pegNip'];
                    
                }
                // dd($matkul);
                $prodi = $matkul['kelas'][0]['matakuliah']['prodi']['prodiNamaResmi'];
                $matkul = $matkul['kelas'][0]['matakuliah']['mkkurNamaResmi'];
                $id_matkul = $id_matkul;
                // $id_matkul = $matkul['kelas'][0]['matakuliah']['mkkurKode'];
                // dd($id_matkul);
                $data = array(
                    'title'     => 'Data Mata Kuliah',
                    'data'      => $matkul,
                    'nama'      => $nama,
                    'nip'      => $nip,
                    'isi'       => 'mahasiswa/daftar_matkul'
                );
                Session::put('prodi',$prodi);
                Session::put('matkul',$matkul);
                Session::put('nip',$nip);
                Session::put('id_matkul',$id_matkul);
                // dd($data);
                
                // dd($data);
                // dd($data['data']['kelas'][0]['dosen'][0]['pegawai']['pegNama']);
                // $a=1;
                return view('dosen/hasil_evaluasi_detail');
            }
        }
    }
}
