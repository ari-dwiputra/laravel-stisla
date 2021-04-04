@extends('layouts.app')

@section('content')
<div class="modal fade" id="updateUserModal" role="dialog" aria-labelledby="updateUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST"  action="{{ route('user/update') }}" id="updateUserForm" name="updateUserForm">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="updateUserModalLabel">Form Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @csrf
        <div class="alert alert-warning alert-dismissible fade animated jello show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="alert-heading">Keterangan!</h5>
          <hr>
          <p class="mb-0">
              - (*) Jika memiliki tanda seperti ini data wajib diisi.<br>
              - Foto maksimal berukuran <b>2 MB</b> dengan format JPG, PNG, JPEG.
          </p>
        </div>
        <input id="id" name="id" type="hidden" class="form-control">
        <div class="form-group row">
            <label for="username" class="col-md-4 col-form-label text-md-left">Username (*)</label>
            <div class="col-md-8 validate">
                <input id="username" type="text" class="form-control" name="username">
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-left">Nama (*)</label>
            <div class="col-md-8 validate">
                <input id="name" type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-left">Email (*)</label>
            <div class="col-md-8 validate">
                <input id="email" type="email" class="form-control" name="email">
            </div>
        </div>
        <div class="form-group row">
            <label for="photo" class="col-md-4 col-form-label text-md-left">Upload Foto</label>
            <div class="col-md-8 validate">
                <input id="photo" type="file" class="form-control" name="photo">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary with-loading" id="updateBtn" name="updateBtn">Simpan</button>
        <button type="button" class="btn btn-secondary btn-modal-dismiss" data-dismiss="modal">Tutup</button>
      </div>
       </form>
    </div>
  </div>
</div>
<div class="modal fade" id="changePasswordModal" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST"  action="{{ route('user/password') }}" id="changePasswordForm" name="changePasswordForm">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="changePasswordModalLabel">Form Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @csrf
        <div class="alert alert-warning alert-dismissible fade animated jello show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="alert-heading">Keterangan!</h5>
          <hr>
          <p class="mb-0">
              - (*) Jika memiliki tanda seperti ini data wajib diisi.
          </p>
        </div>
        <input id="idUser" type="hidden" class="form-control" name="id"/>
        <div class="form-group row">
            <label for="newPassword" class="col-md-4 col-form-label text-md-left">New Password (*)</label>
            <div class="col-md-8 validate">
                <input id="newPassword" type="password" class="form-control" name="password"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="newPasswordConfirm" class="col-md-4 col-form-label text-md-left">Confirm Password (*)</label>
            <div class="col-md-8 validate">
                <input id="newPasswordConfirm" type="password" class="form-control" name="password_confirm"/>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary with-loading" id="passwordBtn" name="passwordBtn">Simpan</button>
        <button type="button" class="btn btn-secondary btn-modal-dismiss" data-dismiss="modal">Tutup</button>
      </div>
       </form>
    </div>
  </div>
</div>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
              	<div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
              	<div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
              <div style="background-image: url('{{ auth()->user()->photo != '' ? asset('storage/images/user/' . auth()->user()->photo) : asset('assets/img/avatar/avatar-1.png') }}'); background-position: center; background-size: cover;" class="col-12 col-md-12 col-lg-5">
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                      <h4>Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Name</label>
                            <input type="text" readonly="" class="form-control" value="{{ Auth::user()->name }}">
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Email</label>
                            <input type="text" readonly="" class="form-control" value="{{ Auth::user()->email }}">
                          </div>
                        </div>
                         <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Username</label>
                            <input type="text" readonly="" class="form-control" value="{{ Auth::user()->username }}">
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Role</label>
                            <input type="text" readonly="" class="form-control" value="{{ Auth::user()->roles[0]->name }}">
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-warning" id="btnUpdateProfile">Update Profile</button>
                      <button class="btn btn-primary" id="btnChangePassword">Change Password</button>
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
	let id = '{{ Auth::user()->id }}';

	$('#btnUpdateProfile').click(function(e) {
	    e.preventDefault();
	  	$('#updateUserModal').modal('show');
	  	var url = "{{route('user',['id'=>':id'])}}";
	  	url = url.replace(':id', id);
	  	$.ajax({
		  	type: 'GET',
		    url: url,
		    success: function(response) {
		        $('#name').val(response.data.name);
		        $('#username').val(response.data.username);
		        $('#id').val(response.data.id);
		        $('#email').val(response.data.email);
    		},
    		error: function(){
		        Swal.fire(
		            'Ups, terjadi kesalahan',
		            'Tidak dapat menghubungi server, mohon coba beberapa saat lagi',
		            'error'
		        )
    		},
	  	});
	});
	$('#btnChangePassword').click(function(e) {
	    e.preventDefault();
	    $('#changePasswordModal').modal('show');
	    $('#newPassword').val("");
	    $('#newPasswordConfirm').val("");
	    $('#idUser').val(id);
  	});
	$('#updateBtn').click(function(e) {
	    e.preventDefault();
	    var isValid = $("#updateUserForm").valid();
	    var formData = new FormData($('#updateUserForm')[0]);
	    if(isValid){
			$('#updateBtn').text('Simpan...');
			$('#updateBtn').attr('disabled',true);
			var url = "{{route('profile/update')}}";
			$.ajax({
		        url : url,
		        type: "POST",
		        data: formData,
		        contentType: false,
		        processData: false,
		        dataType: "JSON",
		        headers:
					{
					'X-CSRF-Token': $('input[name="_token"]').val()
					},
		        success: function(data)
		        {
      				Swal.fire(
		                (data.status) ? 'Berhasil' : 'Gagal',
		                data.message,
		                (data.status) ? 'success' : 'error'
            		)
					$('#updateBtn').text('Simpan');
					$('#updateBtn').attr('disabled',false);
					$('#updateUserModal').modal('hide');
        		},
		        error: function (data)
		        {
          			Swal.fire(
						'Ups, terjadi kesalahan',
						'Tidak dapat menghubungi server, mohon coba beberapa saat lagi',
						'error'
          			)
					$('#updateBtn').text('Simpan');
					$('#updateBtn').attr('disabled',false);
        		}
    		});
    	}
  	});
  	$('#passwordBtn').click(function(e) {
	    e.preventDefault();
	    var isValid = $("#changePasswordForm").valid();
	    var formData = new FormData($('#changePasswordForm')[0]);
	    if(isValid){
    		$('#passwordBtn').text('Simpan...');
			$('#passwordBtn').attr('disabled',true);
			var url = "{{route('profile/password')}}";
			$.ajax({
		        url : url,
		        type: "POST",
		        data: formData,
		        contentType: false,
		        processData: false,
		        dataType: "JSON",
		        headers:
		          {
		          'X-CSRF-Token': $('input[name="_token"]').val()
		          },
		        success: function(data)
		        {
					Swal.fire(
						(data.status) ? 'Berhasil' : 'Gagal',
						data.message,
						(data.status) ? 'success' : 'error'
					)
					$('#passwordBtn').text('Simpan');
					$('#passwordBtn').attr('disabled',false);
					$('#changePasswordModal').modal('hide');
					},
				error: function (data)
				{
					Swal.fire(
						'Ups, terjadi kesalahan',
						'Tidak dapat menghubungi server, mohon coba beberapa saat lagi',
						'error'
					)
					$('#passwordBtn').text('Simpan');
					$('#passwordBtn').attr('disabled',false);
				}
    		});
    	}
  	});
  	$('#updateUserForm').validate({
		rules: {
			username: {
				required: true,
			},
			name: {
				required: true,
			},
			email: {
				required: true,
				email: true,
			},
			role_id: {
				required: true,
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
	$('#changePasswordForm').validate({
		rules: {
			password: {
				required: true,
				minlength: 8
			},
			password_confirm: {
				required: true,
				minlength: 8,
				equalTo: "#newPassword"
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
