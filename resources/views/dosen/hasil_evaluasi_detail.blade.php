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
      	<form action="{{ route('api.hasil_evaluasi_detail') }}" method="GET">
      		<div>
      			<input type="hidden" name="nip" value="{{Session::get('nip') }}">
	            <input type="hidden" name="id_matkul" class="form-control" value="{{ Session::get('id_matkul')}}">

      			<select name="jenis" class="form-control" id="">
      				<option value="0">-- lihat berdasarkan --</option>
      				<option value="1">Jenis Indikator</option>
      				<option value="2">Indikator Penilaian</option>
      				<option value="3">Saran Mahasiswa</option>
      			</select>
      		</div>
      		<div style="margin-top: 5px; margin-bottom: 5px;">
      			<button type="submit" name="submit" class="btn btn-primary btn-flat">Lihat Hasil</button>
      		</div>
      	</form>

      	<?php 
      		if(isset($_GET['submit']))
      		{
      			if($_GET['jenis'] == 1)
      			{
      				
  					?>
						<table class="table table-bordered table-hover" id="table-hasil-detail">
							<thead>
								<tr>
									<th>No</th>
									<th>MATA KULIAH</th>
									<th>ID KELAS</th>
									<th>SEMESTER</th>
									<th>JENIS INDIKATOR</th>
									<th>TOTAL NILAI</th>
									<th>JUMLAH REVIEW</th>
									<th>RATA-RATA</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$no=1;
									foreach ($data_detail as $data) {
										$tahun = substr($data->semester, 0,4);
				    					$semester = substr($data->semester, -1);
								?>
									<tr>
										<td>
											{{ $no }}
										</td>
										<td>
											{{ $data->nm_matkul }}
										</td>
										<td>
											{{ $data->id_kelas }}
										</td>
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
										<td>
											{{ $data->nm_jenis_indikator }}
										</td>
										<td>
											{{ $data->totalnilai }}
										</td>
										<td>
											{{ $data->jumlahreview }}
										</td>
										<td>
											{{ $data->rata }}
										</td>
									</tr>
								<?php 
									$no++;
									}
								?>
							</tbody>
						</table>
  					<?php
      			}
      			elseif($_GET['jenis'] == 2)
      			{
      				
  					?>
						<table class="table table-bordered table-hover" id="table-hasil-detail">
							<thead>
								<tr>
									<th>No</th>
									<th>MATA KULIAH</th>
									<th>ID KELAS</th>
									<th>SEMESTER</th>
									<th>INDIKATOR PENILAIAN</th>
									<th>TOTAL NILAI</th>
									<th>JUMLAH REVIEW</th>
									<th>RATA-RATA</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$no=1;
									foreach ($data_detail as $data) {
										$tahun = substr($data->semester, 0,4);
				    					$semester = substr($data->semester, -1);
								?>
									<tr>
										<td>
											{{ $no }}
										</td>
										<td>
											{{ $data->nm_matkul }}
										</td>
										<td>
											{{ $data->id_kelas }}
										</td>
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
										<td>
											{{ $data->nm_indikator }}
										</td>
										<td>
											{{ $data->totalnilai }}
										</td>
										<td>
											{{ $data->jumlahreview }}
										</td>
										<td>
											{{ $data->rata }}
										</td>
									</tr>
								<?php 
									$no++;
									}
								?>
							</tbody>
						</table>
  					<?php
      			}
      			elseif($_GET['jenis'] == 3)
      			{
      				
  					?>
						<table class="table table-bordered table-hover" id="table-hasil-detail">
							<thead>
								<tr>
									<th>No</th>
									<th>MATA KULIAH</th>
									<th>ID KELAS</th>
									<th>SEMESTER</th>
									<th>SARAN MAHASISWA</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$no=1;
									foreach ($data_detail as $data) {
										$tahun = substr($data->semester, 0,4);
				    					$semester = substr($data->semester, -1);
								?>
									<tr>
										<td>
											{{ $no }}
										</td>
										<td>
											{{ $data->nm_matkul }}
										</td>
										<td>
											{{ $data->id_kelas }}
										</td>
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
										<td>
											{{ $data->saran }}
										</td>

								<?php 
									$no++;
									}
								?>
							</tbody>
						</table>
  					<?php
      			}
      			elseif($_GET['jenis'] == 0)
      			{
      				?>
      					@if ($pesan = Session::get('alert'))
      						<div class="alert alert-danger">
								<script>
									{{ $pesan }}
								</script>
      						</div>
      					@endif
						<table class="table table-bordered table-hover" id="table-hasil-detail">
							<thead>
								<tr>
									<th>No</th>
									<th>MATA KULIAH</th>
									<th>ID KELAS</th>
									<th>SEMESTER</th>
									<th>SARAN MAHASISWA</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
      				<?php
      			}
      		}
      	?>

      </div>
  </div>
  <!-- AKHIR FORM PENGISIAN KUISIONER -->

  
  <!-- AKHIR FOOTER -->
@endsection