<div class="header py-4">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="{{route('adminHome')}}" style="padding: 10px; background: #0061da;">
                <img src="{{asset('img/logo.png')}}" class="img-fluid" alt="">
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span class="avatar avatar-md brround" style="background-image: url({{asset('admin-styles/images/avatar.png')}}"></span>
                        <span class="ml-2 d-none d-lg-block">
                            <span class="text-dark">{{$currentUser->name}}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" href="{{route('adminUsersEdit',$currentUser->id)}}">
                            <i class="dropdown-icon mdi mdi-account-outline "></i> Профиль
                        </a>
                        <a class="dropdown-item" href="{{route('logout')}}">
                            <i class="dropdown-icon mdi  mdi-logout-variant"></i> Выйти
                        </a>
                    </div>
                </div>
            </div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>