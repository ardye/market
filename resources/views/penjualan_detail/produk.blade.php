<div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true"> &times; </span>
				</button>
				<h4 class="modal-title">Cari Produk</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped tabel-produk">
					<thead>
						<tr>
							<th>Kode Produk</th>
							<th>Nama Produk</th>
							<th>Harga Jual</th>
							<th>Stok</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($produk as $data)
							<tr>
								<td>{{ $data->kode_produk }}</td>
								<td>{{ $data->nama_produk }}</td>
								<td>{{ formatUang($data->harga_jual) }}</td>
								<td>{{ $data->stok }}</td>
								<td><a onclick="selectItem({{ $data->id }})" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</div>