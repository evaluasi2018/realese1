@extends('layouts/template')
@section('main-title','Dashboard Mahasiswa')
@section('sidebar')
	@include('pimpinan/prodi_sidebar')
@endsection
@section('manajemen-title')
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-dashboard"></i>&nbsp;DASHBOARD PRODI</h3>
        <div class="box-tools pull-right">
            @yield('pull-right')
        </div>
    </div>
@endsection
@section('second-box-header')
    <div class="box-header with-border">
        Selamat Datang <b>{{ Session::get('nama') }}</b> di Sistem Informasi Evaluasi Universitas Bengkulu, Sebelum Mengisi, Silahkan Baca Petunjuk Terlebih Dahulu Sebelum Melakukan Evaluasi !! 
    </div>
@endsection
@section('content')
	<div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">JENIS INDIKATOR</span>
            <span class="info-box-number"><small>&nbsp; JENIS</small></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">INDIKATOR PENILAIAN</span>
            <span class="info-box-number"> <small>&nbsp; INDIKATOR</small></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">MAHASISWA</span>
            <span class="info-box-number"><small>&nbsp; MAHASISWA</small></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">DOSEN</span>
            <span class="info-box-number"> <small>&nbsp; DOSEN</small></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
      <!-- /.row -->
@endsection