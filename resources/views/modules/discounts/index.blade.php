@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12"><h3 class="text-grey d-block mb-4">@lang('discounts.title')</h3></div>
        </div>
        <div class="row">
            @forelse($discounts as $discount)
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a href="{{route('discount',$discount->slug)}}" class="article-b">
                        <div class="image" style="background: url('{{asset($discount->image)}}')"></div>
                        <div class="info-b">
                            <div class="date mb-2">{{  $discount->created_at->format('d.m.y')}}</div>
                            <div class="name">{{  parseMultiLanguageString($discount->name ?? null, LaravelLocalization::getCurrentLocale())}}</div>
                            <p>{!!parseMultiLanguageString($discount->short_description ?? null, LaravelLocalization::getCurrentLocale())!!}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p> @lang('discounts.empty')</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection