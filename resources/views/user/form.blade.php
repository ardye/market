<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form-horizontal" data-toggle="validator" method="POST">
				{{ csrf_field() }}
				{{ method_field('POST') }}

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="close">
						<span aria-hidden="true"> &times; </span>
					</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Nama</label>
						<div class="col-md-6">
							<input type="text" name="nama" class="form-control" id="nama" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="col-md-3 control-label">Email</label>
						<div class="col-md-6">
							<input type="email" name="email" class="form-control" id="email" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="col-md-3 control-label">Password</label>
						<div class="col-md-6">
							<input type="password" name="password" class="form-control" id="password" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="password1" class="col-md-3 control-label">Ulang Password</label>
						<div class="col-md-6">
							<input type="password" name="password1" class="form-control" id="password1" data-match="#password" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-save btn-flat"><i class="fa fa-floppy-o"></i> Simpan</button>
					<button type="button" class="btn btn-warning btn-flat pull-left" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Kembali</button>
				</div>
			</form>
		</div>
	</div>
</div>