<!-- Script menampilkan data dari table jenis -->  
  <script type="text/javascript">
  $('#table-indikator').DataTable({
    processing:true,
    serverSide:true,
    ajax: "{{ route('api.indikator') }}",
    columns: [
      {data: 'rownum', name: 'rownum'},
      {data: 'nm_indikator', name:'nm_indikator'},
      {data: 'nm_jenis_indikator', render:function(data, type, row){
                  return '<label class="label label-success" style="font-size:12px;">'+data+'</label>';
        }
      },
      {data: 'action', name:'action', orderable:false, searchable:false}
    ]   
  });

  // Script Tambah Jenis Indikator
  function tambahIndikator(){
    save_method = "add";
    $('input[name=_method]').val('POST');
    $('#form-modal-indikator').modal('show');
    $('#form-modal-indikator form')[0].reset();
  }

  function editIndikator(id_indikator){
    save_method = 'edit';
    $('input[name=_method]').val('PATCH');
    $('#form-modal-indikator form')[0].reset();
    $.ajax({
      url: "{{ url('admin/manajemen_indikator') }}"+'/'+ id_indikator + "/edit",
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('#form-modal-indikator').modal('show');
        $('#id_indikator').val(data.id_indikator);
        $('#nm_indikator').val(data.nm_indikator);
        $('#id_jenis_indikator').val(data.id_jenis_indikator);
      },
      error:function(){
        alert("Nothing Data");
      }
    });
  }

  // script hapus jenis
  function hapusIndikator(id_indikator){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    swal({
        title: 'Data akan dimasukan ke file sampah?',
        text: "Anda bisa mengembalikan data ini pada file sampah!",
        type: "warning",
        showCancelButton: false,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Oke!',
    }).then(function () {
        $.ajax({
            url : "{{ url('admin/manajemen_indikator') }}" + '/' + id_indikator,
            type : "POST",
            data : {'_method' : 'DELETE', '_token' : csrf_token},
            success : function(data) {
              $('#table-indikator').dataTable().api().ajax.reload();
              $('#table-sampah-indikator').dataTable().api().ajax.reload();
              
                swal({
                    title: 'Success!',
                    text: 'Data Berhasil Dihapus!',
                    type: 'success',
                    timer: '1500'
                })
            },
            error : function () {
                swal({
                    title: 'Oops...',
                    text: ' Terjadi Kesalahan!',
                    type: 'error',
                    timer: '1500'
                })
            }
        });
    });
  }

  // script fungsi untuk create data
  $(function(){
    $('#form-modal-indikator form').validator().on('submit', function(e){
      if (!e.isDefaultPrevented()) {
        var id = $('#id_indikator').val();
        if (save_method == 'add') url = "{{ url('admin/manajemen_indikator') }}";
        else url = "{{ url('admin/manajemen_indikator').'/' }}"+id;

        $.ajax({
          
          url : url,
          type : 'POST',
          data : $('#form-modal-indikator form').serialize(),

          success : function($data){
            $('#form-modal-indikator').modal('hide');
            $('#table-indikator').dataTable().api().ajax.reload();
            swal({
              title:'Berhasil!',
              text:'Data Sudah Diperbarui',
              type:'success',
              timer:'1500'
            })
          },
          error:function(){
            swal({
              title:'Oops...',
              text:'Terjadi KEsalahan!',
              type:'error',
              timer:'1500'
            })
          }
        });
        return false;
      }
    });
  });

</script>