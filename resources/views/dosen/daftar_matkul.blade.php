@extends('layouts/template')
@section('main-title','Daftar Mata Kuliah')
@section('sidebar')
  @include('dosen/sidebar')
@endsection
@section('manajemen-title')
	<div class="box-header with-border">
        <h3 class="box-title">Daftar Mata Kuliah <b>{{ Session::get('nama') }}</b></h3>
        <div class="box-tools pull-right">
            @yield('pull-right')
        </div>
    </div>
@endsection
@section('content')
	<div class="row">
		<div class="col-md-12 table-responsive">
			<table class="table table-hover table-bordered" id="table-matkul-dosen">
				    	<thead>
					    	<tr class="info">
					    		<th>No</th>
					    		<th>ID Kelas</th>
					    		<th>Semester</th>
					    		<th>Mata Kuliah</th>
					    		<th>Mata Kuliah</th>
					    		<th>Kelas</th>
					    		<th>Aksi</th>
					    	</tr>
					    </thead>
					    <tbody>
							<?php 
								$no=1;
								foreach($data['data']['dosen'][0]['kelas'] as $arr1){
								$tahun = substr($arr1['klsSemId'],0,4);
		    					$semester = substr($arr1['klsSemId'], -1);
		    					$nip = $data['data']['dosen'][0]['dsnPegNip'];
		    					$klsSemId = $arr1['klsSemId'];
		    					$id_matkul = $arr1['matakuliah']['mkkurKode'];
		    					$id_kelas = $arr1['klsId'];
							?>
								<tr>
									<td>{{ $no }}</td>
									<td>{{ $arr1['klsId'] }}</td>
									<td>
										{{ $tahun }}
										<?php 
				    						if($semester == 1)
				    						{
				    							echo "Ganjil";
				    						}
				    						elseif ($semester == 2) {
				    							echo "Genap";
				    						}
				    						else
				    						{
				    							
				    						}
				    					?>
									</td>
									<td>{{ $arr1['matakuliah']['mkkurKode'] }}</td>
									<td>{{ $arr1['matakuliah']['mkkurNamaResmi'] }} ({{ $arr1['klsNama'] }})</td>
									<td>{{ $arr1['klsNama'] }}</td>
									<td>
										<a href="{{ route('dosen.hasil_evaluasi_detail',[$nip,$klsSemId,$id_matkul,$id_kelas]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-info-circle"></i>&nbsp;Hasil Evaluasi</a>
									</td>
								</tr>
							<?php
								$no++; 
								}
							?>
					    </tbody>
				    </table>
		</div>
	</div>
@endsection