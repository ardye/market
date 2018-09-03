@extends('layouts.app')

@section('title')
	Daftar Pembelian
@endsection

@section('breadcrumb')
	@parent
	<li>Pembelian</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<a onclick="addForm()" class="btn btn-success btn-flat">
						<i class="fa fa-plus-circle"></i>
						Transaksi Baru
					</a>
					@if (!empty(session('id_pembelian')))
						<a href="{{ route('pembelian_detail.index') }}" class="btn btn-success btn-flat">
							<i class="fa fa-plus-circle"></i>
							Transaksi Aktif
						</a>
					@endif
				</div>
				<div class="box-body">
					<table class="table table-bordered table-striped tabel-pembelian">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Supplier</th>
								<th>Total Item</th>
								<th>Total Harga</th>
								<th>Diskon</th>
								<th>Total Bayar</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('pembelian.detail')
	@include('pembelian.supplier')
@endsection

@section('script')
	<script type="text/javascript">
		var table, save_method, table1;

		// Menampilkan DataTable
		$(function() {
			table = $('.tabel-pembelian').DataTable({
				"processing": true,
				"serverside": true,
				"ajax": {
					"url": "{{ route('pembelian.data') }}",
					"type": "GET"
				},
				"columnDefs": [{
					'targets': 7,
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
			table1.ajax.url("pembelian/"+id+"/lihat");
			table1.ajax.reload();
		}


		function deleteData(id) {
			if(confirm("Apakah anda ingin menghapus data ?")) {
				$.ajax({
					url: 'pembelian/' + id,
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