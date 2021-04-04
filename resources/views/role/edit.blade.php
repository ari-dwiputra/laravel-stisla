@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Role</h1>
            <div class="section-header-breadcrumb">
              	<div class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></div>
                <div class="breadcrumb-item"><a href="/role">Role</a></div>
              	<div class="breadcrumb-item">Edit Role</div>
            </div>
        </div>
        <div class="section-body">
        	<div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" id="roleForm" name="roleForm">
                      @csrf
                      <div class="form-group row">
                            <input id="id" type="hidden" value="{{$role->id}}" class="form-control" name="id">
                        <label for="name" class="col-md-2 col-form-label text-md-left">Nama Hak Akses<span style="color:red;">*</span></label>
                        <div class="col-md-4 validate">
                            <input id="name" type="text" class="form-control" name="name" value="{{$role->name}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="description" class="col-md-2 col-form-label text-md-left">Deskripsi</label>
                        <div class="col-md-4 validate">
                            <textarea id="description" name="description" class="form-control">{{$role->description}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="permissions">Permissions<span style="color:red;">*</span></label><br>
                        <div class="row col-sm-12">
                          @foreach ($permissions as $key => $value)
                            <div class="custom-control custom-checkbox col-sm-3">
                              <input type="checkbox" name="permission[]" class="custom-control-input" id="{{ $value }}" value="{{ $value }}" {{ in_array($value, $hasPermission) ? 'checked':'' }}>
                              <label for="{{ $value }}" class="custom-control-label">{{ $value }}</label>  
                            </div>
                          @endforeach
                        </div>
                      </div>
                      <button type="button" class="btn btn-primary with-loading" id="saveBtn" name="saveBtn">Simpan</button>
                      <a href="/role" class="btn btn-secondary">Batal</a>
                    </form>
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
    $('#saveBtn').click(function(e) {
      e.preventDefault();
      var isValid = $("#roleForm").valid();
      if(isValid){
        var id = $("#id").val();
        var url = "{{route('role/edit',['id'=>':id'])}}";
        url = url.replace(':id',id);
        $('#saveBtn').text('Simpan...');
        $('#saveBtn').attr('disabled',true);
        var formData = new FormData($('#roleForm')[0]);
        $.ajax({
          url : url,
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "JSON",
          success: function(data)
          {
            Swal.fire(
              (data.status) ? 'Berhasil' : 'Gagal',
              data.message,
              (data.status) ? 'success' : 'error'
            )
            $('#saveBtn').text('Simpan');
            $('#saveBtn').attr('disabled',false);
            (data.status)?window.location.href = "/role":'';
          },
          error: function (data)
          {
            Swal.fire(
                'Ups, terjadi kesalahan',
                'Tidak dapat menghubungi server, mohon coba beberapa saat lagi',
                'error'
            )
            $('#saveBtn').text('Simpan');
            $('#saveBtn').attr('disabled',false);
          }
        });
      }
    });
    $('#roleForm').validate({
      rules: {
        name: {
          required: true,
        },
      },
      messages: {
        name: {
          required: "Nama hak akses wajib diisi (*)",
        },
      },
      errorElement: 'em',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.validate').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>
@endpush