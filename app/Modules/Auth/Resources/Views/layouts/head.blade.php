<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="msapplication-TileColor" content="#0061da">
    <meta name="theme-color" content="#1643a3">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <!-- Title -->
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('admin-styles\fonts\fonts\font-awesome.min.css')}}">

    <!-- Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <!-- Dashboard Css -->
    <link href="{{asset('admin-styles\css\dashboard.css')}}" rel="stylesheet">

    <link href="{{asset('admin-styles\css\adm_style.css')}}" rel="stylesheet">

    <!-- c3.js Charts Plugin -->
    <link href="{{asset('admin-styles\plugins\charts-c3\c3-chart.css')}}" rel="stylesheet">

    <!-- Custom scroll bar css-->
    <link href="{{asset('admin-styles\plugins\scroll-bar\jquery.mCustomScrollbar.css')}}" rel="stylesheet">

    <!---Font icons-->
    <link href="{{asset('admin-styles\plugins\iconfonts\plugin.css')}}" rel="stylesheet">

</head>
@yield('content')
<!-- Dashboard js -->

<script src="{{asset('admin-styles\js\vendors\jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('admin-styles\js\vendors\bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin-styles\js\vendors\jquery.sparkline.min.js')}}"></script>
<script src="{{asset('admin-styles\js\vendors\selectize.min.js')}}"></script>
<script src="{{asset('admin-styles\js\vendors\jquery.tablesorter.min.js')}}"></script>
<script src="{{asset('admin-styles\js\vendors\circle-progress.min.js')}}"></script>
<script src="{{asset('admin-styles\plugins\rating\jquery.rating-stars.js')}}"></script>
<!-- Custom scroll bar Js-->
<script src="{{asset('admin-styles\plugins\scroll-bar\jquery.mCustomScrollbar.concat.min.js')}}"></script>

<!-- Custom Js-->
<script src="{{asset('admin-styles\js\custom.js')}}"></script>
<script src="{{ asset('admin-styles/js/save-trait.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@stack('scripts')
</body>


</html>