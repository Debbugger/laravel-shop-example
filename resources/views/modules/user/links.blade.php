<div class="cab-menu">
    <h2 class="cab-menu-h mb-4">@lang('profile.header-menu')</h2>
    <div class="d-flex align-items-start flex-wrap flex-lg-nowrap flex-md-column">
        <a href="{{route('userHome')}}" class="mr-4 mr-md-0 {{ request()->is('cabinet') ? 'active' : null }}">@lang('profile.home')</a>
        <a href="{{route('userFavorites')}}" class="mr-4 mr-md-0 {{ request()->is('cabinet/favorites') ? 'active' : null }}">@lang('profile.favorites')</a>
        <a href="{{route('userData')}}" class="mr-4 mr-md-0 {{ request()->is('cabinet/profile') ? 'active' : null }}">@lang('profile.data')</a>
        <a href="{{route('userPass')}}" class="mr-4 mr-md-0 {{ request()->is('cabinet/security') ? 'active' : null }}">@lang('profile.pass')</a>
        <a href="{{route('logout')}}" class="mr-4 mr-md-0">@lang('profile.logout')</a>
    </div>
</div>