@extends('layouts.app')

@section('title')
	Transaksi Selesai
@endsection

@section('breadcrumb')
	@parent
	<li>Transaksi</li>
	<li>Selesai</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<div class="alert alert-success alert-dismissable">
						<i class="icon fa fa-check"></i> Data Transaksi telah disimpan
					</div>
				</div>
				<div class="box-footer">
					<a class="btn btn-warning btn-lg btn-flat" onclick="tampilNota()">
						Cetak Nota
					</a>
					<script type="text/javascript">
						tampilNota();
						function tampilNota() {
							window.open("{{ route('transaksi.pdf') }}", "Nota PDF", "height=650,width=1024,left=150,scrollbars=yes");
						}
					</script>
					<a href="{{ route('transaksi.new') }}" class="btn btn-primary btn-lg btn-flat">Transaksi Baru</a>
				</div>
			</div>
		</div>
	</div>
@endsection