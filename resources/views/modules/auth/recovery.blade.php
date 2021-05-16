@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div id="pass-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">@lang('recovery.modal-title')</h4>
                    <a class="close" style="cursor: pointer;" data-dismiss="modal" aria-hidden="true">×</a>
                </div>
                <form method="post" action="{{route('changePass')}}" id="change-pass" class="form-modal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <input name="code" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.code')">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-el-ico mb-3 form-group">
                                    <img src="{{asset('img/locked-black-padlock.svg')}}" alt="">
                                    <input type="password" name="password" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.pass-new')">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-el-ico mb-3 form-group">
                                    <img src="{{asset('img/locked-black-padlock.svg')}}" alt="">
                                    <input type="password" name="password_confirmation" class="price input-el  w-100 text-left" placeholder="@lang('placeholder.pass-repeat')">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">@lang('modal.off')</button>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-shadow  w-100">@lang('modal.change')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3 mx-auto">
                <div class="h3-title text-grey text-center mb-4">@lang('recovery.title')</div>
                <div class="auth-b">
                    <form id="recovery" method="post" action="{{route('recovery')}}">
                        <div class="input-el-ico mb-3 form-group">
                            <img src="{{asset('img/cellphone.svg')}}" alt="">
                            <input name="phone" type="text" class="price input-el   w-100 text-left" placeholder="@lang('placeholder.phone')">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="submit" class="btn btn-primary btn-shadow px-4" >@lang('button.send')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (new SaveTrait({selector: '#recovery', showFailToast: true}).setAdditionalSuccessCallback(function (callback) {
            $('#pass-modal').find('.modal-title').html('@lang('recovery.modal-title'): '+callback.created);
            $('#pass-modal').modal();
        }));
        (new SaveTrait({selector: '#change-pass', showFailToast: true,clearFormOnSuccess: true}));
    </script>
@endpush