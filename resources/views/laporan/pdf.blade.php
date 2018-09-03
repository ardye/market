<!DOCTYPE html>
<html>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

<body class="hold-transition skin-blue sidebar-mini">
	<h3 class="text-center">Laporan Pendapatan</h3>
	<h4 class="text-center">
	Tanggal {{ tanggalIndonesia($tanggal_awal) }} s/d {{ tanggalIndonesia($tanggal_akhir) }}
</h4>
<hr>
<table class="table table-striped">
	<thead>
		<tr>
		<th class="text-center">No</th>
		<th width="100" class="text-center">Tanggal</th>
		<th class="text-center">Penjualan</th>
		<th class="text-center">Pembelian</th>
		<th class="text-center">Pengeluaran</th>
		<th class="text-center">Pendapatan</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($data as $row)
			<tr>
				@foreach($row as $count)
					<td>{{ $count }}</td>
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>
</body>
</html>