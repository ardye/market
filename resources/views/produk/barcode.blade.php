<title>Cetak Barcode</title>
<body>
	<table width="100%">
		<tr>
			@foreach($dataProduk as $data)
				<td align="center" style="border: 1px solid #ccc">
					{{ $data->nama_produk }} - Rp. {{ formatUang($data->harga_jual) }}
					<br /><br />
					<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($data->kode_produk, 'C39')}}" height="60" width="180" alt="Barcode">
					<br />
					{{ $data->kode_produk }}
				</td>
				@if ($no++ % 3 == 0)
					</tr><tr>
				@endif
			@endforeach
		</tr>
	</table>
</body>