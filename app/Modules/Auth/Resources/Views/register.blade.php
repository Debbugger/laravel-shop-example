@extends('auth::layouts.head')

@section('title', 'Регистрация')
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
                    <form class="card" method="post" id="register-form" action="{{route('register')}}">
                        @csrf
                        <div class="card-body p-6">
                            <div class="card-title text-center">Создание нового аккаунта</div>
                            <div class="form-group">
                                <label class="form-label">Имя</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter name">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">Зарегистрироватся</button>
                            </div>
                            <div class="text-center text-muted mt-4">
                                Есть аккаунт? <a href="{{route('login')}}">Авторизация</a>
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
        (new SaveTrait({selector: '#register-form', showFailToast:true}))
    </script>
@endpush
