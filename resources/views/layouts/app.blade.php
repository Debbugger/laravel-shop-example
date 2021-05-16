<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="title" content="@yield('title')"/>
    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}"/>
    @stack('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin-styles/plugins\air-date-picker\css\datepicker.min.css')}}">
</head>
<body>
@include('layouts.header')
@yield('content')
@include('layouts.footer')
@include('layouts.scripts')
</body>
</html>