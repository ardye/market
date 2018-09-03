@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('breadcrumb')
	@parent
	<li>Dashboard</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
					<div class="col-lg-3 col-xs-6">
          			<!-- small box -->
          				<div class="small-box bg-aqua">
           					 <div class="inner">
              					<h3>{{ $kategori }}</h3>
              					<p>Kategori</p>
 					          </div>
            				<div class="icon">
              					<i class="fa fa-cube"></i>
            				</div>
            				<a href="{{ route('kategori.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          				</div>
       				</div>

			        <div class="col-lg-3 col-xs-6">
			          <!-- small box -->
			          <div class="small-box bg-green">
			            <div class="inner">
			              <h3>{{ $produk }}</h3>

			              <p>Produk</p>
			            </div>
			            <div class="icon">
			              <i class="fa fa-cubes"></i>
			            </div>
			            <a href="{{ route('produk.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			          </div>
			        </div>

		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3>{{ $member }}</h3>

		              <p>Member</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-credit-card"></i>
		            </div>
		            <a href="{{ route('member.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>

		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3>{{ $supplier }}</h3>

		              <p>Supplier</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa fa-truck"></i>
		            </div>
		            <a href="{{ route('supplier.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"> Grafik Pendapatan <small>{{ tanggalIndonesia($awal) }} - {{ tanggalIndonesia($akhir) }}</small></h3>
						</div>
						<div class="box-body">
							<div class="chart">
								<canvas id="salesChart" style="height: 250px;"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$(function(){
		    var salesChartCanvas = $('#salesChart').get(0).getContext('2d')
		    var salesChart       = new Chart(salesChartCanvas)

		    var salesChartData = {
		      labels  : {{ json_encode($data_tanggal) }},
		      datasets: [
		        {
		          label               : 'Electronics',
		          fillColor           : 'rgba(60, 141, 188, 0.9)',
		          strokeColor         : 'rgb(210, 214, 222)',
		          pointColor          : 'rgb(210, 214, 222)',
		          pointStrokeColor    : '#c1c7d1',
		          pointHighlightFill  : '#fff',
		          pointHighlightStroke: 'rgba(220,220,220,1)',
		          data                : {{ json_encode($data_pendapatan) }}
		        }
		      ]
		    }

    var salesChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    salesChart.Line(salesChartData, salesChartOptions);
		 });
	</script>
@endsection