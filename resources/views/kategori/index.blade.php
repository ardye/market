@extends('layouts.app')

@section('title')
	Daftar Kategori
@endsection

@section('breadcrumb')
	@parent
	<li>Kategori</li>
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
				</div>
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Kategori</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('kategori.form')
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
					"url": "{{ route('kategori.data') }}",
					"type": "GET"
				},
				"columnDefs": [{
					'targets': 2,
					'searchable': false,
					'orderable': false,
				}]
			});
		});

		// Menampilkan form tambah
		function addForm() {
			save_method = "add";
			$('input[name=_method').val('POST');
			$('#modal-form').modal('show');
			$('#modal-form form')[0].reset();
			$('.modal-title').text('Tambah Kategori');
		}

		//Save Data
		$('#modal-form form').validator().on('submit', function(e) {
			if(!e.isDefaultPrevented()) {
				var id = $('#id').val();
				save_method == "add" ? url = "{{ route('kategori.store') }}" : url = "kategori/" + id;

				$.ajax({
					url: url,
					type: 'POST',
					data: $('#modal-form form').serialize(),
					success: function(data) {
						$('#modal-form').modal('hide');
						table.ajax.reload();
					},
					error: function() {
						alert("Tidak dapat menyimpan data");
					}
				});
				return false;			
			}	
		});

		function editForm(id) {
			save_method = "edit";
			$('input[name=_method]').val('PATCH');
			$('#modal-form form')[0].reset();
			$.ajax({
				url: 'kategori/' + id +'/edit',
				type: 'GET',
				dataType: 'JSON',
				success: function(data) {
					$('#modal-form').modal('show');
					$('.modal-title').text('Edit Kategori');
					$('#id').val(data.id);
					$('#nama').val(data.nama_kategori);
				},
				error: function() {
					alert("Tidak dapat menampilkan data");
				}
			});
		}

		function deleteData(id) {
			if(confirm("Apakah anda ingin menghapus data ?")) {
				$.ajax({
					url: 'kategori/' + id,
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