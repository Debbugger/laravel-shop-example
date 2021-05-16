@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @lang('home.page')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div id="map" class="map-container"></div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9vekIfn4uRsSdGJlS_Dzg-swAmsN60L0&callback=initMap"></script>
    <script>
        var map;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: -34.397,
                    lng: 150.644
                },
                zoom: 8
            });
        }
    </script>
@endpush