<div class="footer mt-auto">
    <div class="container">
        <div class="row">
            <div class="order-0 order-md-0 col-12 col-sm-4 col-md-3 col-lg-2 ">
                <div class="footer-menu ml-lg-5 d-flex flex-column  ">
                    <a href="{{route('home')}}">@lang('header.home')</a>
                    <a href="{{route('about')}}">@lang('header.about')</a>
                    <a href="{{route('discounts')}}">@lang('header.discounts')</a>
                    <a href="{{route('articles')}}">@lang('header.articles')</a>
                    @if(Auth()->user())
                        <a href="{{route('userHome')}}">@lang('header.profile')</a>
                    @else
                        <a href="{{route('login')}}">@lang('global.entry')</a>
                    @endif
                </div>
            </div>
            <div class="order-2 order-md-1 col-12 col-sm-4 col-md-4 col-lg-3 mx-auto">
                <div class="footer-partners">
                    @if ($partners->isNotEmpty())
                        <div class="text-white text-center mb-2">@lang('footer.partners')</div>
                        <div class="d-flex flex-wrap footer-partners-b">
                            @foreach($partners as $partner)
                                <a href="{{$partner->slug}}" class="footer-partners-item text-center">
                                    <img src="{{asset($partner->image)}}" class="img-fluid" alt="">
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <div class="text-center text-white">{{ date('Y') }} © Bazar.net.ua <br> <span style="font-size: 10px;">Developed by <a href="//svv.team" target="_blank">SVV.team</a></span></div>
                </div>
            </div>
            <div class="order-1 order-md-2 col-12 col-sm-4 col-md-3 col-lg-3  ">
                <div class="footer-info">
                    <div class="footer-info-item">
                        <span>@lang('footer.graph-work') :</span>
                        <span>@lang('footer.graph-work-value')</span>
                    </div>
                    <div class="footer-info-item">
                        <span>@lang('footer.weekend') :</span>
                        <span>@lang('footer.weekend-value')</span>
                    </div>
                    <div class="footer-info-item">
                        <span>@lang('footer.hot-line') :</span>
                        <span><a href="tel:@lang('global.phone')">@lang('global.phone')</a></span>
                    </div>
                    <div class="footer-info-item">
                        <span>@lang('footer.address')</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

