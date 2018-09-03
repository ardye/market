<div class="modal fade" id="modal-member" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true"> &times; </span>
				</button>
				<h4 class="modal-title">Cari Member</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped tabel-member">
					<thead>
						<tr>
							<th>Kode Member</th>
							<th>Nama Member</th>
							<th>Alamat</th>
							<th>Telpon</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($member as $data)
							<tr>
								<td>{{ $data->kode_member }}</td>
								<td>{{ $data->nama }}</td>
								<td>{{ $data->alamat }}</td>
								<td>{{ $data->telepon }}</td>
								<td><a onclick="selectMember({{ $data->id }})" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</div>