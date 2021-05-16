@extends('admin::main')

@section('title', 'Редактирование пользователя')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Редектировать профиль</h4>
                @include('admin.blocks.breadcrumbs')
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Профиль пользователя</h3>
                        </div>
                        <div class="card-body">
                            <form id="edit-user-pass" action="{{route('adminUsersEditPass',$id)}}">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-auto">
                                        <span class="avatar brround avatar-xl" style="background-image: url({{asset('admin-styles/images/avatar.png')}})"></span>
                                    </div>
                                    <div class="col">
                                        <h3 class="mb-1 ">{{$user->name }} </h3>
                                        <p class="mb-4 ">
                                            @foreach ($user->getRoleNames() as $roleName)
                                                {{$roleName}}
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Новый пароль</label>
                                    <input type="password" name="password" autocomplete="password" class="form-control" value="">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-footer">
                                    <button class="btn btn-primary btn-block">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <form class="card" id="edit-user" action="{{route('adminUsersEdit',$id)}}">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Данные пользователя</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Имя пользователя</label>
                                        <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Емайл</label>
                                        <input class="form-control" autocomplete="e-mail" value="{{$user->email}}" name="email">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Номер телефона</label>
                                        <input class="form-control" type="text" value="{{$user->phone}}" name="phone">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Дата рождения:</label>
                                        <input type="text" autocomplete="off" class="datepicker-here form-control " data-date-format="yyyy-mm-dd" name="date" id="date" value="{{$user->date}}" placeholder="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Доступ</label>
                                        <select class="form-control custom-select w-100" name="role">
                                            @foreach ($roles as $role)
                                                <option @if ($user->hasRole($role->name)) selected @endif value="{{$role->name}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            @include('admin.blocks.back',['redirectBack'=>route('adminUsers')])
                            <button class="btn btn-success btn-sm">Обновить профиль</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (new SaveTrait({selector: '#edit-user'}).setAdditionalSuccessCallback(function (callback) {
            $('[name=date]').removeClass('is-invalid');
            $('[name=date]').next().html('');
        }).setAdditionalFailCallback(function (callback) {
            if (callback.errors.date == undefined) {
                $('[name=date]').removeClass('is-invalid');
                $('[name=date]').next().html('');
            }
        }));
        (new SaveTrait({selector: '#edit-user-pass', clearFormOnSuccess: true}))
    </script>
@endpush