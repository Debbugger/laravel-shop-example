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
                <div class="settings-b">
                    <h3 class="h4-title mb-4 text-grey">@lang('profile.data-header')</h3>
                    <form id="data" action="{{route('userData')}}">
                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label class="input-el-l mb-2">@lang('profile.data-username')</label>
                                <input name="name" type="text" value="{{$currentUser->name}}" class="price input-el mr-3 mr-md-0 mb-3 disabled" disabled placeholder="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="date" class="input-el-l mb-2">@lang('profile.data-birthday')</label>
                                <input type="text" autocomplete="off" class="datepicker-here price input-el mr-3 mr-md-0 mb-3 " data-date-format="yyyy-mm-dd"  name="date" id="date" value="{{$currentUser->date}}" placeholder="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label class="input-el-l mb-2">@lang('profile.data-phone')</label>
                                <input name="phone" type="text" value="{{$currentUser->phone}}" class="price input-el mr-3 mr-md-0 mb-3 " placeholder="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label class="input-el-l mb-2">@lang('profile.data-email')</label>
                                <input name="email" type="text" value="{{$currentUser->email}}" class="price input-el mr-3 mr-md-0 mb-3 " placeholder="">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                    <div class="row  mt-4">
                        <div class="col-12 col-sm-6 d-flex justify-content-center justify-content-sm-end mb-3 mb-sm-0">
                            <button type="submit" class="btn btn-primary btn-shadow">@lang('button.save')</button>
                        </div>
                        <div class="col-12 col-sm-6 d-flex justify-content-center justify-content-sm-start">
                            <a href="{{route('userPass')}}" class="btn btn-primary btn-shadow">@lang('button.change-pass')</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        (new SaveTrait({selector:'#data'}));
    </script>
@endpush