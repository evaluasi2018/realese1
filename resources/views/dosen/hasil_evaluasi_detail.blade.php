@extends('layouts/template')
@section('main-title','Dashboard Admin')
@section('sidebar')
  @include('dosen/sidebar')
@endsection
@section('pull-right')
@endsection
@section('manajemen-title-kedua')
  <p style="font-size: 14px;">Selamat Datang Admin, Silahkan Gunakan Menu Yang Telah Disediakan Untuk Manajemen Halaman Admin</p>
@endsection
@section('content')
	<?php 
		use \App\Http\Controllers\dosen\HasilEvaluasiController;
	?>
  <!-- FORM PENGISIAN KUISIONER -->
  <div class="row">
    
      <div class="col-md-6">

        <div class="form-group">
          <label for="fakultas">PROGRAM STUDY:</label>
            <input type="text" disabled="disabled" class="form-control" value="{{ Session::get('prodi')}}">

        </div>
      </div>
      <div class="col-md-6" style="display: ;" id="select_dosen">

        <div class="form-group ">
          <label for="pwd">MATA KULIAH:</label>
            <input type="text" disabled="disabled" class="form-control" value="{{ Session::get('matkul')}}">

        </div>
      </div>
      <div class="col-md-12" >
  		<div>
  			<input type="hidden" name="nip" value="{{Session::get('nip') }}">
            <input type="hidden" name="id_matkul" class="form-control" value="{{ Session::get('id_matkul')}}">

  		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-hover" id="table-hasil-detail">
				<thead>
					<tr class="bg-primary">
						<th>No</th>
						<th>NAMA DOSEN</th>
						<th>MATA KULIAH</th>
						<th>NAMA KELAS</th>
						@foreach ($jenis as $jenis)
							<th style="text-transform: uppercase;">
								{{ $jenis->nm_jenis_indikator }}
							</th>
						@endforeach
						<th>DETAIL</th>
					</tr>
				</thead>
				<tbody>
					@php
						$no=1;
					@endphp
					@foreach ($nilai as $nilai)
						<tr>
							<td>{{ $no }}</td>
							<td>{{HasilEvaluasiController::cekNip($nilai->nip) }}</td>

							<td>{{HasilEvaluasiController::cekMatkul($nilai->id_kelas) }}</td>
						
							<td>{{HasilEvaluasiController::cekKelas($nilai->id_kelas) }}</td>
							
							<?php 
								$id = DB::table('tb_jenis_indikator')
									->select('id_jenis_indikator')
									->get();
									foreach ($id as $id) {
							?>
								<td>{{HasilEvaluasiController::cekData($nilai->id_kelas, $id->id_jenis_indikator) }}</td>
							<?php 
								}
							?>
							<td><a href="{{ route('dosen.detail_indikator',[$nilai->id_kelas]) }}">Indikator</a><a href="">Saran Mahasiswa</a></td>
						</tr>
						@php
							$no++;
						@endphp
					@endforeach
				</tbody>
			</table>
		</div>

      </div>
  </div>
  <!-- AKHIR FORM PENGISIAN KUISIONER -->

  
  <!-- AKHIR FOOTER -->
@endsection