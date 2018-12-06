@extends('layouts/template')
@section('main-title','Dashboard Hasil Evaluasi')
@section('sidebar')
	@include('dosen/sidebar')
@endsection
@section('manajemen-title')
	<div class="box-header with-border">
        <h3 class="box-title" style="text-transform: uppercase;">Hasil Evaluasi Per Indikator Penilaian</h3>
        <div class="box-tools pull-right">
            @yield('pull-right')
        </div>
    </div>
@endsection
@section('manajemen-title-kedua')
	<p style="font-size: 14px;">Selamat Datang Dosen, Silahkan Gunakan Menu Yang Telah Disediakan Untuk Manajemen Halaman Dosen</p>
@endsection
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-heading bg-blue">Hasil Evaluasi Keseluruhan</div>
			  <div class="panel-body table-responsive">
			  	<table class="table table-bordered" id="table-hasil-evaluasi-detail" width="100%" style="">
					<thead>
						<tr class="bg-blue">
							<th>NO</th>
							<th>DOSEN</th>
							<th>MATA KULIAH</th>
							<th>KELAS</th>
							<th>INDIKATOR PENILAIAN</th>
							<th>NILAI</th>
						</tr>
					</thead>	
					<tbody>
						@php
							$no=1;
						@endphp
						@foreach ($detail_indikator as $detail)
							<tr>
								<td>{{ $no }}</td>
								<td>{{ $detail->nip }}</td>
								<td>{{ $detail->id_matkul }}</td>
								<td>{{ $detail->id_kelas }}</td>
								<td>{{ $detail->nm_indikator }}</td>
								<td>{{ $detail->rata }}</td>
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
	</div>
@endsection