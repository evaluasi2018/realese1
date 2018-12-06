<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Evaluasi;
use Yajra\DataTables\DataTables;
use PDF;
use Auth;
use App\Http\Controllers\LoginController;
use Carbon\Carbon;
use Session;

class LaporanEvaluasiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // public function laporanDetail()
   	// {
   	// 	return view('admin/laporan_evaluasi.detail');
   	// }
   	
   	// public function apiLaporanDetail()
    // {
    //    DB::statement(DB::raw('set @rownum=0'));
    //     $laporan = DB::table('tb_evaluasi')
    //           ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
    //           ->select('nm_dosen','nm_matkul','id_kelas','indikator',DB::raw('sum(nilai)as totalnilai'),DB::raw('@rownum  := @rownum  + 1 AS rownum'))
    //           ->groupBy('tb_evaluasi.id_indikator','nip')
    //           ->orderBy('id_evaluasi')
    //           ->get();
    //     return Datatables::of($laporan)
    //         ->addColumn('action',function($laporan){
    //         })->make(true);
            
    // }

    // public function detailExportPDF()
    // {
    //   $laporans = DB::table('tb_evaluasi')
    //           ->join('tb_jadwal_perkuliahan','tb_jadwal_perkuliahan.id_jadwal_perkuliahan','=','tb_evaluasi.id_jadwal_perkuliahan')
    //           ->join('tb_mahasiswa','tb_mahasiswa.npm','=','tb_evaluasi.npm')
    //           ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','=','tb_evaluasi.id_indikator')
    //           ->join('tb_matkul','tb_matkul.id_matkul','=','tb_jadwal_perkuliahan.id_matkul')
    //           ->join('tb_dosen','tb_dosen.nip','=','tb_jadwal_perkuliahan.nip')
    //           ->join('tb_semester','tb_semester.id_semester','=','tb_jadwal_perkuliahan.id_semester')
    //           ->join('tb_prodi','tb_prodi.id_prodi','=','tb_matkul.id_prodi')
    //           ->join('tb_fakultas','tb_fakultas.id_fakultas','=','tb_prodi.id_fakultas')
    //           ->select('tb_evaluasi.id_evaluasi','tb_dosen.nm_dosen','tb_matkul.nm_matkul','tb_prodi.nm_prodi','tb_fakultas.nm_fakultas','tb_jadwal_perkuliahan.kelas','tb_evaluasi.id_indikator',DB::raw('sum(nilai)as totalnilai'))
    //           ->groupBy('tb_evaluasi.id_indikator','tb_evaluasi.id_jadwal_perkuliahan')
    //           ->get();
    //   $pdf = PDF::loadView('admin/laporan_evaluasi.detailpdf', compact('laporans'));
    //   $pdf->setPaper('a4','portrait');
    //   return $pdf->stream();
    // }

    public function laporanPerJenis()
    {
      $panda = new LoginController();
      $data_fakultas = '
        {fakultas {
          fakKode
          fakKodeUniv
          fakNamaResmi
          
        }}
      ';

      $data_univ = $panda->panda($data_fakultas);
      // dd($data_univ);
      Session::put('fakultas',$data_univ['fakultas']);
      return view('admin/laporan_evaluasi.laporan_per_jenis');
    }

    public function cariProdi(Request $request)
    {
      $panda = new LoginController();
      $data_prodi = '
        {fakultas(fakKode:'.$request->id.') {
          fakKode
          fakKodeUniv
          prodi {
            prodiKode
            prodiNamaResmi
            prodiFakKode
            prodiKodeUniv
            prodiJjarKode
            prodiSahrKode
            dosen {
              dsnPegNip
            }
          }
        }}
      ';
      $data_prodi = $panda->panda($data_prodi);
      return response()->json($data_prodi);
    }

    public function cariDosen(Request $request)
    {
      $panda = new LoginController();
      $data_dosen = '
        
        {prodi(prodiKode:'.$request->id.') {
          prodiKode
          prodiNamaResmi
          prodiFakKode
          pegawai(pegIsAktif:1) {
            pegNip
            pegNama
            pegGelarDepan
            pegGelarBelakang
          }
      }}

      ';
      $data_dosen = $panda->panda($data_dosen);
      return response()->json($data_dosen);
    }

    public function cariMatkul(Request $request)
    {
      $panda = new LoginController();
      $bulan = date('m',time());
      if($bulan>=1 && $bulan<=6)
      {
          $tahun = Carbon::now()->format('Y').'2';
      }
      elseif ($bulan>=7 && $bulan<=12) {
          $tahun = Carbon::now()->format('Y').'1';
      }
      $data_matkul = '
        {dosen(dsnPegNip:'.$request->id.') {
          dsnPegNip
          kelas(klsSemId:'.$tahun.') {
            klsId
            klsSemId
            klsNama
            matakuliah {
              mkkurId
              mkkurKode
              mkkurNamaResmi
              mkkurProdiKode
              prodi {
                prodiKode
                prodiNamaResmi
              }
            }
          }
        }}
      ';
      $data_matkul = $panda->panda($data_matkul);
      return response()->json($data_matkul);
    }

    public function apilaporanPerJenis(Request $request)
    {
      if (isset($_GET['submit'])) {
        $jenis = DB::table('tb_jenis_indikator')
              ->select('nm_jenis_indikator')
              ->get();
        if (empty($_GET['fakultas'])) {
          $data = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                  ->select('id_prodi','id_fakultas','tb_jenis_indikator.nm_jenis_indikator','nip',DB::raw('SUM(nilai)/count(npm) as rata'))
                  ->groupBy('tb_evaluasi.nip')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_jenis',compact('data','jenis'));
        }
        elseif (!empty($_GET['fakultas'] && empty($_GET['prodi']))) {
          $data_fakultas = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                  ->select('id_prodi','id_fakultas','tb_jenis_indikator.nm_jenis_indikator','nip',DB::raw('SUM(nilai)/count(npm) as rata'))
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->groupBy('tb_evaluasi.nip')
                  ->get();
          // return response()->json($data_fakultas);
          return view('admin/laporan_evaluasi.laporan_per_jenis',compact('data_fakultas','jenis'));
        }
        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && empty($_GET['dosen']))) {
           $data_prodi = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                  ->select('id_prodi','id_fakultas','tb_jenis_indikator.nm_jenis_indikator','nip',DB::raw('SUM(nilai)/count(npm) as rata'))
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->where('tb_evaluasi.id_prodi',$_GET['prodi'])
                  ->groupBy('tb_evaluasi.nip')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_jenis',compact('data_prodi','jenis'));
        }
        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && !empty($_GET['dosen']) && empty($_GET['matkul']) )) {
          $data_dosen = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                  ->select('id_prodi','id_fakultas','tb_jenis_indikator.nm_jenis_indikator','nip',DB::raw('SUM(nilai)/count(npm) as rata'))
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->where('tb_evaluasi.id_prodi',$_GET['prodi'])
                  ->where('tb_evaluasi.nip',$_GET['dosen'])
                  ->groupBy('tb_evaluasi.nip')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_jenis',compact('data_dosen','jenis'));
        }

        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && !empty($_GET['dosen']) && !empty($_GET['matkul']) )) {
          $data_matkul = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                  ->select('tb_jenis_indikator.nm_jenis_indikator','tb_evaluasi.id_prodi','tb_evaluasi.id_fakultas',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'),'tb_evaluasi.nip','tb_evaluasi.id_matkul')
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->where('tb_evaluasi.id_prodi',$_GET['prodi'])
                  ->where('tb_evaluasi.nip',$_GET['dosen'])
                  ->where('tb_evaluasi.id_matkul',$_GET['matkul'])
                  ->groupBy('tb_evaluasi.nip')
                  ->get();
          // return response()->json($data_matkul);
          return view('admin/laporan_evaluasi.laporan_per_jenis',compact('data_matkul','jenis'));
        }
      }
    }

    public static function cekData($nip,$id_jenis_indikator)
    {
      $data_id = DB::table('tb_evaluasi')
                ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                ->select(DB::raw('SUM(nilai)/count(npm) as rata'))
                ->where('tb_evaluasi.nip',$nip)
                ->where('tb_jenis_indikator.id_jenis_indikator',$id_jenis_indikator)
                ->get();
        //return response()->json($data_id);
        return $data_id[0]->rata;
    }

    public static function cekNip($nip)
    {
      $panda = new LoginController();
      $cek = '
        {dosen(dsnPegNip:'.$nip.') {
          dsnPegNip
          pegawai {
            pegNip
            pegNama
          }
        }}
      ';

      $nip = $panda->panda($cek);

      return $nip['dosen'][0]['pegawai']['pegNama'];
    }

    public static function cekProdi($id_prodi)
    {
      $panda = new LoginController();
      $cek = '
        {prodi(prodiKode:'.$id_prodi.') {
          prodiKode
          prodiNamaResmi
        }}
      ';

      $prodi = $panda->panda($cek);

      return $prodi['prodi'][0]['prodiNamaResmi'];
    }

    public static function cekFakultas($id_fakultas)
    {
      $panda = new LoginController();
      $cek = '
        {fakultas(fakKode:'.$id_fakultas.') {
          fakKode
          fakNamaResmi
        }}
      ';

      $fakultas = $panda->panda($cek);

      return $fakultas['fakultas'][0]['fakNamaResmi'];
    }


    public function laporanPerIndikator()
    {
      $panda = new LoginController();
      $data_fakultas = '
        {fakultas {
          fakKode
          fakKodeUniv
          fakNamaResmi
          
        }}
      ';

      $data_univ = $panda->panda($data_fakultas);
      // dd($data_univ);
      Session::put('fakultas',$data_univ['fakultas']);
      return view('admin/laporan_evaluasi.laporan_per_indikator');
    }

    public function apilaporanPerIndikator(Request $request)
    {
      if (isset($_GET['submit'])) {
        if (empty($_GET['fakultas'])) {
          $data = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->select('tb_indikator_penilaian.nm_indikator',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'))
                  ->groupBy('tb_indikator_penilaian.id_indikator')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_indikator',compact('data'));
        }
        elseif (!empty($_GET['fakultas'] && empty($_GET['prodi']))) {
          $data = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->select('tb_indikator_penilaian.nm_indikator','tb_evaluasi.id_fakultas',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'))
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->groupBy('tb_indikator_penilaian.id_indikator')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_indikator',compact('data'));
        }
        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && empty($_GET['dosen']))) {
           $data = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->select('tb_indikator_penilaian.nm_indikator','tb_evaluasi.id_prodi','tb_evaluasi.id_fakultas',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'))
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->where('tb_evaluasi.id_prodi',$_GET['prodi'])
                  ->groupBy('tb_indikator_penilaian.id_indikator')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_indikator',compact('data'));
        }
        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && !empty($_GET['dosen']) && empty($_GET['matkul']) )) {
          $data = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->select('tb_indikator_penilaian.nm_indikator','tb_evaluasi.id_prodi','tb_evaluasi.id_fakultas',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'),'tb_evaluasi.nip')
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->where('tb_evaluasi.id_prodi',$_GET['prodi'])
                  ->where('tb_evaluasi.nip',$_GET['dosen'])
                  ->groupBy('tb_indikator_penilaian.id_indikator')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_indikator',compact('data'));
        }

        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && !empty($_GET['dosen']) && !empty($_GET['matkul']) )) {
          $data = DB::table('tb_evaluasi')
                  ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                  ->select('tb_indikator_penilaian.nm_indikator','tb_evaluasi.id_prodi','tb_evaluasi.id_fakultas',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'),'tb_evaluasi.nip','tb_evaluasi.id_matkul')
                  ->where('tb_evaluasi.id_fakultas',$_GET['fakultas'])
                  ->where('tb_evaluasi.id_prodi',$_GET['prodi'])
                  ->where('tb_evaluasi.nip',$_GET['dosen'])
                  ->where('tb_evaluasi.id_matkul',$_GET['matkul'])
                  ->groupBy('tb_indikator_penilaian.id_indikator')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.laporan_per_indikator',compact('data'));
        }
      }
    }

    public function saranMahasiswa(Request $request){
      $panda = new LoginController();
      $data_fakultas = '
        {fakultas {
          fakKode
          fakKodeUniv
          fakNamaResmi
          
        }}
      ';

      $data_univ = $panda->panda($data_fakultas);
      // dd($data_univ);
      Session::put('fakultas',$data_univ['fakultas']);
      return view('admin/laporan_evaluasi.saran_mahasiswa');
    }

    public function apiSaranMahasiswa(Request $request)
    {
      if (isset($_GET['submit'])) {
        if (empty($_GET['fakultas'])) {
          $data = DB::table('tb_saran')
                  ->select('nip','nm_matkul','id_kelas','semester','id_prodi','id_fakultas','saran')
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.saran_mahasiswa',compact('data'));
        }
        elseif (!empty($_GET['fakultas'] && empty($_GET['prodi']))) {
          $data = DB::table('tb_saran')
                  ->select('nip','nm_matkul','id_kelas','semester','id_prodi','id_fakultas','saran')
                  ->where('id_fakultas',$_GET['fakultas'])
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.saran_mahasiswa',compact('data'));
        }
        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && empty($_GET['dosen']))) {
           $data = DB::table('tb_saran')
                  ->select('nip','nm_matkul','id_kelas','semester','id_prodi','id_fakultas','saran')
                  ->where('id_fakultas',$_GET['fakultas'])
                  ->where('id_prodi',$_GET['prodi'])
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.saran_mahasiswa',compact('data'));
        }
        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && !empty($_GET['dosen']) && empty($_GET['matkul']) )) {
          $data = DB::table('tb_saran')
                  ->select('nip','nm_matkul','id_kelas','semester','id_prodi','id_fakultas','saran')
                  ->where('id_fakultas',$_GET['fakultas'])
                  ->where('id_prodi',$_GET['prodi'])
                  ->where('nip',$_GET['dosen'])
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.saran_mahasiswa',compact('data'));
        }

        elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi']) && !empty($_GET['dosen']) && !empty($_GET['matkul']) )) {
          $data = DB::table('tb_saran')
                  ->select('nip','nm_matkul','id_kelas','semester','id_prodi','id_fakultas','saran')
                  ->where('id_fakultas',$_GET['fakultas'])
                  ->where('id_prodi',$_GET['prodi'])
                  ->where('nip',$_GET['dosen'])
                  ->where('id_matkul',$_GET['matkul'])
                  ->get();
          // return response()->json($data);
          return view('admin/laporan_evaluasi.saran_mahasiswa',compact('data'));
        }
      }
    }



    // public function laporanPerJenisExportPDF()
    // {
    //   $export_per_jenis = DB::table('tb_evaluasi')
    //           ->join('tb_jadwal_perkuliahan','tb_jadwal_perkuliahan.id_jadwal_perkuliahan','=','tb_evaluasi.id_jadwal_perkuliahan')
    //           ->join('tb_mahasiswa','tb_mahasiswa.npm','=','tb_evaluasi.npm')
    //           ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','=','tb_evaluasi.id_indikator')
    //           ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','=','tb_indikator_penilaian.id_jenis_indikator')
    //           ->join('tb_matkul','tb_matkul.id_matkul','=','tb_jadwal_perkuliahan.id_matkul')
    //           ->join('tb_dosen','tb_dosen.nip','=','tb_jadwal_perkuliahan.nip')
    //           ->join('tb_semester','tb_semester.id_semester','=','tb_jadwal_perkuliahan.id_semester')
    //           ->join('tb_prodi','tb_prodi.id_prodi','=','tb_matkul.id_prodi')
    //           ->join('tb_fakultas','tb_fakultas.id_fakultas','=','tb_prodi.id_fakultas')
    //           ->select('tb_evaluasi.id_evaluasi',DB::raw('sum(nilai) as totalnilai'),'tb_mahasiswa.nm_mahasiswa','tb_dosen.nm_dosen','tb_matkul.nm_matkul','tb_prodi.nm_prodi','tb_fakultas.nm_fakultas','tb_jadwal_perkuliahan.kelas','tb_evaluasi.nilai','tb_indikator_penilaian.id_jenis_indikator')
    //           ->groupBy('tb_indikator_penilaian.id_jenis_indikator','tb_evaluasi.id_jadwal_perkuliahan')
    //           ->orderBy('tb_evaluasi.id_evaluasi','ASC')
    //           ->get();
    //   $pdf = PDF::loadView('admin/laporan_evaluasi.laporan_per_jenis_pdf', compact('export_per_jenis'));
    //   $pdf->setPaper('a4','portrait');
    //   return $pdf->stream();
    // }

    // public function laporanPerDosen()
    // {
    //   return view('admin/laporan_evaluasi.laporan_per_dosen');
    // }

    // public function apiLaporanEvaluasiPerDosen(Request $request)
    // {
    //   $get_data = DB::table('tb_evaluasi')
    //           ->join('tb_jadwal_perkuliahan','tb_jadwal_perkuliahan.id_jadwal_perkuliahan','=','tb_evaluasi.id_jadwal_perkuliahan')
    //           ->join('tb_matkul','tb_matkul.id_matkul','=','tb_jadwal_perkuliahan.id_matkul')
    //           ->join('tb_dosen','tb_dosen.nip','=','tb_jadwal_perkuliahan.nip')
    //           ->join('tb_semester','tb_semester.id_semester','=','tb_jadwal_perkuliahan.id_semester')
    //           ->join('tb_prodi','tb_prodi.id_prodi','=','tb_matkul.id_prodi')
    //           ->join('tb_fakultas','tb_fakultas.id_fakultas','=','tb_prodi.id_fakultas')
    //           ->select('tb_dosen.nm_dosen','tb_matkul.nm_matkul','tb_prodi.nm_prodi','tb_fakultas.nm_fakultas','tb_jadwal_perkuliahan.kelas','tb_semester.nm_semester','tb_semester.tahun_ajaran',DB::raw('sum(nilai) as totalnilai'))
    //           ->groupBy('tb_matkul.id_matkul')
    //           ->where('tb_fakultas.id_fakultas','=',$request->nm_fakultas)
    //           ->where('tb_prodi.id_prodi','=', $request->nm_prodi)
    //           ->where('tb_dosen.nip','=',$request->nm_dosen)
    //           ->get();
    //   // $pdf = PDF::loadView('admin/laporan_evaluasi.laporan_per_dosen_pdf', compact('get_data'));
    //   // $pdf->setPaper('a4','portrait');
    //   // return $pdf->stream();
    //   return view('admin/laporan_evaluasi.laporan_per_dosen',compact('get_data'));
    // }
}
