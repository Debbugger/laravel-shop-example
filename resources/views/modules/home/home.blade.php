@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container">
        <div class="row">
            @include('modules.home.categories')
            @include('modules.home.discount')
        </div>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row">
            @include('modules.home.advantages')
        </div>
    </div>
    <div class="container mb-5">
        <div class="row">
            <div class="col-12">
                @include('modules.home.products')
            </div>
        </div>
    </div>
    <div class="container mb-5">
        @include('modules.home.reviews')
    </div>
    <div class="container">
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
@push('styles')
    <link rel="stylesheet" href="{{asset('css/swiper.min.css')}}">
@endpush
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
    <script>
        new Swiper('.swiper-discount', {
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
                clickable: true
            },
        });
        // initSwiper($('#myTabContent').find('.swiper-product:first-child'));
        initSwiper('#home1 .swiper-product');
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            initSwiper($(e.target).attr('href') + ' .swiper-product');
        });

        function initSwiper(selector) {
            new Swiper(selector, {
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                preventClicksPropagation: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpointsInverse: true,
                breakpoints: {
                    576: {
                        slidesPerView: 1,
                    },
                    678: {
                        slidesPerView: 2,
                    },
                    991: {
                        slidesPerView: 3,
                    },
                    1200: {
                        slidesPerView: 4,
                    }
                }
            });
        }
    </script>
@endpush