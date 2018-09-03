<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminLTE/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/adminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
     <link rel="stylesheet" href="{{ asset('public/adminLTE/dist/css/skins/_all-skins.min.css') }}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
       <div class="wrapper"> 
            @include('layouts.header')
            @include('layouts.sidebar')
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        @yield('title')
                    </h1>
                    <ol class="breadcrumb">
                        @section('breadcrumb')
                        <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                        @show
                </section>

                <section class="content">
                    @yield('content')
                </section>
            </div>
            @include('layouts.footer')
        </div>
    <!-- Scripts -->
    <script src="{{ asset('public/adminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('public/adminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/adminLTE/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('public/adminLTE/dist/js/demo.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('public/adminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('public/adminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('public/adminLTE/bower_components/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('public/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/adminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script src="{{ asset('public/adminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/js/validator.min.js') }}"></script>
    @yield('script')
</body>
</html>