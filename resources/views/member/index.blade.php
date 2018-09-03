@extends('layouts.app')

@section('title')
	Daftar Member
@endsection

@section('breadcrumb')
	@parent
	<li>Member</li>
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
					<a onclick="printCard()" class="btn btn-info btn-flat">
						<i class="fa fa-credit-card"></i>
						 Cetak Kartu
					</a>					
				</div>
				<div class="box-body">
					<form method="POST" id="form-member">
						{{ csrf_field() }}
						{{ method_field('POST') }}
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><input type="checkbox" value="1" id="select-all"></th>
								<th>No</th>
								<th>Kode Member</th>
								<th>Nama Member</th>
								<th>Alamat</th>
								<th>Telepon</th>
								<th width="100">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</form>
				</div>
			</div>
		</div>
	</div>
	@include('member.form')
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
					"url": "{{ route('member.data') }}",
					"type": "GET"
				},
				"columnDefs": [{
					'targets': 6,
					'searchable': false,
					'orderable': false
				},
				{
					'targets': 0,
					'searchable': false,
					'orderable': false
				}],
				"order": [1, 'asc']
			});

			$('#select-all').click(function(event) {
				$('input[type="checkbox"]').prop('checked', this.checked);
			});
		});

		// Menampilkan form tambah
		function addForm() {
			save_method = "add";
			$('input[name=_method').val('POST');
			$('#modal-form').modal('show');
			$('#modal-form form')[0].reset();
			$('.modal-title').text('Tambah Member');
			$('#kode').attr('readonly', false);
		}

		//Save Data
		$('#modal-form form').validator().on('submit', function(e) {
			if(!e.isDefaultPrevented()) {
				var id = $('#id').val();
				save_method == "add" ? url = "{{ route('member.store') }}" : url = "member/" + id;

				$.ajax({
					url: url,
					type: 'POST',
					data: $('#modal-form form').serialize(),
					success: function(data) {
						if(data.msg == 'error') {
							alert("Kode produk sudah digunakan !");
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

		function editForm(id) {
			save_method = "edit";
			$('input[name=_method]').val('PATCH');
			$('#modal-form form')[0].reset();
			$.ajax({
				url: 'member/' + id +'/edit',
				type: 'GET',
				dataType: 'JSON',
				success: function(data) {
					$('#modal-form').modal('show');
					$('.modal-title').text('Edit member');
					$('#id').val(data.id);
					$('#kode').val(data.kode_member).attr('readonly', true);;
					$('#nama').val(data.nama);
					$('#alamat').val(data.alamat);
					$('#telepon').val(data.telepon);
				},
				error: function() {
					alert("Tidak dapat menampilkan data");
				}
			});
		}

		function deleteData(id) {
			if(confirm("Apakah anda ingin menghapus data ?")) {
				$.ajax({
					url: 'member/' + id,
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

		function printCard() {
			if($('input:checked').length < 1) {
				alert('Pilih data yang akan di cetak');
			} else{
				$('#form-member').attr('target', '_blank').attr('action', 'member/cetak').submit();
			}
		}
	</script>
@endsection