<div class="modal fade" id="modal-supplier" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true"> &times; </span>
				</button>
				<h4 class="modal-title">Pilih Supplier</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped tabel-supplier">
					<thead>
						<tr>
							<th>Nama Supplier</th>
							<th>Alamat</th>
							<th>Telepon</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($supplier as $data)
							<tr>
								<td>{{ $data->nama }}</td>
								<td>{{ $data->alamat }}</td>
								<td>{{ $data->telepon }}</td>
								<td><a href="pembelian/{{ $data->id }}/tambah" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</div>