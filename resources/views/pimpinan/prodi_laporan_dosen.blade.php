@extends('layouts/template')
@section('main-title','Dashboard Admin')
@section('sidebar')
  @include('pimpinan/prodi_sidebar')
@endsection
@section('pull-right')
@endsection
@section('manajemen-title-kedua')
  <p style="font-size: 14px;">Selamat Datang Admin, Silahkan Gunakan Menu Yang Telah Disediakan Untuk Manajemen Halaman Admin</p>
@endsection
@section('content')

  <!-- FORM PENGISIAN KUISIONER -->
  <div class="row">
    
      <div class="col-md-6">

        <div class="form-group">
          <label for="fakultas">NIP DOSEN:</label>
            <input type="text" disabled="disabled" class="form-control" value="{{ Session::get('nip_dosen')}}">

        </div>
      </div>
      <div class="col-md-6" style="display: ;" id="select_dosen">

        <div class="form-group ">
          <label for="pwd">NAMA DOSEN:</label>
            <input type="text" disabled="disabled" class="form-control" value="{{ Session::get('nm_dosen')}}">

        </div>
      </div>
      <div class="col-md-12" >
      	
 		<table class="table table-bordered table-hover" id="table-laporan-pimpinan-dosen">
 			<thead>
 				<tr class="bg-info">
 					<th>NO</th>
 					<th>NIP DOSEN</th>
 					<th>NAMA DOSEN</th>
 					<th>JENIS INDIKATOR</th>
 					<th>RATA-RATA</th>
 				</tr>
 			</thead>
 			<tbody>
 				@php
 					$no=1;
 				@endphp
 				@foreach ($lp_pimpinan_dosen as $laporan)
 					<tr>
 						<td>{{ $no }}</td>
 						<td>{{ $laporan->nip }}</td>
 						<td>{{ $laporan->nm_dosen }}</td>
 						<td>{{ $laporan->nm_jenis_indikator }}</td>
 						<td>
 							<label for="" class="label label-primary">
 								{{ $laporan->rata }}
 							</label>
 						</td>
 					</tr>
 					@php
 						$no++;
 					@endphp
 				@endforeach
 			</tbody>
 		</table>

      </div>
  </div>
  <!-- AKHIR FORM PENGISIAN KUISIONER -->

  
  <!-- AKHIR FOOTER -->
@endsection