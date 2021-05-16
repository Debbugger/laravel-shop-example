@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="h4-title text-grey">@lang('card.title')</div>
                <div class="w-100">
                    <hr>
                </div>
                <div class="favorites-b w-100 d-flex flex-column">
                    @if (!empty($products))
                        @foreach($products as $product)
                            <div class="favorites-b-item py-3 d-flex flex-column flex-md-row justify-content-between">
                                <div class="image"><img src="{{asset($product->category->image)}}" class="img-fluid" alt=""></div>
                                <div class="description text-grey mb-3 ml-md-1 mb-md-0 mr-md-auto pr-md-3">
                                    <p>@lang('products.code') {{$product->id}}</p>
                                    <a href="{{route('product',['category'=>$product->category->slug,'slug'=> $product->slug])}}">{!!  parseMultiLanguageString($product->name ?? null, LaravelLocalization::getCurrentLocale())!!}</a>
                                </div>
                                <div class="d-flex flex-column align-content-between justify-content-between">
                                    <div class="d-flex align-items-center mb-3" data-id="{{$product->id}}">
                                        <a class="plus hover-ico">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 0C4.93387 0 0 4.93387 0 11C0 17.0661 4.93387 22 11 22C17.0661 22 22 17.0661 22 11C22 4.93387 17.0661 0 11 0ZM11 20.5333C5.74347 20.5333 1.46667 16.2565 1.46667 11C1.46667 5.74347 5.74347 1.46667 11 1.46667C16.2565 1.46667 20.5333 5.74347 20.5333 11C20.5333 16.2565 16.2565 20.5333 11 20.5333Z" fill="#868484" fill-opacity="0.81"/>
                                                <path d="M11.7333 5.1333H10.2666V10.2666H5.1333V11.7333H10.2666V16.8666H11.7333V11.7333H16.8666V10.2666H11.7333V5.1333Z" fill="#868484" fill-opacity="0.81"/>
                                            </svg>
                                        </a>
                                        <span class="mx-2 text-grey laravel-count" data-id="{{$product->id}}">{{$counts[$product->id]}}</span>
                                        <a class="minus hover-ico">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.3541 11.55H6.64563C6.34193 11.55 6.09563 11.3037 6.09563 11C6.09563 10.6963 6.34193 10.45 6.64563 10.45H15.3541C15.6577 10.45 15.904 10.6963 15.904 11C15.904 11.3037 15.6577 11.55 15.3541 11.55ZM22 11C22 4.93453 17.0655 0 11 0C4.93453 0 0 4.93453 0 11C0 17.0655 4.93453 22 11 22C17.0655 22 22 17.0655 22 11ZM20.8999 11C20.8999 16.4588 16.4588 20.9 11 20.9C5.54108 20.9 1.1 16.4588 1.1 11C1.1 5.54108 5.54108 1.1 11 1.1C16.4588 1.1 20.8999 5.54108 20.8999 11Z"
                                                      fill="#868484"/>
                                            </svg>
                                        </a>
                                        <div class="prise laravel-prise text-primary ml-4 mr-1  ml-md-auto text-right" data-id="{{$product->id}}">{{$product->costFront*$counts[$product->id]}}</div>
                                        <div> грн</div>
                                    </div>
                                    <div class="d-flex align-items-center ">
                                        <a class="hover-ico  laravel-delete mr-3" data-id="{{$product->id}}">
                                            <svg class="mr-2" width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0)">
                                                    <path d="M14.316 21.3883H6.56791C4.98961 21.3883 3.74609 19.9498 3.74609 18.2449V8.60163C3.74609 8.28196 3.9374 8.06885 4.22437 8.06885C4.51133 8.06885 4.70264 8.28196 4.70264 8.60163V18.2449C4.70264 19.4171 5.56354 20.3228 6.56791 20.3228H14.316C15.3682 20.3228 16.1812 19.3638 16.1812 18.2449V8.60163C16.1812 8.28196 16.3725 8.06885 16.6595 8.06885C16.9465 8.06885 17.1378 8.28196 17.1378 8.60163V18.2449C17.1378 19.9498 15.8464 21.3883 14.316 21.3883Z"
                                                          fill="#868484"/>
                                                    <path d="M16.85 2.68777H13.2151C12.9759 1.19599 11.8281 0.0771484 10.4411 0.0771484C9.0541 0.0771484 7.90624 1.19599 7.6671 2.68777H4.03221C2.93218 2.68777 2.07129 3.64677 2.07129 4.87217C2.07129 6.09756 2.93218 7.00329 4.03221 7.00329H16.8978C17.9978 7.00329 18.8587 6.04428 18.8587 4.81889C18.8587 3.59349 17.95 2.68777 16.85 2.68777ZM10.4411 1.14271C11.302 1.14271 12.0194 1.78204 12.2107 2.68777H8.62365C8.86279 1.78204 9.5802 1.14271 10.4411 1.14271ZM16.85 5.93773H4.03221C3.50611 5.93773 3.02784 5.45822 3.02784 4.81889C3.02784 4.23283 3.45829 3.70005 4.03221 3.70005H16.8978C17.4239 3.70005 17.9022 4.17955 17.9022 4.81889C17.8543 5.45822 17.4239 5.93773 16.85 5.93773Z"
                                                          fill="#868484"/>
                                                    <path d="M7.09351 18.7779C6.80654 18.7779 6.61523 18.5648 6.61523 18.2451V9.34772C6.61523 9.02805 6.80654 8.81494 7.09351 8.81494C7.38047 8.81494 7.57178 9.02805 7.57178 9.34772V18.2451C7.57178 18.5115 7.33265 18.7779 7.09351 18.7779Z" fill="#868484"/>
                                                    <path d="M13.7898 18.7779C13.5028 18.7779 13.3115 18.5648 13.3115 18.2451V9.34772C13.3115 9.02805 13.5028 8.81494 13.7898 8.81494C14.0768 8.81494 14.2681 9.02805 14.2681 9.34772V18.2451C14.2681 18.5115 14.0289 18.7779 13.7898 18.7779Z" fill="#868484"/>
                                                    <path d="M10.4412 18.7779C10.1542 18.7779 9.96289 18.5648 9.96289 18.2451V9.34772C9.96289 9.02805 10.1542 8.81494 10.4412 8.81494C10.7281 8.81494 10.9194 9.02805 10.9194 9.34772V18.2451C10.9194 18.5115 10.6803 18.7779 10.4412 18.7779Z" fill="#868484"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0">
                                                        <rect width="19.131" height="21.3112" fill="white" transform="translate(0.923828 0.0771484)"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            @lang('global.delete')</a>
                                        <a data-id="{{$product->id}}" data-type="page" class="hover-ico favorite-add-product @if(in_array($product->id,$favorites)) active  @endif ">
                                            <svg class="mr-2" width="24" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20.5564 2.27479C19.5192 1.41668 18.1872 0.945101 16.8065 0.945101C15.2117 0.945101 13.6679 1.57923 12.5717 2.68684C12.3746 2.88624 12.1899 3.1003 12.0164 3.33278C10.674 1.54616 8.4309 0.629453 6.21239 1.03488C4.37142 1.36896 2.92407 2.38064 1.91333 4.03968C0.487246 6.382 0.370532 8.64116 1.56839 10.7548C2.20866 11.8855 3.03937 12.9875 4.10822 14.1234C6.06591 16.2044 8.38318 18.1796 11.4012 20.3372C11.594 20.4756 11.8005 20.5455 12.016 20.5455C12.3477 20.5455 12.5717 20.3778 12.6827 20.2956C15.4059 18.3511 17.545 16.5588 19.4153 14.6522C20.4596 13.588 21.6447 12.2801 22.5113 10.6466C22.8827 9.94864 23.3061 9.00926 23.281 7.93615C23.2253 5.6269 22.309 3.72215 20.5564 2.27479ZM21.0927 9.89336C20.3211 11.3459 19.2324 12.5447 18.2685 13.5266C16.539 15.2901 14.5615 16.9591 12.0131 18.7991C9.23987 16.7927 7.09318 14.9503 5.27867 13.0205C4.29912 11.9796 3.54261 10.9792 2.96565 9.96093C2.05226 8.34961 2.15385 6.73262 3.28603 4.87464C4.04774 3.62339 5.12888 2.86262 6.50016 2.6136C6.76288 2.5654 7.02891 2.54177 7.29117 2.54177C8.91666 2.54177 10.3565 3.43957 11.1697 4.99844L11.3077 5.2588C11.4494 5.52484 11.7414 5.67605 12.0297 5.68314C12.3316 5.67746 12.6043 5.50499 12.737 5.23376C13.0225 4.65161 13.3338 4.19987 13.7138 3.81523C14.5104 3.01146 15.6374 2.54981 16.8065 2.54981C17.8144 2.54981 18.7826 2.89144 19.5334 3.51234C20.9302 4.66578 21.6305 6.12589 21.6754 7.97253C21.691 8.66951 21.39 9.33388 21.0927 9.89336Z"
                                                      fill="#868484"/>
                                            </svg>
                                            @lang('global.favorite')</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <form class="form-delete">
                        <input name="id" hidden>
                    </form>
                    @if (!empty($products))
                        @if (!empty($currentUser->id))
                            <div class="d-flex align-items-center justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary laravel-order-register">@lang('button.order-create')</button>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center mt-3">
                                <a href="{{route('cardProcess')}}" class="btn btn-primary">@lang('button.order-create')</a>
                            </div>
                        @endif
                    @endif
                </div>

                @if (!empty($products))
                    <div class="mt-5 w-100">
                        <hr>
                    </div>
                @endif
                <form id="register" action="{{route('orderRegister')}}">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="user" @if (!empty($currentUser->id))   value="{{$currentUser->id}}" @endif>
                    <input type="hidden" name="count" value="">
                </form>
                @include('global.formFavorite')
                <form id="plus">
                    <input name="id" hidden>
                    <input name="count" value="1" hidden>
                </form>
                <form id="minus">
                    <input name="id" hidden>
                    <input name="count" value="-1" hidden>
                </form>
            </div>
        </div>

        <div class="row mb-5">
            @if (empty($products))
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <p class="h5">@lang('card.products-empty')</p>
                        <div class="d-flex align-items-center justify-content-center mt-4 mb-5">
                            <a href="{{route('register')}}" class="btn btn-primary empty-card-btn d-flex  align-items-center card-add-product text-white">@lang('button.card-register')</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 empty-card-item mx-auto text-center text-sm-left mb-4 mb-md-0">
                <div class="d-flex align-items-center justify-content-center image mb-3">
                    <img src="{{asset('img/mbridelivery_99588.png')}}" alt="">
                </div>
                @lang('card.delivery')
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 empty-card-item mx-auto text-center text-sm-left mb-4 mb-md-0">
                <div class="d-flex align-items-center justify-content-center image mb-3">
                    <img src="{{asset('img/4124813-badge-insignia-premium-badge-quality-star-badge_113911.png')}}" alt="">
                </div>
                @lang('card.quality')
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 empty-card-item mx-auto text-center text-sm-left mb-4 mb-md-0">
                <div class="d-flex align-items-center justify-content-center image mb-3">
                    <img src="{{asset('img/Cash-dollar_icon-icons.com_52202.png')}}" alt="">
                </div>
                @lang('card.cash')
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                let id = 0;
                let count = 0;
                let favoriteAdd = $('#favorites-add-product');
                $('.laravel-order-register').off().on('click', function () {
                    $('#register').trigger('submit')
                });
                (new SaveTrait({selector: '#register', showFailToast: true}));

                $('.minus').click(function () {
                    $('[name=id]').val($(this).parent().data('id'));
                    $('#minus').trigger('submit');
                });
                $('.plus').click(function () {
                    $('[name=id]').val($(this).parent().data('id'));
                    $('#plus').trigger('submit');
                });
                $('.laravel-delete').click(function () {
                    $('.form-delete').find('[name=id]').val($(this).data('id'));
                    $(this).parent().parent().parent().remove();
                    $('.form-delete').trigger('submit');
                });
                (new SaveTrait({selector: '#plus', selectorType: 'submit', actionUrl: '{{route('cardAdd')}}', showSuccessToast: false, showFailToast: true}).setAdditionalSuccessCallback(function (callback) {
                    $('.laravel-count[data-id="' + callback.id + '"]').html(callback.count);
                    $('.laravel-prise[data-id="' + callback.id + '"]').html(callback.count * callback.cost);
                }).setAdditionalFailCallback(function (callback) {
                    if (callback.count <= 0)
                        $('.laravel-delete[data-id="' + callback.id + '"]').trigger('click');
                    $('.laravel-count[data-id="' + callback.id + '"]').html(callback.count);
                    $('.laravel-prise[data-id="' + callback.id + '"]').html(callback.count * callback.cost);
                }));
                (new SaveTrait({selector: '#minus', selectorType: 'submit', actionUrl: '{{route('cardMinus')}}', showSuccessToast: false, showFailToast: true}).setAdditionalSuccessCallback(function (callback) {
                    $('.laravel-count[data-id="' + callback.id + '"]').html(callback.count);
                    $('.laravel-prise[data-id="' + callback.id + '"]').html(callback.count * callback.cost);
                }));
                (new SaveTrait({selector: '.form-delete', actionUrl: '{{route('cardDelete')}}', showSuccessToast: false}));
            });
        </script>
        <script src="{{asset('js/favorite.js')}}"></script>
    @endpush
@endsection
