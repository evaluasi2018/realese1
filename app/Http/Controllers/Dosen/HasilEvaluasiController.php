<?php

namespace App\Http\Controllers\dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\LoginController;
use DB;
use Session;
use Auth;

class HasilEvaluasiController extends Controller
{
    public function hasilEvaluasi()
    {
    	return view('dosen/hasil_evaluasi');
    }

    public function apiHasilEvaluasi()
    {
    	DB::statement(DB::raw('set @rownum=0'));
        $matkul_dosen = DB::table('tb_evaluasi')
                    ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                    ->select('nm_matkul','id_kelas','nm_indikator','tb_evaluasi.nilai',DB::raw('@rownum  := @rownum  + 1 AS rownum'))
                    ->where('nip',Session::get('nip'))
                    ->get();
        return Datatables::of($matkul_dosen)
            ->addColumn('action',function($matkul_dosen){
            })->make(true);
    }

    public function hasilEvaluasiPerJenis()
    {
        return view('dosen/hasil_evaluasi_per_jenis');
    }

    public function apiHasilEvaluasiPerJenis()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $matkul_dosen = DB::table('tb_evaluasi')
                    ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                    ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                    ->select('nm_matkul','id_kelas','nm_jenis_indikator',DB::raw('@rownum  := @rownum  + 1 AS rownum'),DB::raw('sum(nilai) as totalnilai'))
                    ->groupBy('tb_jenis_indikator.id_jenis_indikator')
                    ->where('nip',Session::get('nip'))
                    ->get();
        return Datatables::of($matkul_dosen)
            ->addColumn('action',function($matkul_dosen){
            })->make(true);
    }

    public function hasilEvaluasiPerMataKuliah()
    {
        return view('dosen/hasil_evaluasi_per_mata_kuliah');
    }

    public function apiHasilEvaluasiPerMataKuliah(Request $request)
    {
        $hasil = DB::table('tb_evaluasi')
                        ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                        ->select('nm_matkul','indikator','id_kelas','semester','nip',DB::raw('sum(nilai)as totalnilai'))
                        ->groupBy('tb_indikator_penilaian.nm_indikator')
                        ->where('nip',Session::get('nip'))
                        ->where('id_matkul',$request->id_matkul)
                        ->get();
                        dd($hasil);
        return view('dosen/hasil_evaluasi_per_mata_kuliah',compact('hasil'));
    }

    public function saranMahasiswa()
    {
        return view('dosen/saran_mahasiswa');
    }

    public function apiSaranMahasiswa()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $saran = DB::table('tb_saran')
                ->select('saran','id_kelas','nm_matkul','semester',DB::raw('@rownum  := @rownum  + 1 AS rownum'))
                ->get();
        return Datatables::of($saran)
            ->addColumn('action',function($saran){
            })->make(true);
    }

    public function apiHasilEvaluasiDetail()
    {

        $data_detail = DB::table('tb_evaluasi')
        ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
        ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
        ->select('tb_jenis_indikator.nm_jenis_indikator','tb_evaluasi.nm_matkul','tb_evaluasi.id_kelas','tb_evaluasi.semester',DB::raw('SUM(nilai) as totalnilai'),DB::raw('count(npm) as jumlahreview'),DB::raw('SUM(nilai)/count(npm) as rata'))
        ->where('tb_evaluasi.nip',Session::get('nip'))
        ->where('tb_evaluasi.id_matkul',Session::get('id_matkul'))
        ->groupBy('tb_evaluasi.nip')
        ->get();
        return response()->json($data_detail);
        // return view('dosen/hasil_evaluasi_detail',compact('data_detail'));
 
    }

    public static function cekData($id_kelas,$id_jenis_indikator)
    {
      $data_id = DB::table('tb_evaluasi')
                ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                ->join('tb_jenis_indikator','tb_jenis_indikator.id_jenis_indikator','tb_indikator_penilaian.id_jenis_indikator')
                ->select(DB::raw('SUM(nilai)/count(npm) as rata'))
                ->where('tb_evaluasi.id_kelas',$id_kelas)
                ->where('tb_jenis_indikator.id_jenis_indikator',$id_jenis_indikator)
                ->get();
        //return response()->json($data_id);
        return $data_id[0]->rata;
    }

    public static function cekKelas($id_kelas)
    {
      $panda = new LoginController();
      $cek = '
        {kelas(klsId:'.$id_kelas.') {
          klsId
          klsNama
        }}
      ';

      $kelas = $panda->panda($cek);

      return $kelas['kelas'][0]['klsNama'];
    }

    public static function cekMatkul($id_kelas)
    {
      $panda = new LoginController();
      $cek = '
        {kelas(klsId:'.$id_kelas.') {
          klsId
          matakuliah {
            mkkurId
            mkkurNamaResmi
          }
        }}
      ';

      $kelas = $panda->panda($cek);

      return $kelas['kelas'][0]['matakuliah']['mkkurNamaResmi'];
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

    public function dosenDetailIndikator($id_kelas)
    {
        $detail_indikator = DB::table('tb_evaluasi')
                            ->join('tb_indikator_penilaian','tb_indikator_penilaian.id_indikator','tb_evaluasi.id_indikator')
                            ->select('tb_evaluasi.nip','tb_evaluasi.id_matkul','tb_evaluasi.id_kelas','tb_indikator_penilaian.nm_indikator',DB::raw('SUM(nilai)/count(npm) as rata'))
                            ->where('tb_evaluasi.id_kelas',$id_kelas)
                            ->groupBy('tb_indikator_penilaian.id_indikator')
                            ->get();
                            // dd($detail_indikator);
        return view('dosen/detail_indikator',compact('detail_indikator'));
    }
        
}