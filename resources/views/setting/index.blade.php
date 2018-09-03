@extends('layouts.app')

@section('title')
	Pengaturan
@endsection

@section('breadcrumb')
	@parent
	<li>Pengaturan</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<form class="form form-horizontal" data-toggle="validator" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					<div class="box-body">
						<div class="alert alert-info alert-dismissable" style="display: none;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="icon fa fa-check"></i>
							Perubahan berhasil disimpan
						</div>	

					<div class="form-group">
						<label for="nama" class="col-md-2 control-label">Nama Perusahaan</label>
						<div class="col-md-6">
							<input type="text" name="nama" id="nama" class="form-control" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="alamat" class="col-md-2 control-label">Alamat</label>
						<div class="col-md-6">
							<textarea name="alamat" id="alamat" class="form-control" required></textarea>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="telepon" class="col-md-2 control-label">Telepon</label>
						<div class="col-md-6">
							<input type="number" name="telepon" id="telepon" class="form-control" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="logo" class="col-md-2 control-label">Logo</label>
						<div class="col-md-4">
							<input type="file" name="logo" id="logo" class="form-control">
							<br />
							<div class="tampil-logo">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="member" class="col-md-2 control-label">Kartu Member</label>
						<div class="col-md-4">
							<input type="file" name="member" id="member" class="form-control">
							<br />
							<div class="tampil-member">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="diskon" class="col-md-2 control-label">Diskon Member (%)</label>
						<div class="col-md-6">
							<input type="number" name="diskon" id="diskon" class="form-control" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="tipe_nota" class="col-md-2 control-label">Tipe Nota</label>
						<div class="col-md-6">
							<select name="tipe_nota" id="tipe_nota" class="form-control">
								<option value="0">Nota Kecil</option>
								<option value="1">Nota Besar (PDF)</option>
							</select>
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

		$(function() {
			showData();
					//ketika password lama diketik
		$('.form').validator().on('submit', function(e) {
			if(!e.isDefaultPrevented()) {
				$.ajax({
					url: 'setting/1',
					type: "POST",
					data: new FormData($('.form')[0]),
					async: false,	
					processData: false,
					contentType: false,
					success: function(data) {
						showData();
             			$('.alert').css('display', 'block').delay(2000).fadeOut();
						
					},
					error: function() {
						alert('Tidak dapat menyimpan data!');
					}
				});
				return false;			
			}	
		});
		});

		function showData() {
			$.ajax({
				url: "setting/1/edit",
				type: "GET",
				dataType: 'JSON',
				success: function(data) {
					$('#nama').val(data.nama_perusahaan);
					$('#alamat').val(data.alamat);
					$('#telepon').val(data.telepon);
					$('#diskon').val(data.diskon_member);
					$('#tipe_nota').val(data.tipe_nota);

					var d = new Date();
					$('.tampil-logo').html('<img class="img img-thumbnail" src="public/images/'+data.logo+'?'+d.getTime()+'">');
					$('.tampil-member').html('<img class="img img-thumbnail" src="public/images/'+data.kartu_member+'?'+d.getTime()+'">');
				},
				error: function() {
					alert('Tidak dapat menampilkan data!');
				}
			});
		}
	</script>
@endsection