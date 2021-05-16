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
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto">
                        <div class="h3-title text-grey text-center mb-4">@lang('profile.pass')</div>
                        <form id="pass" action="{{route('userPass')}}">
                            <div class="auth-b">
                                <div class="input-el-ico mb-3 form-group">
                                    <img src="{{asset('img/unlocked-padlock.svg')}}" alt="">
                                    <input type="password" name="current" class="price input-el   w-100 text-left" placeholder="@lang('placeholder.pass-current')">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="input-el-ico mb-3 form-group">
                                    <img src="{{asset('img/locked-black-padlock.svg')}}" alt="">
                                    <input type="password" name="password" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.pass-new')">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="input-el-ico mb-3 form-group">
                                    <img src="{{asset('img/locked-black-padlock.svg')}}" alt="">
                                    <input type="password" name="password_confirmation" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.pass-repeat')">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="d-flex justify-content-center mt-4 mb-3">
                                    <button type="submit" class="btn btn-primary btn-shadow px-4">@lang('button.change-pass')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (new SaveTrait({selector: '#pass', clearFormOnSuccess: true,showFailToast:true}));
    </script>
@endpush