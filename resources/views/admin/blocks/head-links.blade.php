<!doctype html>
<html lang="ru">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('admin-styles/fonts/fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-styles/plugins/datatable/dataTables.bootstrap4.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="{{ asset('admin-styles/css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-styles/css/adm_style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-styles/plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-styles/plugins/font-awesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('admin-styles/plugins\select2\select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-styles/plugins\air-date-picker\css\datepicker.min.css')}}">
</head>