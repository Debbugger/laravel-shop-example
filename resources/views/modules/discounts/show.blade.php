@extends('layouts.app')

@section('title', parseMultiLanguageString($discount->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($discount->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($discount->meta_description ?? ''))

@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto mt-5">
                <div class="date mb-2">{{  $discount->created_at->format('d.m.y')}}</div>
                <h3 class="text-grey d-block mb-4">{!!  parseMultiLanguageString($discount->name ?? null, LaravelLocalization::getCurrentLocale())!!}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="d-flex article-full-img"><img src="{{asset($discount->image)}}" class="img-fluid w-100" alt=""></div>
            </div>
            <div class="col-12 col-md-8 mx-auto">
                <div class="d-flex flex-column my-4">
                    <p>{!!   parseMultiLanguageString($discount->description ?? null, LaravelLocalization::getCurrentLocale())!!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection