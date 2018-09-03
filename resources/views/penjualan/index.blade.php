@extends('layouts.app')

@section('title')
	Daftar Penjualan
@endsection

@section('breadcrumb')
	@parent
	<li>Penjualan</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<table class="table table-bordered table-striped tabel-penjualan">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Member</th>
								<th>Total Item</th>
								<th>Total Harga</th>
								<th>Diskon</th>
								<th>Total Bayar</th>
								<th>Kasir</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('penjualan.detail')
@endsection

@section('script')
	<script type="text/javascript">
		var table, save_method, table1;

		// Menampilkan DataTable
		$(function() {
			table = $('.tabel-penjualan').DataTable({
				"processing": true,
				"serverside": true,
				"ajax": {
					"url": "{{ route('penjualan.data') }}",
					"type": "GET"
				},
				"columnDefs": [{
					'targets': 8,
					'searchable': false,
					'orderable': false,
				}]
			});

			table1 = $('.tabel-detail').DataTable({
				"dom": 'Brt',
				"bSort": false,
				"processing": true,
				"serverside": true
			});

			$('.tabel-supplier').DataTable();
		});

		// Menampilkan form tambah
		function addForm() {
			$('#modal-supplier').modal('show');
		}

		function showDetail(id) {
			$('#modal-detail').modal('show');
			table1.ajax.url("penjualan/"+id+"/lihat");
			table1.ajax.reload();
		}


		function deleteData(id) {
			if(confirm("Apakah anda ingin menghapus data ?")) {
				$.ajax({
					url: 'penjualan/' + id,
					type: 'POST',
					data: {
						'_method': 'DELETE',
						'_token': $('meta[name=csrf-token]').attr('content')
					},
					success: function(data) {
						table.ajax.reload();
					},
					error: function() {
						alert("Gagal menghapus data");
					}
				});
			}
		}
		//Menghapus Data
	</script>
@endsection