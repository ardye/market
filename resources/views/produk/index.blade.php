@extends('layouts.app')

@section('title')
	Daftar Produk
@endsection

@section('breadcrumb')
	@parent
	<li>Produk</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<a onclick="addForm()" class="btn btn-success btn-flat">
						<i class="fa fa-plus-circle"></i>
						 Tambah Data
					</a>					
					<a onclick="deleteAll()" class="btn btn-danger btn-flat">
						<i class="fa fa-trash"></i>
						 Hapus
					</a>					
					<a onclick="printBarcode()" class="btn btn-info btn-flat">
						<i class="fa fa-barcode"></i>
						 Cetak Barcode
					</a>
				</div>
				<div class="box-body">
					<form method="POST" id="form-produk">
						{{ csrf_field() }}
						{{ method_field('POST') }}
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><input type="checkbox" value="1" id="select-all"></th>
									<th>No</th>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Kategori</th>
									<th>Harga Jual</th>
									<th>Stok</th>
									<th width="150">Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	@include('produk.form')
@endsection

@section('script')
	<script type="text/javascript">
		var table, save_method;

		// Menampilkan DataTable
		$(function() {
			table = $('.table').DataTable({
				"processing": true,
				"serverside": true,
				"ajax": {
					"url": "{{ route('produk.data') }}",
					"type": "GET"
				},
				"columnDefs": [{
					'targets': 0,
					'searchable': false,
					'orderable': false
				},
				{
					'targets': 7,
					'searchable': false,
					'orderable': false
				}],
				"order": [1, 'asc']
			});

			//Checklist semua checkbox ketika id #select-all dicentang
			$('#select-all').click(function() {
				$('input[type="checkbox"]').prop('checked', this.checked);
			});
		});

		// Menampilkan form tambah
		function addForm() {
			save_method = "add";
			$('input[name=_method').val('POST');
			$('#modal-form').modal('show');
			$('#modal-form form')[0].reset();
			$('.modal-title').text('Tambah Produk');
			$('#kode').prop('disabled', false);
			$('#nama').val(data.nama_produk).prop('disabled', false);
			$('#kategori').val(data.id_kategori).prop('disabled', false);
			$('#merk').val(data.merk).prop('disabled', false);
			$('#harga_beli').val(data.harga_beli).prop('disabled', false);
			$('#harga_jual').val(data.harga_jual).prop('disabled', false);
			$('#diskon').val(data.diskon).prop('disabled', false);
			$('#stok').val(data.stok).prop('disabled', false);
			$('button[type=submit]').show();
		}

		//Save Data
		$('#modal-form form').validator().on('submit', function(e) {
			if(!e.isDefaultPrevented()) {
				var id = $('#id').val();
				save_method == "add" ? url = "{{ route('produk.store') }}" : url = "produk/" + id;

				$.ajax({
					url: url,
					type: 'POST',
					data: $('#modal-form form').serialize(),
					dataType: 'JSON',
					success: function(data) {
						if(data.msg == 'error') {
							alert('Kode produk sudah digunakan !');
						} else {
							$('#modal-form').modal('hide');
							table.ajax.reload();
						}
					},
					error: function() {
						alert("Tidak dapat menyimpan data");
					}
				});
				return false;			
			}	
		});
		function showDetail(id) {
			$('#modal-form form')[0].reset();
			$.ajax({
				url: 'produk/' + id,
				type: 'GET',
				dataType: 'JSON',
				success: function(data) {
					$('#modal-form').modal('show');
					$('.modal-title').text('Detail Produk');
					$('#id').val(data.id);
					$('#kode').val(data.kode_produk).prop('disabled', true);
					$('#nama').val(data.nama_produk).prop('disabled', true);
					$('#kategori').val(data.id_kategori).prop('disabled', true);
					$('#merk').val(data.merk).prop('disabled', true);
					$('#harga_beli').val(data.harga_beli).prop('disabled', true);
					$('#harga_jual').val(data.harga_jual).prop('disabled', true);
					$('#diskon').val(data.diskon).prop('disabled', true);
					$('#stok').val(data.stok).prop('disabled', true);
					$('button[type=submit]').hide();
				},
				error: function() {
					alert("Tidak dapat menampilkan data");
				}
			});
		}
		function editForm(id) {
			save_method = "edit";
			$('input[name=_method]').val('PATCH');
			$('#modal-form form')[0].reset();
			$.ajax({
				url: 'produk/' + id +'/edit',
				type: 'GET',
				dataType: 'JSON',
				success: function(data) {
					$('#modal-form').modal('show');
					$('.modal-title').text('Edit Produk');
					$('#id').val(data.id);
					$('#kode').val(data.kode_produk).prop('disabled', true);
					$('#nama').val(data.nama_produk).prop('disabled', false);
					$('#kategori').val(data.id_kategori).prop('disabled', false);
					$('#merk').val(data.merk).prop('disabled', false);
					$('#harga_beli').val(data.harga_beli).prop('disabled', false);
					$('#harga_jual').val(data.harga_jual).prop('disabled', false);
					$('#diskon').val(data.diskon).prop('disabled', false);
					$('#stok').val(data.stok).prop('disabled', false);
					$('button[type=submit]').show();
				},
				error: function() {
					alert("Tidak dapat menampilkan data");
				}
			});
		}

		function deleteData(id) {
			if(confirm("Apakah anda ingin menghapus data ?")) {
				$.ajax({
					url: 'produk/' + id,
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

		//menghapus data yang di centang
		function deleteAll() {
			if($('input:checked').length < 1) {
				alert('Pilih data yang akan dihapus');
			} else {
				if(confirm("Apakah anda ingin menghapus semua data terpilih ?")) {
					$.ajax({
						url: 'produk/hapus',
						type: 'POST',
						data: $('#form-produk').serialize(),
						success: function(data) {
							table.ajax.reload();
						},
						error: function() {
							alert("Gagal menghapus data");
						}
					});
				}
			}
		}

		//Mencetak Barcode
		function printBarcode() {
			if ($('input:checked').length < 1) {
				alert('Pilih data yang akan dicetak');
			} else {
				$('#form-produk').attr('target', '_blank').attr('action', 'produk/cetak').submit();
			}
		}
		//Menghapus Data
	</script>
@endsection