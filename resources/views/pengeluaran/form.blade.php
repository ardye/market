<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-md">
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
						<label for="pengeluaran" class="col-md-3 control-label">Pengeluaran</label>
						<div class="col-md-6">
							<input type="text" name="pengeluaran" class="form-control" id="pengeluaran" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nominal" class="col-md-3 control-label">Nominal</label>
						<div class="col-md-6">
							<input type="number" name="nominal" class="form-control" id="nominal" required>
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