<!DOCTYPE html>
<html>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <style type="text/css">
    	th {
    		text-align: center;
    	}
    	.right {
    		text-align: right;
    	}
    </style>
<body class="hold-transition skin-blue sidebar-mini">
       <div class="wrapper"> 
            <div class="content-wrapper">
                <section class="content">
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="img-fluid pull-left">
                			<img src="{{ asset('public/images/'.$setting->logo) }}" height="100">
										<br />
										{{ $setting->alamat }}
							</div>
							<div class="pull-right">
								<table>
									<tr>
										<td width="80">Tanggal</td>
										<td>: {{ tanggalIndonesia(date('Y-m-d')) }}</td>
									</tr>
									@if(!empty($penjualan->member->kode_member))
									<tr>
										<td>Kode Member</td>
										<td>: {{ $penjualan->member->kode_member }}</td>
									</tr>
									@endif
								</table>

							</div>
                		</div>
                	</div>
                	<br />
                	<div class="row">
                    <table class="table table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Produk</th>
									<th>Harga</th>
									<th>Jumlah</th>
									<th>Diskon</th>
									<th>Sub Total</th>
								</tr>
							</thead>
							<tbody>
								@foreach($penjualan->produk as $data)
									<tr>
										<td align="center">{{ ++$no }}</td>
										<td>{{ $data->nama_produk }}</td>
										<td class="right">{{ "Rp. ".formatUang($data->pivot->harga_jual) }}</td>
										<td align="center">{{ $data->pivot->jumlah }}</td>
										<td class="right">{{ $data->pivot->diskon. "%" }}</td>
										<td class="right">{{ "Rp. ".formatUang($data->pivot->sub_total) }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot >
								<tr>
									<th colspan="5" class="right">Total Harga</th>
									<th class="right">{{ "Rp. ".formatUang($penjualan->total_harga) }}</th>
								</tr>
								<tr>
									<th colspan="5" class="right">Diskon</th>
									<th class="right">{{ $penjualan->diskon."%" }}</th>
								</tr>
								<tr>
									<th colspan="5" class="right">Total Bayar</th>
									<th class="right">{{ "Rp. ".formatUang($penjualan->bayar) }}</th>
								</tr>
								<tr>
									<th colspan="5" class="right">Diterima</th>
									<th class="right">{{ "Rp. ".formatUang($penjualan->diterima) }}</th>
								</tr>								
								<tr>
									<th colspan="5" class="right">Kembali</th>
									<th class="right">{{ "Rp. ".formatUang($penjualan->diterima-$penjualan->bayar) }}</th>
								</tr>
							</tfoot>
						</table>
						<table width="100%">
							<tr>
								<td rowspan="3">
									Terima kasih telah berbelanja
								</td>
								<td align="center">
									Kasir
									<br /><br /><br />
									{{ Auth::user()->name }}
								</td>
							</tr>
						</table>
					</div>
                </section>
            </div>
        </div>
</body>
</html>