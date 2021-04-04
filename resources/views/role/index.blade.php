@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Role</h1>
            <div class="section-header-breadcrumb">
              	<div class="breadcrumb-item active"><a href="javascript:void(0)">Settings</a></div>
              	<div class="breadcrumb-item">Role</div>
            </div>
        </div>
        <div class="section-body">
        	<div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <a href="{{route('role/create')}}" class="btn btn-icon icon-left btn-primary" id="addNew" name="addNew"><i class="fas fa-plus"></i> Add Role</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover nowrap" id="rolesTable" style="width:100%">
                        <thead>
                          <tr>
                            <th style="background-color: #0000FF;" class="text-white" width="25%" id="name_table">Nama</th>
                            <th style="background-color: #0000FF;" class="text-white" width="50%" id="description_table">Deskripsi</th>
                            <th style="background-color: #FFA32F;" class="text-white" width="25%">Aksi</th>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
<script type="text/javascript">
  $(function(){
    let request = {
      start:0,
      length:10
    };

    var rolesTable = $('#rolesTable').DataTable( {
        "aaSorting": [],
        "ordering": false,
        "responsive": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 15, 25, 50, -1],
            [10, 15, 25, 50, "All"]
        ],
        "ajax": {
            "url": "{{route('role/getData')}}",
            "type": "POST",
            "headers":
              {
                  'X-CSRF-Token': $('input[name="_token"]').val()
              },
            "beforeSend": function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + $('#secret').val());
            },
            "Content-Type": "application/json",
            "data": function(data) {
                request.draw = data.draw;
                request.start = data.start;
                request.length = data.length;
                request.searchkey = data.search.value || "";

                return (request);
            },
        },
        "columns": [
            {
              "data": "name",
              "defaultContent": "-"
            },
            {
              "data": "description",
              "defaultContent": "-"
            },
            {
              "data": "id",
              render: function(data, type, row) {
                var btnEdit = "";
                  btnEdit = '<a href="/role/edit/'+data+'" id="btnEdit" name="btnEdit" data-id="' + data + '" type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-edit"></i></a>';
                var btnDelete = "";
                   var btnDelete = '<button id="btnDelete" name="btnDelete" data-id="' + data + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>';
                  return btnEdit+" "+btnDelete;
              },
            },
        ]
    });

    function reloadTable(){
      rolesTable.ajax.reload(null,false); //reload datatable ajax 
    }

    $('#rolesTable').on("click", "#btnDelete", function(){
        var id= $(this).attr('data-id');
        Swal.fire({
          title: 'Konfirmasi',
          text: "Anda akan menghapus hak akses ini. Apa anda yakin akan melanjutkan ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, saya yakin',
          cancelButtonText: 'Batal'
          }).then(function (result) {
            if (result.value) {
                var url = "{{route('role/delete',['id'=>':id'])}}";
                url = url.replace(':id',id);
                $.ajax({
                    headers:
                    {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    url: url,
                    type: "POST",
                    success: function (data) {
                      Swal.fire(
                        (data.status) ? 'Berhasil' : 'Gagal',
                        data.message,
                        (data.status) ? 'success' : 'error'
                      )
                      reloadTable();
                    },
                    error: function(response) {
                      Swal.fire(
                        'Ups, terjadi kesalahan',
                        'Tidak dapat menghubungi server, mohon coba beberapa saat lagi',
                        'error'
                      )
                    }
                });
            }
          })
    });
  });
</script>
@endpush