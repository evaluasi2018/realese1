@extends('layouts/template')
@section('main-title','Admin - Laporan Evaluasi Per Jenis')
@section('sidebar')
    @include('admin/sidebar')
@endsection
@section('manajemen-title')
	<div class="box-header with-border">
        <h3 class="box-title" style="text-transform: uppercase;">laporan evaluasi per jenis indikator penilaian</h3>
        <div class="box-tools pull-right">
            @yield('pull-right')
        </div>
    </div>
@endsection
@section('content')	
	<?php 
		use \App\Http\Controllers\Admin\LaporanEvaluasiController;
	?>
	<div class="panel panel-default">
		<div class="panel-heading bg-blue">Laporan Evaluasi Per Jenis Indikator</div>
		<form action="{{ route('api.laporan-per-jenis') }}" method="GET">
			<div class="table-responsive">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<label for="" class="">Filter Per Fakultas</label>
					<select name="fakultas" class="form-control daftarFakultas" onchange="select_prodi()">
						<option value="0" disabled="disabled" selected="selected">-- pilih fakultas --</option>
						
						<?php 
							$fakultas = Session::get('fakultas');
							foreach ($fakultas as $fakultas) {
						?>
							<option value="{{ $fakultas['fakKode'] }}">{{ $fakultas['fakNamaResmi'] }}</option>
						<?php 
							}
						?>
					</select>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12" id="select-prodi" style="display: none;">
					<label for="" class="">Filter Per Prodi</label>
					<select name="prodi" class="form-control daftarProdi" onchange="select_dosen()">
						<option value="0" disabled="disabled" selected="selected">-- pilih prodi --</option>
						
					</select>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12" id="select-dosen" style="display: none;">
					<label for="" class="">Filter Per Dosen</label>
					<select name="dosen" class="form-control daftarDosen"onchange="select_matkul()">
						<option value="0" disabled="disabled" selected="selected">-- pilih dosen --</option>
					</select>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12" id="select-matkul" style="display: none;">
					<label for="" class="">Filter Per Mata Kuliah</label>
					<select name="matkul" class="form-control daftarMatkul">
						<option value="0" disabled="disabled" selected="selected">-- pilih matkul --</option>
					</select>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12" id="button-laporan" style="margin-top: 5px;">
					<button name="submit" id="button-per-jenis" class="btn btn-primary bg-blue btn-flat">Lihat Laporan</button>
				</div>

				<div class="col-md-12 table-responsive" style="margin-top: 5px; display:;">
					<?php 
						$no=1;
						if(isset($_GET['submit']))
						{
							if (empty($_GET['fakultas'])) {
								?>
									<table id="table-laporan-per-jenis" class="table table-bordered table-striped table-responsive table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NIP DOSEN</th>
												<th>NAMA DOSEN</th>
												<th>PROGRAM STUDI</th>
												<th>FAKULTAS</th>
												<?php 
													foreach ($jenis as $jenis) {
												?>
													<th style="text-transform: uppercase;">
														{{ $jenis->nm_jenis_indikator }}
													</th>
												<?php 
													}
												?>
											</tr>
										</thead>
										<tbody>
											<?php 
												$no =1;
												foreach($data as $data)
												{
													?>	
														<tr>
															<td>{{ $no }}</td>
															<td>{{ $data->nip }}</td>
															<td>{{LaporanEvaluasiController::cekNip($data->nip) }}</td>
															<td>{{LaporanEvaluasiController::cekProdi($data->id_prodi) }}</td>
															
															<td>{{LaporanEvaluasiController::cekFakultas($data->id_fakultas) }}</td>
															<?php 
																$id = DB::table('tb_jenis_indikator')
																	->select('id_jenis_indikator')
																	->get();
																	foreach ($id as $id) {
															?>
																<td>{{LaporanEvaluasiController::cekData($data->nip, $id->id_jenis_indikator) }}</td>
															<?php 
																}
															?>
														</tr>
													<?php
												$no++; 
												} 
											?>
										</tbody>
									</table>
								<?php	
							}
							elseif (!empty($_GET['fakultas'] && empty($_GET['prodi'])))
							{
								?>
									<table id="table-laporan-per-jenis" class="table table-bordered table-striped table-responsive table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NIP DOSEN</th>
												<th>NAMA DOSEN</th>
												<th>PROGRAM STUDI</th>
												<th>FAKULTAS</th>
												<?php 
													foreach ($jenis as $jenis) {
												?>
													<th style="text-transform: uppercase;">
														{{ $jenis->nm_jenis_indikator }}
													</th>
												<?php 
													}
												?>
											</tr>
										</thead>
										<tbody>
											<?php 
												$no =1;
												foreach($data_fakultas as $data)
												{
													?>	
														<tr>
															<td>{{ $no }}</td>
															<td>{{ $data->nip }}</td>
															<<td>{{LaporanEvaluasiController::cekNip($data->nip) }}</td>
															<td>{{LaporanEvaluasiController::cekProdi($data->id_prodi) }}</td>
															
															<td>{{LaporanEvaluasiController::cekFakultas($data->id_fakultas) }}</td>
															<?php 
																$id = DB::table('tb_jenis_indikator')
																	->select('id_jenis_indikator')
																	->get();
																	foreach ($id as $id) {
															?>
																<td>{{LaporanEvaluasiController::cekData($data->nip, $id->id_jenis_indikator) }}</td>
															<?php 
																}
															?>
														</tr>
													<?php
												$no++; 
												} 
											?>
										</tbody>
									</table>
								<?php
							}
							elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi'])) && empty($_GET['dosen']))
							{
								?>
									<table id="table-laporan-per-jenis" class="table table-bordered table-striped table-responsive table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NIP DOSEN</th>
												<th>NAMA DOSEN</th>
												<th>PROGRAM STUDI</th>
												<th>FAKULTAS</th>
												<?php 
													foreach ($jenis as $jenis) {
												?>
													<th style="text-transform: uppercase;">
														{{ $jenis->nm_jenis_indikator }}
													</th>
												<?php 
													}
												?>
											</tr>
										</thead>
										<tbody>
											<?php 
												$no =1;
												foreach($data_prodi as $data)
												{
													?>	
														<tr>
															<td>{{ $no }}</td>
															<td>{{ $data->nip }}</td>
															<td>{{LaporanEvaluasiController::cekNip($data->nip) }}</td>
															<td>{{LaporanEvaluasiController::cekProdi($data->id_prodi) }}</td>
															
															<td>{{LaporanEvaluasiController::cekFakultas($data->id_fakultas) }}</td>
															<?php 
																$id = DB::table('tb_jenis_indikator')
																	->select('id_jenis_indikator')
																	->get();
																	foreach ($id as $id) {
															?>
																<td>{{LaporanEvaluasiController::cekData($data->nip, $id->id_jenis_indikator) }}</td>
															<?php 
																}
															?>
														</tr>
													<?php
												$no++; 
												} 
											?>
										</tbody>
									</table>
								<?php
							}
							elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi'])) && !empty($_GET['dosen']) && empty($_GET['matkul']))
							{
								?>
									<table id="table-laporan-per-jenis" class="table table-bordered table-striped table-responsive table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NIP DOSEN</th>
												<th>NAMA DOSEN</th>
												<th>PROGRAM STUDI</th>
												<th>FAKULTAS</th>
												<?php 
													foreach ($jenis as $jenis) {
												?>
													<th style="text-transform: uppercase;">
														{{ $jenis->nm_jenis_indikator }}
													</th>
												<?php 
													}
												?>
											</tr>
										</thead>
										<tbody>
											<?php 
												$no =1;
												foreach($data_dosen as $data)
												{
													?>	
														<tr>
															<td>{{ $no }}</td>
															<td>{{ $data->nip }}</td>
															<td>{{LaporanEvaluasiController::cekNip($data->nip) }}</td>
															<td>{{LaporanEvaluasiController::cekProdi($data->id_prodi) }}</td>
															
															<td>{{LaporanEvaluasiController::cekFakultas($data->id_fakultas) }}</td>
															<?php 
																$id = DB::table('tb_jenis_indikator')
																	->select('id_jenis_indikator')
																	->get();
																	foreach ($id as $id) {
															?>
																<td>{{LaporanEvaluasiController::cekData($data->nip, $id->id_jenis_indikator) }}</td>
															<?php 
																}
															?>
														</tr>
													<?php
												$no++; 
												} 
											?>
										</tbody>
									</table>
								<?php
							}
							elseif (!empty($_GET['fakultas'] && !empty($_GET['prodi'])) && !empty($_GET['dosen']) && !empty($_GET['matkul']))
							{
								?>
									<table id="table-laporan-per-jenis" class="table table-bordered table-striped table-responsive table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NIP DOSEN</th>
												<th>NAMA DOSEN</th>
												<th>PROGRAM STUDI</th>
												<th>FAKULTAS</th>
												<?php 
													foreach ($jenis as $jenis) {
												?>
													<th style="text-transform: uppercase;">
														{{ $jenis->nm_jenis_indikator }}
													</th>
												<?php 
													}
												?>
											</tr>
										</thead>
										<tbody>
											<?php 
												$no =1;
												foreach($data_matkul as $data)
												{
													?>	
														<tr>
															<td>{{ $no }}</td>
															<td>{{ $data->nip }}</td>
															<td>{{LaporanEvaluasiController::cekNip($data->nip) }}</td>
															<td>{{LaporanEvaluasiController::cekProdi($data->id_prodi) }}</td>
															
															<td>{{LaporanEvaluasiController::cekFakultas($data->id_fakultas) }}</td>
															<?php 
																$id = DB::table('tb_jenis_indikator')
																	->select('id_jenis_indikator')
																	->get();
																	foreach ($id as $id) {
															?>
																<td>{{LaporanEvaluasiController::cekData($data->nip, $id->id_jenis_indikator) }}</td>
															<?php 
																}
															?>
														</tr>
													<?php
												$no++; 
												} 
											?>
										</tbody>
									</table>
								<?php
							}
						}	
					?>
				</div>
			</div>
		</form>
	</div>
@endsection