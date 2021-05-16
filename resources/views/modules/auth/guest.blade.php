@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-5 col-lg-5   mx-auto">
                <div class=" list-product-b">
                    <div class="list-product-h mb-3 text-center">@lang('button.send-request')</div>
                    <ul class="nav nav-tabs pl-0 justify-content-center border-0" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-1" data-toggle="tab" href="#home1" role="tab" aria-controls="home1" aria-selected="false">@lang('card.new-client')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="home-tab-2" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="false">@lang('card.old-client')</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-10 mx-auto">
                    <div class="tab-content mt-4" id="myTabContent">
                        <div class="tab-pane fade active show" id="home1" role="tabpanel" aria-labelledby="home-tab">
                            <div class="auth-b">
                                <form id="register-form" method="post" action="{{route('cardProcess')}}">
                                    <div class="input-el-ico mb-3 form-group">
                                        <img class="img-fluid" src="{{asset('img/cellphone.svg')}}" alt="">
                                        <input name="phone" class="price input-el   w-100 text-left" placeholder="@lang('placeholder.phone')">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="input-el-ico mb-3 form-group">
                                        <img class="img-fluid" src="{{asset('img/cellphone.svg')}}" alt="">
                                        <input name="name" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.name')">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="input-el-ico mb-3 form-group">
                                        <img class="img-fluid" src="{{asset('img/cellphone.svg')}}" alt="">
                                        <input name="email" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.email')">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4 mb-3">
                                        <button type="submit" class="btn btn-primary btn-shadow px-4">@lang('button.send-request')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home2" role="tabpanel" aria-labelledby="home-tab">
                            <div class="auth-b">
                                <form id="login-form" method="post" action="{{route('cardProcessOld')}}">
                                    @csrf
                                    <div class="input-el-ico mb-3 form-group">
                                        <img src="{{asset('img/cellphone.svg')}}" alt="">
                                        <input name="phone" type="text" class="price input-el   w-100 text-left" placeholder="@lang('placeholder.phone')">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="input-el-ico mb-3 form-group">
                                        <img src="{{asset('img/locked-black-padlock.svg')}}" alt="">
                                        <input name="password" type="password" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.pass')">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4 mb-3">
                                        <button type="submit" class="btn btn-primary btn-shadow px-4">@lang('global.entry')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (new SaveTrait({selector: '#register-form', showFailToast: true}));
        (new SaveTrait({selector: '#login-form', showFailToast: true}));
    </script>
@endpush