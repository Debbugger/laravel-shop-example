@extends('admin::main')

@section('title', 'Настройки')
@section('content')

    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Настройки</h4>
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('adminSettings') }}
                </ol>
            </div>
            <div class="row">
                @foreach($modules as $module)

                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $module['section'] }}</h3>
                            </div>
                            <div class="card-footer">
                                <a href="{{ url(LaravelLocalization::setLocale().config('app.admin_url').'/settings/'.$module['url']) }}" class="btn btn-block btn-outline-primary">Перейти</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection