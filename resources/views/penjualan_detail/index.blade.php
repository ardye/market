@extends('layouts.app')

@section('title')
	Transaksi Penjualan
@endsection

@section('breadcrumb')
	@parent
	<li>Penjualan</li>
	<li>Tambah</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<form class="form form-horizontal form-produk" method="POST">
						{{ csrf_field() }}
						<input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">

						<div class="form-group">
							<label for="id_produk" class="col-md-2 control-label">ID Produk</label>
							<div class="col-md-5">
								<div class="input-group">
									<input type="text" name="id_produk" id="id_produk" class="form-control" required>
									<span class="input-group-btn">
										<button onclick="showProduct()" type="button" class="btn btn-info btn-flat"><i class="fa fa-plus"></i></button>
									</span>
								</div>
							</div>
						</div>
					</form>
					
					<form class="form-keranjang">
						{{ csrf_field() }}
						{{ method_field('PATCH') }}
						<table class="table table-striped tabel-penjualan">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Harga</th>
									<th>Jumlah</th>
									<th>Diskon</th>
									<th>Sub Total</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</form>
					<div class="col-md-8">
						<div id="tampil-bayar" style="
									background: #dd4b39;
									color: #fff;
									font-size: 80px;
									text-align: center;
									height: 100px;
						"></div>
						<div id="tampil-terbilang" style="
									background: #3c8dbc;
									color: #fff;
									font-weight: : bold;
									padding: 10px;
						"></div>
					</div>
						<div class="col-md-4">
							<form class="form form-horizontal form-penjualan" method="POST" action="transaksi/simpan">
								{{ csrf_field() }}
								<input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
								<input type="hidden" name="total" id="total">
								<input type="hidden" name="total_item" id="total_item">
								<input type="hidden" name="bayar" id="bayar">

								<div class="form-group">
									<label for="totalrp" class="col-md-4 control-label">Total</label>
									<div class="col-md-8"> 
										<input type="text" class="form-control" name="totalrp" id="totalrp" readonly>
									</div>
								</div>
								

								<div class="form-group">
									<label for="member" class="col-md-4 control-label">ID Member</label>
									<div class="col-md-8"> 
										<div class="input-group">
											<input type="text" class="form-control" name="member" id="member" value="0">
											<span class="input-group-btn">
												<button type = "button" onclick="showMember()" class="btn btn-info btn-flat">...</button>
											</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="diskon" class="col-md-4 control-label">Diskon</label>
									<div class="col-md-8"> 
										<input type="number" class="form-control" name="diskon" id="diskon" value="0" required>
									</div>
								</div>

								<div class="form-group">
									<label for="bayarrp" class="col-md-4 control-label">Bayar</label>
									<div class="col-md-8"> 
										<input type="text" class="form-control" name="bayarrp" id="bayarrp" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="diterima" class="col-md-4 control-label">Diterima</label>
									<div class="col-md-8"> 
										<input type="text" class="form-control" name="diterima" id="diterima" value="0">
									</div>
								</div>

								<div class="form-group">
									<label for="kembali" class="col-md-4 control-label">Kembali</label>
									<div class="col-md-8"> 
										<input type="text" class="form-control" name="kembali" id="kembali" readonly>
									</div>
								</div>
							</form>
						</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
				</div>
			</div>
		</div>
	</div>
	@include('penjualan_detail.produk')
	@include('penjualan_detail.member')
@endsection

@section('script')
	<script type="text/javascript">
		var table;

		// Menampilkan DataTable
		$(function() {
			$('.tabel-produk').DataTable();
			$('.tabel-member').DataTable();
			table = $('.tabel-penjualan').DataTable({
				"dom": 'Brt',
				"bSort": false,
				"processing": true,
				"ajax": {
					"url": "{{ route('transaksi.data', $id_penjualan) }}",
					"type": "GET"
				}
			}).on('draw.dt', function(){
				loadForm($('#diskon').val());
			});	
					//Menghindari submit form saat dienter paa kodeproduk dan jumlah
		$(".form-produk").on('submit', function(){
			return false;
		});
		$('body').addClass('sidebar-collapse');
		$('.form-keranjang').submit(function() {
			return false;
		});


		//proses ketika kode produk atau diskon diubah
		$('#id_produk').change(function() {
			addItem();
		});	

		$('#member').change(function() {
			selectMember($(this).val());
		});	

		$('#diskon').change(function() {
			if($(this).val() == "") {
				$(this).val(0).select();
			}
				loadForm($(this).val());
		});

		$('#diterima').change(function() {
			if($(this).val() == "") {
				$(this).val(0).select();
			} loadForm($('#diskon').val(), $(this).val());
		}).focus(function() {
			$(this).select();
		});

		//Menyimpan form transaksi saat tombol simpan diklik
		$('.simpan').click(function() {
			$('.form-penjualan').submit();
		});
		});


		function addItem() {
			$.ajax({
				url: "{{ route('transaksi.store') }}",
				type: "POST",
				data: $('.form-produk').serialize(),
				success: function(data) {
					$('#id_produk').val('').focus();
					table.ajax.reload(function() {
						loadForm($('#diskon').val());
					});
				},
				error: function() {
					alert("Tidak dapat menyimpan data");
				}
			});
		}

		function showProduct() {
			$('#modal-produk').modal('show');
		}

		function showMember() {
			$('#modal-member').modal('show');
		}

		function selectItem(id) {
			$('#id_produk').val(id);
			$('#modal-produk').modal('hide');
			addItem();
		}

		function selectMember(id) {
			$('#modal-member').modal('hide');
			$('#diskon').val('{{ $setting->diskon_member }}');
			$('#member').val(id);
			loadForm($('#diskon').val());
			$('#diterima').val(0).focus().select();
		}

		function changeCount(id) {
			$.ajax({
				url: "transaksi/" + id,
				type: "POST",
				data: $('.form-keranjang').serialize(),
				dataType: 'JSON',
				success: function(data) {
						if(data.msg == 'error') {
							alert('Pesanan melebihi stok!');
						} else if(data.msg == 'success') {
							$('#id_produk').val('').focus();
							table.ajax.reload(function() {
								loadForm($('#diskon').val());
							});
						} else {
							deleteItem(data.id);
						}
				},
				error: function() {
					alert("Tidak dapat menyimpan data");
				}
			});
		}



		function deleteItem(id) {
			if(confirm("Apakah anda ingin menghapus data ?")) {
				$.ajax({
					url: 'transaksi/' + id,
					type: 'POST',
					data: {
						'_method': 'DELETE',
						'_token': $('meta[name=csrf-token]').attr('content')
					},
					success: function(data) {
						table.ajax.reload(function() {
							loadForm($('#diskon').val());
						});
					},
					error: function() {
						alert("Gagal menghapus data");
					}
				});
			}
		}

		function loadForm(diskon=0, diterima=0) {
			$('#total').val($('.total').text());
			$('#total_item').val($('.total_item').text());

			$.ajax({
				url: "transaksi/loadform/"+diskon+"/"+$('#total').val()+"/"+diterima,
				type: "GET",
				dataType: "JSON",
				success: function(data) {
					$('#totalrp').val(data.totalrp);
					$('#bayarrp').val(data.bayarrp);
					$('#bayar').val(data.bayar);
					$('#tampil-bayar').text(data.bayarrp);
					$('#tampil-terbilang').text(data.terbilang);
					$('#kembali').val(data.kembalirp);
					if($('#diterima').val() != 0) {
						$('#tampil-bayar').html("<small>Kembali:</small> "+data.kembalirp);
						$('#tampil-terbilang').text(data.kembali_terbilang);
					}
				},
				error: function() {
					alert("Tidak dapat menampilkan data");
				}
			});
		}
		//Menghapus Data
	</script>
@endsection