@extends('layouts/template')
@section('main-title','Daftar Mata Kuliah')
@section('sidebar')
  @include('pimpinan/fakultas_sidebar')
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
			    		<th>PROGRAM STUDY</th>
			    		<th>IKATAN KERJA</th>
			    		<th>JABATAN AKADEMIK</th>
			    		<th>AKSI</th>
			    	</tr>
			    </thead>
			    <tbody>
			    	<?php 
			    		$no = 1;
			    		foreach ($dosen['fakultas'][0]['prodi'] as $arr1) {
			    			foreach ($arr1['dosen'] as $arr2) {
		    					if($arr2['pegawai']['pegIsAktif'] == 1){
		    						$nip_dosen = $arr2['pegawai']['pegNip'];
		    						$nm_dosen = $arr2['pegawai']['pegNama'];
		    						$prodi_dosen = $arr1['prodiKode'];

			    					?>
										<tr>
											<td>{{ $no }}</td>
											<td>{{ $arr2['pegawai']['pegNip'] }}</td>
											<td>{{ $arr2['pegawai']['pegGelarDepan'] }}{{ $arr2['pegawai']['pegNama'] }} {{ $arr2['pegawai']['pegGelarBelakang'] }}</td>
											<td>{{ $arr1['prodiNamaResmi'] }}</td>
											<td>{{ $arr2['ikatanKerja'] }}</td>
											<td>
												<?php 
													if($arr2['jabatanAkademik'] == "Tidak Ada Data")
													{
														?>
															<label for="" class="label label-danger"><i class="fa fa-close"></i>&nbsp;{{ $arr2['jabatanAkademik'] }}</label>
														<?php
													}
													else
													{
														?>
															{{ $arr2['jabatanAkademik'] }}
														<?php
													}
												?>
											</td>
											<td>
												<a href="{{ route('fakultas.laporan_dosen',[$nip_dosen,$nm_dosen,$prodi_dosen]) }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-info"></i>&nbsp;Lihat Laporan</a>
											</td>
										</tr>	
			    					<?php
		    						
		    					}
		    				}
			    		}
    					$no++;
			    	?>
			    </tbody>
		    </table>
		</div>
	</div>
@endsection