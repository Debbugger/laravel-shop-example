<div class="vobilet-navbar fixed-heade" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ (request()->route()->getName()=='adminHome') ? 'active' : null }}" href="{{route('adminHome')}}">
                    <i class="fa fa-home"></i>
                    <span> Главная</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*users*') ? 'active' : null }}" href="{{route('adminUsers')}}">
                    <i class="fas fa-user"></i>
                    <span> Пользователи</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*management*') ? 'active' : null }}" href="{{route('adminManagement')}}">
                    <i class="fa fa-shopping-cart"></i>
                    <span> Управление товарами</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*'.substr(config('app.admin_url'),1).'/discount*') ? 'active' : null }}" href="{{route('adminDiscount')}}">
                    <i class="fas fa-percent"></i>
                    <span>Акции</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*orders*') ? 'active' : null }}" href="{{route('adminOrders')}}">
                    <i class="fas fa-address-card"></i>
                    <span>Заказы</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*news*') ? 'active' : null }}" href="{{route('adminNews')}}">
                    <i class="fa fa-newspaper-o"></i>
                    <span>Новости</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*settings*') ? 'active' : null }}" href="{{route('adminSettings')}}">
                    <i class="fas fa-cogs"></i>
                    <span> Настройки</span>
                </a>
            </li>
        </ul>
    </div>
</div>
