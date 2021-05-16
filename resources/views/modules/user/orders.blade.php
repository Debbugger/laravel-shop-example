@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-3 col-lg-2">
                @include('modules.user.links')
            </div>
            <div class="col-12 col-md-9 col-lg-10">
                <div class="order-table table-responsive-md">
                    @if($orders->isNotEmpty())
                        <table class="table table-bordered">
                            <thead class="thead-dark ">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('profile.home-name')</th>
                                <th scope="col">@lang('profile.home-count')</th>
                                <th scope="col">@lang('profile.home-cost')</th>
                                <th scope="col">@lang('profile.home-status')</th>
                                <th scope="col">@lang('profile.home-date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{$order->id}}</th>
                                    <td><a style="color:green;" href="{{route('product',['category'=>$order->products->first()->category->slug,'slug'=>$order->products->first()->slug])}}">{{parseMultiLanguageString($order->name ?? null, LaravelLocalization::getCurrentLocale())}}</a></td>
                                    <td>{{$order->count}}</td>
                                    <td class="text-primary">{{$order->sum}} грн</td>
                                    <td>
                                        @if ($order->status==1)
                                            @lang('profile.home-status-ready')
                                        @endif
                                        @if ($order->status==2)
                                            @lang('profile.home-status-lost')
                                        @endif
                                        @if ($order->status==3)
                                            @lang('profile.home-status-finish')
                                        @endif
                                    </td>
                                    <td>{{$order->created_at}}</td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    @else
                        @lang('profile.home-empty')
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
