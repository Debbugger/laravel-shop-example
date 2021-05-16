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
                <div class="h4-title text-grey">@lang('profile.favorites-header')</div>
                <div class="w-100">
                    <hr>
                </div>
                <div class="favorites-b w-100 d-flex flex-column">
                    @if ($favorites->isNotEmpty())
                        @foreach($favorites as $val)

                            <div class="favorites-b-item py-3 d-flex flex-column flex-md-row justify-content-between">
                                <div class="image"><img src="{{asset($val->product->category->image)}}" class="img-fluid" alt=""></div>
                                <div class="description text-grey mb-3 ml-md-1 mb-md-0 mr-md-auto pr-md-3">
                                    <p>@lang('products.code') {{$val->id}}</p>
                                    <a href="{{route('product',['category'=>$val->product->category->slug,'slug'=> $val->product->slug])}}">{!!  parseMultiLanguageString($val->product->name ?? null )!!}</a>
                                </div>
                                <div class="d-flex flex-column align-content-between justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <a class="favorite-add plus hover-ico" data-id="{{$val->product->id}}">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 0C4.93387 0 0 4.93387 0 11C0 17.0661 4.93387 22 11 22C17.0661 22 22 17.0661 22 11C22 4.93387 17.0661 0 11 0ZM11 20.5333C5.74347 20.5333 1.46667 16.2565 1.46667 11C1.46667 5.74347 5.74347 1.46667 11 1.46667C16.2565 1.46667 20.5333 5.74347 20.5333 11C20.5333 16.2565 16.2565 20.5333 11 20.5333Z" fill="#868484" fill-opacity="0.81"/>
                                                <path d="M11.7333 5.1333H10.2666V10.2666H5.1333V11.7333H10.2666V16.8666H11.7333V11.7333H16.8666V10.2666H11.7333V5.1333Z" fill="#868484" fill-opacity="0.81"/>
                                            </svg>
                                        </a>
                                        <span class="mx-2 text-grey favorite-count" data-id="{{$val->product->id}}">{{$val->count}}</span>
                                        <a class="favorite-minus minus hover-ico" data-id="{{$val->product->id}}">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.3541 11.55H6.64563C6.34193 11.55 6.09563 11.3037 6.09563 11C6.09563 10.6963 6.34193 10.45 6.64563 10.45H15.3541C15.6577 10.45 15.904 10.6963 15.904 11C15.904 11.3037 15.6577 11.55 15.3541 11.55ZM22 11C22 4.93453 17.0655 0 11 0C4.93453 0 0 4.93453 0 11C0 17.0655 4.93453 22 11 22C17.0655 22 22 17.0655 22 11ZM20.8999 11C20.8999 16.4588 16.4588 20.9 11 20.9C5.54108 20.9 1.1 16.4588 1.1 11C1.1 5.54108 5.54108 1.1 11 1.1C16.4588 1.1 20.8999 5.54108 20.8999 11Z"
                                                      fill="#868484"/>
                                            </svg>
                                        </a>
                                        <div class="prise favorite-prise text-primary ml-4 mr-1 ml-md-auto text-right" data-cost="{{$val->product->costFront}}" data-id="{{$val->product->id}}">{{$val->product->costFront*$val->count}}</div>
                                        <div> грн</div>
                                    </div>
                                    <div class="d-flex align-items-center ">
                                        <a class="hover-ico mr-4 send-card @if(in_array($val->product->id,$card)) active  @endif" data-id="{{$val->id}}">
                                            <svg class="mr-2" width="27" height="25" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0)">
                                                    <path d="M23.6251 18.7498H9.57312L3.66673 6.25001H0.00012207V4.6875H4.77096L10.6771 17.1875H23.6251V18.7498Z" fill="white"></path>
                                                    <path d="M15.1877 22.6563C15.1877 23.95 14.0535 24.9999 12.6563 24.9999C11.2581 24.9999 10.1251 23.95 10.1251 22.6563C10.1251 21.3621 11.2581 20.3125 12.6563 20.3125C14.0535 20.3125 15.1877 21.3621 15.1877 22.6563Z" fill="white"></path>
                                                    <path d="M23.6251 22.6563C23.6251 23.95 22.4913 24.9999 21.0941 24.9999C19.6964 24.9999 18.5627 23.95 18.5627 22.6563C18.5627 21.3621 19.6964 20.3125 21.0941 20.3125C22.4913 20.3125 23.6251 21.3621 23.6251 22.6563Z" fill="white"></path>
                                                    <path d="M21.0941 12.5C17.798 12.5 15.0145 10.5347 13.9666 7.8125H8.43762L11.8128 15.625H23.6252L25.5732 11.1176C24.3142 11.9752 22.7734 12.5 21.0941 12.5Z" fill="white"></path>
                                                    <path d="M21.0941 0C17.8327 0 15.1876 2.44903 15.1876 5.4688C15.1876 8.4884 17.8327 10.9376 21.0941 10.9376C24.3551 10.9376 27 8.48845 27 5.4688C27 2.44903 24.3552 0 21.0941 0ZM20.1992 8.23053L19.0059 7.12596L17.2162 5.4688L18.4096 4.36407L20.1992 6.02113L23.7786 2.70706L24.9715 3.81174L20.1992 8.23053Z" fill="white"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0">
                                                        <rect width="27" height="25" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            @lang('global.buy')</a>
                                        <a class="hover-ico favorite-delete" data-id="{{$val->product->id}}">
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
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @lang('global.products-empty')
                    @endif
                </div>
                <form action="{{route('favoriteAdd')}}" id="form-favorite">
                    <input name="id" hidden>
                    <input name="count" hidden>
                </form>
                <form id="form-send-card" action="{{route('favoriteSend')}}">
                    <input name="id" hidden>
                </form>
                <form action="{{route('favoriteDelete')}}" id="form-delete">
                    <input name="id" hidden>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let id = 0;
            let formFavorite = $('#form-favorite');
            let formDelete = $('#form-delete');
            let formSendCard = $('#form-send-card');
            $('.favorite-add').off().on('click', function () {
                id = $(this).data('id');
                formFavorite.find('[name=id]').val($(this).data('id'));
                formFavorite.find('[name=count]').val(1);
                formFavorite.trigger('submit');
            });
            $('.favorite-minus').off().on('click', function () {
                id = $(this).data('id');
                formFavorite.find('[name=id]').val($(this).data('id'));
                formFavorite.find('[name=count]').val(-1);
                formFavorite.trigger('submit');
            });
            $('.favorite-delete').on('click', function () {
                $('.favorite-count[data-id="' + $(this).data('id') + '"]').parent().parent().parent().remove();
                formDelete.find('[name=id]').val($(this).data('id'));
                formDelete.trigger('submit');

            });
            $('.send-card').on('click', function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).addClass('active');
                }
                formSendCard.find('[name=id]').val($(this).data('id'));
                formSendCard.trigger('submit');
            });
            (new SaveTrait({selector: '#form-favorite', showFailToast: true, showSuccessToast: false}).setAdditionalSuccessCallback(function (callback) {
                $('.favorite-count[data-id="' + id + '"]').text(callback.count);
                $('.favorite-prise[data-id="' + id + '"]').text(callback.count * $('.favorite-prise[data-id="' + id + '"]').data('cost'));
            }).setAdditionalFailCallback(function (callback) {
                if (callback.delete == 1)
                    $('.favorite-count[data-id="' + id + '"]').parent().parent().parent().remove();
            }));
            (new SaveTrait({selector: '#form-delete', showFailToast: true, showSuccessToast: false}));
            (new SaveTrait({selector: '#form-send-card', showFailToast: true, showSuccessToast: true}).setAdditionalSuccessCallback(function (callback) {

            }));

        });

    </script>
@endpush
