@extends('layouts/template')
@section('main-title','Admin - Manajemen Jenis Indikator')
@section('sidebar')
    @include('admin/sidebar')
@endsection
@section('manajemen-title')
	<div class="box-header with-border">
        <h3 class="box-title" style="text-transform: uppercase;">MANAJEMEN JENIS INDIKATOR PENILAIAN</h3>
        <div class="box-tools pull-right">
            <a onclick="tambahJenis()" class="btn btn-primary btn-flat pull-right" style="margin-left: 10px;"><i class="fa fa-plus"></i>&nbsp;Tambah Jenis Indikator</a>
        </div>
    </div>
@endsection
@section('content')
	<div class="panel panel-default">
		<div class="panel-heading bg-blue">Data Jenis Indikator Penilaian</div>
		<div class="panel-body table-responsive">
			<table id="table-jenis" class="table table-hover table-bordered" style="width: 100%;">
				<thead>
					<tr class="bg-blue">
						<th>No</th>
						<th>NAMA JENIS</th>
						<th>KETERANGAN</th>
						<th>AKSI</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	@include('admin/manajemen_jenis_indikator/form_jenis_indikator')
	@include('admin/manajemen_jenis_indikator/sampah')
@endsection



