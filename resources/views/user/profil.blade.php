@extends('layouts.app')

@section('title')
	Edit Profil
@endsection

@section('breadcrumb')
	@parent
	<li>User</li>
	<li>Edit Profil</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<form class="form form-horizontal" data-toggle="validator"
				method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					<div class="box-body">
						<div class="alert alert-info alert-dismissable" style="display: none;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
							<i class="icon fa fa-check"></i>
							Perubahan berhasil disimpan
						</div>	
					<div class="form-group">
						<label for="foto" class="col-md-2 control-label">Foto Profil</label>
						<div class="col-md-4">
							<input type="file" name="foto" id="foto" class="form-control">
							<br />
							<div class="tampil-foto">
								<img src="{{ asset('public/images/'. Auth::user()->foto) }}" alt="User Foto" width="200">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="passwordlama" class="col-md-2 control-label">Password Lama</label>
						<div class="col-md-6">
							<input type="password" name="passwordlama" id="passwordlama" class="form-control">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="col-md-2 control-label">Password</label>
						<div class="col-md-6">
							<input type="password" name="password" id="password" class="form-control">
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="password1" class="col-md-2 control-label">Ulang Password</label>
						<div class="col-md-6">
							<input type="password" name="password1" id="password1" class="form-control" data-match="#password">
							<span class="help-block with-errors"></span>
						</div>
					</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		//ketika password lama diketik
		$('#passwordlama').keyup(function(event) {
			$(this).val() != "" ? $('#password, #password1').attr('required', true) : $('#password, #password1').attr('required', false)
		});
		$('.form').validator().on('submit', function(e) {
			if(!e.isDefaultPrevented()) {
				$.ajax({
						url: "{{ Auth::user()->id }}/change",
						type: "POST",
						data: new FormData($('.form')[0]),
						dataType: 'JSON',
						async: false,
						processData: false,
						contentType: false,
						success: function(data) {
							//Tampilkan pesan jika data error
							if(data.msg == "error") {
								alert('Password Lama Salah');
								$('#passwordlama').focus().select();
							} else {
								var d = new Date();
								$('.alert').css('display', 'block').delay(2000).fadeOut();

								//update foto
								$('.tampil-foto img, .user-image, .user-header img').attr('src', data.url+'?'+d.getTime());
							}
						},
						error: function(){
							alert('Tidak dapat menyimpan data!');
						}
					});
				return false;			
			}	
		});
	</script>
@endsection