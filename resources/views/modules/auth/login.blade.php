@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 mx-auto">
                <div class="h3-title text-grey text-center mb-4">@lang('login.title')</div>
                <div class="auth-b">
                    <form id="login-form" method="post" action="{{route('login')}}">
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
                        <div class="d-flex justify-content-center">
                            <a href="{{route('recovery')}}" class="text-grey mr-3">@lang('global.recovery')</a>
                            <a href="{{route('register')}}" class="text-primary">@lang('global.register')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (new SaveTrait({selector: '#login-form', showFailToast: true}))
    </script>
@endpush