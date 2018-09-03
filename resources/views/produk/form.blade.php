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
						<label for="kode" class="col-md-3 control-label">Kode Produk</label>
						<div class="col-md-6">
							<input type="number" name="kode" class="form-control" id="kode" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Nama Produk</label>
						<div class="col-md-6">
							<input type="text" name="nama" class="form-control" id="nama" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="kategori" class="col-md-3 control-label">Kategori</label>
						<div class="col-md-6">
							<select id="kategori" name="kategori" class="form-control" required>
								<option value="">-- Pilih Kategori --</option>
								@foreach ($kategori as $list)
									<option value="{{ $list->id }}">{{ $list->nama_kategori }}</option>
								@endforeach
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="merk" class="col-md-3 control-label">Merk</label>
						<div class="col-md-6">
							<input type="text" name="merk" class="form-control" id="merk" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="harga_beli" class="col-md-3 control-label">Harga Beli</label>
						<div class="col-md-6">
							<input type="number" name="harga_beli" class="form-control" id="harga_beli" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="diskon" class="col-md-3 control-label">Diskon</label>
						<div class="col-md-6">
							<input type="number" name="diskon" class="form-control" id="diskon" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="harga_jual" class="col-md-3 control-label">Harga Jual</label>
						<div class="col-md-6">
							<input type="number" name="harga_jual" class="form-control" id="harga_jual" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="stok" class="col-md-3 control-label">Stok</label>
						<div class="col-md-6">
							<input type="number" name="stok" class="form-control" id="stok" required>
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