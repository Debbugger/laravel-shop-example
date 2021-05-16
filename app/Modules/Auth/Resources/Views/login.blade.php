@extends('auth::layouts.head')

@section('title', 'Авторизация')

@section('content')
    <body class="login-img">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col col-login mx-auto">
                        <div class="text-center mb-6">
                            <img src="{{asset('admin-styles\images\brand\logo.png')}}" class="h-6" alt="">
                        </div>
                        <form id="login-form" class="card" method="post" action="{{route('login')}}">@csrf
                            <div class="card-body p-6">
                                <div class="card-title text-center">Авторизация</div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Пароль
                                        <a href="forgot-password.html" class="float-right small">Я забыл пароль</a>
                                    </label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-label">Запомнит меня</span>
                                    </label>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                </div>
                                <div class="text-center text-muted mt-4">
                                    Нету аккаунта? <a href="{{route('register')}}">Регистрация</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection
@push('scripts')
    <script>
        (new SaveTrait({selector: '#login-form', showFailToast:true}))
    </script>
@endpush