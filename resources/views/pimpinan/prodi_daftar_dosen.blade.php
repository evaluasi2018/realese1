@extends('layouts/template')
@section('main-title','Daftar Mata Kuliah')
@section('sidebar')
  @include('pimpinan/prodi_sidebar')
@endsection
@section('manajemen-title')
	<div class="box-header with-border">
        <h3 class="box-title">Daftar Dosen Program Studi <b>{{ Session::get('nama') }}</b></h3>
        <div class="box-tools pull-right">
            @yield('pull-right')
        </div>
    </div>
@endsection
@section('content')
	<div class="row">
		<div class="col-md-12 table-responsive">
			<table class="table table-hover table-bordered" id="table-daftar-dosen">
		    	<thead>
			    	<tr class="info">
			    		<th>No</th>
			    		<th>NIP DOSEN</th>
			    		<th>NAMA DOSEN</th>
			    		<th>IKATAN KERJA</th>
			    		<th>JABATAN AKADEMIK</th>
			    		<th>AKSI</th>
			    	</tr>
			    </thead>
			    <tbody>
			    	<?php 
			    		$no = 1;
			    		foreach ($dosen['prodi'][0]['dosen'] as $arr1) {
	    					if($arr1['pegawai']['pegIsAktif'] == 1){
	    						$nip_dosen = $arr1['pegawai']['pegNip'];
	    						$nm_dosen = $arr1['pegawai']['pegNama'];

		    					?>
									<tr>
										<td>{{ $no }}</td>
										<td>{{ $arr1['pegawai']['pegNip'] }}</td>
										<td>{{ $arr1['pegawai']['pegGelarDepan'] }}{{ $arr1['pegawai']['pegNama'] }} {{ $arr1['pegawai']['pegGelarBelakang'] }}</td>
										<td>{{ $arr1['ikatanKerja'] }}</td>
										<td>
											<?php 
												if($arr1['jabatanAkademik'] == "Tidak Ada Data")
												{
													?>
														<label for="" class="label label-danger"><i class="fa fa-close"></i>&nbsp;{{ $arr1['jabatanAkademik'] }}</label>
													<?php
												}
												else
												{
													?>
														{{ $arr1['jabatanAkademik'] }}
													<?php
												}
											?>
										</td>
										<td>
											<a href="{{ route('prodi.laporan_dosen',[$nip_dosen,$nm_dosen]) }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-info"></i>&nbsp;Lihat Laporan</a>
										</td>
									</tr>	
		    					<?php
	    					}
	    					$no++;
			    		}
			    	?>
			    </tbody>
		    </table>
		</div>
	</div>
@endsection