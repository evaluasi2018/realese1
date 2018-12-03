<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','.daftarFakultas',function(){
			// console.log('bismillah');
			var id_fakultas = $(this).val();
			// console.log(id_fakultas);
			var div=$(this).parent().parent();
			// console.log(id_fak);
			var op=" ";
			$.ajax({
				type:'get',
				url:'{{ URL::to('admin/laporan/laporan_evaluasi_per_jenis/cariprodi') }}',
				data:{'id':id_fakultas},
				success:function(data){
					// console.log('success');
					// console.log(data['fakultas'][0]['prodi']);	
					// console.log(data['fakultas'][0]['prodi'][0]['dosen'].length);
					op+='<option value="0" selected disabled>-- pilih prodi--</option>';

		            for(var i=0; i<data['fakultas'][0]['prodi'].length;i++){
		            	if(data['fakultas'][0]['prodi'][i]['dosen'].length === 0){
		            		continue;
		            	}
		              op+='<option value="'+data['fakultas'][0]['prodi'][i].prodiKode+'">'+data['fakultas'][0]['prodi'][i].prodiNamaResmi+' ('+ data['fakultas'][0]['prodi'][i].prodiJjarKode +')</option>';
					}
					div.find('.daftarProdi').html("");
		            div.find('.daftarProdi').append(op);
				},

				error:function()
				{

				}
			})
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','.daftarProdi',function(){
			// console.log('bismillah');
			var id_prodi = $(this).val();
			// console.log(id_prodi);
			var div=$(this).parent().parent();
			// console.log(id_prodi);
			var op=" ";
			$.ajax({
				type:'get',
				url:'{{ URL::to('admin/laporan/laporan_evaluasi_per_jenis/caridosen') }}',
				data:{'id':id_prodi},
				success:function(data){
					// console.log('success');
					// console.log(data['fakultas'][0]['prodi']);	
					// console.log(data['prodi'][0]['pegawai'].length);
					op+='<option value="0" selected disabled>-- pilih dosen--</option>';

		            for(var i=0; i<data['prodi'][0]['pegawai'].length;i++){
		              op+='<option value="'+data['prodi'][0]['pegawai'][i].pegNip+'">'+data['prodi'][0]['pegawai'][i].pegNama+'</option>';
					}
					div.find('.daftarDosen').html("");
		            div.find('.daftarDosen').append(op);
				},

				error:function()
				{

				}
			})
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','.daftarDosen',function(){
			// console.log('bismillah');
			var id_dosen = $(this).val();
			// console.log(id_dosen);
			var div=$(this).parent().parent();
			// console.log(id_dosen);
			var op=" ";
			$.ajax({
				type:'get',
				url:'{{ URL::to('admin/laporan/laporan_evaluasi_per_jenis/carimatkul') }}',
				data:{'id':id_dosen},
				success:function(data){
					console.log('success');
					// console.log(data['fakultas'][0]['prodi']);	
					// console.log(data['dosen'][0]['kelas'][0].length);
					op+='<option value="0" selected disabled>-- pilih mata kuliah--</option>';

		            for(var i=0; i<data['dosen'][0]['kelas'].length;i++){
		              op+='<option value="'+data['dosen'][0]['kelas'][i]['matakuliah'].mkkurKode+'">'+data['dosen'][0]['kelas'][i]['matakuliah'].mkkurNamaResmi+' ('+data['dosen'][0]['kelas'][i]['matakuliah']['prodi'].prodiNamaResmi+') ('+data['dosen'][0]['kelas'][i].klsNama+') </option>';
					}
					div.find('.daftarMatkul').html("");
		            div.find('.daftarMatkul').append(op);
				},

				error:function()
				{

				}
			})
		});
	});
</script>

<script type="text/javascript">
	function select_prodi()
	{
	    $('#select-prodi').show(100);
	}

	function select_dosen()
	{
	    $('#select-dosen').show(100);
	}

	function select_matkul()
	{
	    $('#select-matkul').show(100);
	}

</script>

<script>
	$(document).ready( function () {
	    $('#table-laporan-per-jenis').DataTable({
	    	"bPaginate": false,
	    	dom: 'lBfrtip',
		    buttons: [
		        {
		            extend:'excel', 
		            text:'<i class="fa fa-file-excel-o"></i>&nbsp;Cetak Excel',
		            className:'btn bg-blue  btn-flat dt-buttons' 
		        },
		        {
		            extend:'pdf', 
		            text:'<i class="fa fa-file-pdf-o"></i>&nbsp;Cetak PDF',
		            orientation: 'landscape',
		            pageSize: 'LEGAL', 
		            className:'btn btn-success  btn-flat dt-buttons' 
		        },
		        {
		            extend: 'print',
		            text:'<i class="fa fa-print"></i>&nbsp;Cetak Data',
		            className:'btn btn-warning btn-flat dt-buttons',
		            customize: function (win) {
		                $(win.document.body)
		                    .css( 'font-size', '10pt' )
		                    .prepend(
		                        // '<img src="{{ asset('assets/images/unib.png') }}" style="position:absolute; top:0; left:0;z-index:-1;" />'
		                    );

		                $(win.document.body).find( 'table' )
		                    .addClass( 'compact' )
		                    .css( 'font-size', 'inherit' );
		            }
		        }
		    ],
	    });
	} );
</script>

<script>
	$(document).ready( function () {
	    $('#table-matkul-dosen').DataTable({
	    	"bPaginate": false,
	    });
	} );

	$(document).ready( function () {
	    $('#table-hasil-detail').DataTable({
	    });
	} );
</script>