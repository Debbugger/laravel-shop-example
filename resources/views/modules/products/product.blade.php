@extends('layouts.app')

@section('title', parseMultiLanguageString($category->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($category->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($category->meta_description ?? ''))

@section('content')
    <div class="container">
        <div class="row mb-4 mt-5">
            <div class="col-12">
                <h1 class="h2-title text-grey">{{parseMultiLanguageString($product->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</h1>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-8">
                <div class="product-slider-b mb-5 d-flex align-items-center">
                    @if ($product->images->isNotEmpty())
                        <div class='thumbs d-none d-lg-block'>
                            <div class="swiper-container gallery-thumbs ">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" style="background-image:url({{asset($product->image)}})"></div>
                                    @foreach($product->images as $image)
                                        <div class="swiper-slide" style="background-image:url({{asset($image->path)}})"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="gallery gallery-border  @if (!$product->images->isNotEmpty()) ml-0  @endif  @if($product->images->count() < 1) w-100 @endif">
                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                                <a data-fancybox="gallery" class="swiper-slide" href="{{asset($product->image)}}" style="background-image:url({{asset($product->image)}})"></a>
                                @foreach($product->images as $image)
                                    <a data-fancybox="gallery" class="swiper-slide" href="{{asset($image->path)}}" style="background-image:url({{asset($image->path)}})"></a>
                                @endforeach
                            </div>
                            @if($product->images->count() > 1)
                                <div class="swiper-button-next swiper-button-white"></div>
                                <div class="swiper-button-prev swiper-button-white"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="characteristics-b">
                    <div class="h3-title mb-5">@lang('products.specifications') :</div>
                    <div class="row">
                        @foreach($specifications as $spec)
                            <div class="col-12 col-sm-6 mb-3">
                                <div class="name">{{parseMultiLanguageString($spec->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}:</div>
                                @if (!in_array($spec->id,$noEmpty))
                                    <div class="param">@lang('products.no-value')</div>
                                @endif
                                @foreach ($spec->values as $val)
                                    @if (in_array($val->id,$selected))
                                        <div class="param">{{parseMultiLanguageString($val->value ?? null, LaravelLocalization :: getCurrentLocale ())}}</div> @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12 col-md-4">
                <div class="buy-now">
                    <div class="d-flex align-items-center">
                        @lang('products.cost') : &nbsp;
                        <div class="text-primary">@if ($product->costTo==0) {{$product->cost}} @else от {{$product->cost}} до {{$product->costTo}}@endif грн</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center my-3">
                        <a data-id="{{$product->id}}" data-type="page" class="btn btn-primary w-100 card-add-product  text-white">КУПИТЬ</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-end">
                        <a data-id="{{$product->id}}" data-type="page"  class="hover-ico @if(in_array($product->id,$favorites)) active  @endif favorite-add-product ">
                            <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.8716 1.61825C16.0274 0.919785 14.9432 0.535938 13.8193 0.535938C12.5212 0.535938 11.2647 1.05209 10.3724 1.95363C10.212 2.11594 10.0616 2.29017 9.92047 2.4794C8.82778 1.02517 7.00201 0.279015 5.19624 0.609015C3.69778 0.880938 2.5197 1.7044 1.69701 3.05479C0.536238 4.96132 0.441238 6.80017 1.41624 8.52055C1.93739 9.44094 2.61355 10.3379 3.48355 11.2625C5.07701 12.9563 6.96316 14.564 9.4197 16.3202C9.57662 16.4329 9.7447 16.4898 9.92008 16.4898C10.1901 16.4898 10.3724 16.3532 10.4628 16.2863C12.6793 14.7036 14.4205 13.2448 15.9428 11.6929C16.7928 10.8267 17.7574 9.76209 18.4628 8.43248C18.7651 7.8644 19.1097 7.09978 19.0893 6.22632C19.0439 4.34671 18.2982 2.79632 16.8716 1.61825ZM17.3082 7.8194C16.6801 9.00171 15.7939 9.97748 15.0093 10.7767C13.6016 12.2121 11.992 13.5706 9.91778 15.0682C7.66047 13.4352 5.91316 11.9356 4.43624 10.3648C3.63893 9.51748 3.02316 8.70325 2.55355 7.8744C1.81008 6.56286 1.89278 5.24671 2.81432 3.7344C3.43432 2.71594 4.31431 2.09671 5.43047 1.89402C5.64431 1.85478 5.86085 1.83555 6.07431 1.83555C7.39739 1.83555 8.56931 2.56632 9.23124 3.83517L9.34355 4.04709C9.45893 4.26363 9.69662 4.38671 9.93124 4.39248C10.177 4.38786 10.3989 4.24748 10.507 4.02671C10.7393 3.55286 10.9928 3.18517 11.302 2.87209C11.9505 2.21786 12.8678 1.84209 13.8193 1.84209C14.6397 1.84209 15.4278 2.12017 16.0389 2.62555C17.1759 3.5644 17.7459 4.75286 17.7824 6.25594C17.7951 6.82325 17.5501 7.36402 17.3082 7.8194Z"
                                      fill="#868484"/>
                            </svg>
                            <span class="ml-2">@lang('products.favorite')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if (parseMultiLanguageString($product->description ?? null, LaravelLocalization :: getCurrentLocale ())!=null)
            <div class="row mb-4">
                <div class="col-12 col-md-9 mb-2">
                    <h1 class="h2-title text-grey">@lang('products.description')</h1>
                    <div class="d-flex align-items-center justify-content-center justify-content-md-between flex-wrap">
                        {!!  parseMultiLanguageString($product->description ?? null, LaravelLocalization :: getCurrentLocale ()) !!}
                    </div>
                </div>
            </div>
        @endif


        @if ($likeProducts->isNotEmpty())
            <div class="row mb-4">
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <div class="similar-product">
                        <h1 class="h2-title text-grey">@lang('products.like')</h1>
                        <div class="product-list-b d-flex flex-wrap">
                            @foreach ($likeProducts as $similarProduct)
                                <div class="product-list-item">
                                    <a href="{{route('product',['slug'=>$similarProduct->slug,'category'=>$similarProduct->category->slug])}}" class="image">
                                        <img src="{{asset($similarProduct->image)}}" class="img-fluid" alt="">
                                    </a>
                                    <div class="description mt-auto">
                                        <div class="d-flex align-items-center justify-content-center name mb-2">
                                            <a class="name text-grey my-2" href="{{route('product',['slug'=>$similarProduct->slug,'category'=>$similarProduct->category->slug])}}"> {{parseMultiLanguageString($similarProduct->name ?? null, LaravelLocalization :: getCurrentLocale ()) }} </a>
                                        </div>
                                        <div class="d-flex align-items-center mt-2 mb-3">
                                            <div class="price">{{$similarProduct->costFront ?? null}} грн</div>
                                            <a data-id="{{$similarProduct->id}}" data-type="page" class="favorite-link favorite-add-product @if(in_array($similarProduct->id,$favorites)) active  @endif  ml-auto mr-2">
                                                <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.4248 1.27834C17.4599 0.480103 16.2208 0.041421 14.9364 0.041421C13.4529 0.041421 12.0169 0.631312 10.9971 1.66164C10.8138 1.84714 10.6419 2.04626 10.4806 2.26252C9.23182 0.600542 7.14522 -0.252205 5.08149 0.124938C3.36896 0.435707 2.02258 1.37681 1.08236 2.9201C-0.244229 5.099 -0.352801 7.20054 0.761485 9.1667C1.35709 10.2186 2.12984 11.2436 3.12412 12.3003C4.94522 14.2361 7.10083 16.0735 9.9083 18.0805C10.0876 18.2093 10.2797 18.2744 10.4802 18.2744C10.7887 18.2744 10.9971 18.1183 11.1004 18.0419C13.6336 16.2331 15.6235 14.5658 17.3632 12.7922C18.3347 11.8023 19.4371 10.5856 20.2432 9.06604C20.5887 8.41681 20.9826 7.54296 20.9593 6.54472C20.9074 4.39659 20.0551 2.62472 18.4248 1.27834ZM18.9237 8.36538C18.2059 9.71659 17.1931 10.8318 16.2964 11.7452C14.6876 13.3856 12.8481 14.9381 10.4775 16.6498C7.89775 14.7834 5.90083 13.0696 4.21291 11.2744C3.3017 10.306 2.59797 9.37549 2.06126 8.42824C1.21159 6.92933 1.3061 5.42516 2.35929 3.69681C3.06786 2.53285 4.07357 1.82516 5.34918 1.59351C5.59357 1.54867 5.84104 1.5267 6.085 1.5267C7.59709 1.5267 8.93643 2.36186 9.69291 3.81197L9.82127 4.05417C9.95313 4.30164 10.2248 4.4423 10.4929 4.44889C10.7738 4.44362 11.0274 4.28318 11.1509 4.03087C11.4164 3.48933 11.7061 3.06911 12.0595 2.71131C12.8006 1.96362 13.849 1.53417 14.9364 1.53417C15.874 1.53417 16.7747 1.85197 17.4731 2.42955C18.7725 3.50252 19.4239 4.86076 19.4657 6.57856C19.4802 7.22692 19.2002 7.84494 18.9237 8.36538Z"
                                                          fill="#FF0D0D"/>
                                                </svg>
                                            </a>
                                            <a data-id="{{$similarProduct->id}}" data-type="page" class="checkout-link card-add-product @if(in_array($similarProduct->id,$card)) active @endif ">
                                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0)">
                                                        <path d="M21.876 18.7498H8.86487L3.39598 6.25001H0.000976562V4.6875H4.41842L9.8871 17.1875H21.876V18.7498Z" fill="#919090"/>
                                                        <path d="M14.0625 22.6563C14.0625 23.95 13.0124 24.9999 11.7187 24.9999C10.4241 24.9999 9.375 23.95 9.375 22.6563C9.375 21.3621 10.424 20.3125 11.7187 20.3125C13.0124 20.3125 14.0625 21.3621 14.0625 22.6563Z" fill="#919090"/>
                                                        <path d="M21.8749 22.6563C21.8749 23.95 20.825 24.9999 19.5313 24.9999C18.2371 24.9999 17.1875 23.95 17.1875 22.6563C17.1875 21.3621 18.2371 20.3125 19.5313 20.3125C20.8251 20.3125 21.8749 21.3621 21.8749 22.6563Z" fill="#919090"/>
                                                        <path d="M19.5315 12.5C16.4795 12.5 13.9022 10.5347 12.9319 7.8125H7.8125L10.9376 15.625H21.875L23.6788 11.1176C22.513 11.9752 21.0864 12.5 19.5315 12.5Z" fill="#919090"/>
                                                        <path d="M19.5314 0C16.5117 0 14.0625 2.44903 14.0625 5.4688C14.0625 8.4884 16.5116 10.9376 19.5314 10.9376C22.5509 10.9376 24.9999 8.48845 24.9999 5.4688C24.9999 2.44903 22.551 0 19.5314 0ZM18.7028 8.23053L17.5979 7.12596L15.9408 5.4688L17.0458 4.36407L18.7028 6.02113L22.0171 2.70706L23.1216 3.81174L18.7028 8.23053Z" fill="#919090"/>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0">
                                                            <rect width="25" height="25" fill="white"/>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </a>
                                        </div>
                                        <a href="{{route('product',['slug'=>$similarProduct->slug,'category'=>$similarProduct->category->slug])}}" class="btn btn-primary w-100">ПОДРОБНЕЙ</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('global.formCard')
    @include('global.formFavorite')
@endsection
@push('styles')
    <link rel="stylesheet" href="{{asset('css/swiper.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
@endpush

@push('scripts')
    <script src="{{asset('js/swiper.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function () {
                    @if($product->images->count() > 1)
            var galleryThumbs = new Swiper('.gallery-thumbs', {
                    spaceBetween: 10,
                    centeredSlides: true,
                    slideToClickedSlide: true,
                    direction: 'vertical',
                    slidesPerView: 'auto',
                });
                    @endif

            var galleryTop = new Swiper('.gallery-top', {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                        @if($product->images->count() > 1)
                        thumbs: {
                            swiper: galleryThumbs
                        },
                        @endif

                        on: {
                            slideChange: function () {
                                let activeIndex = this.activeIndex + 1;

                                let activeSlide = document.querySelector(`.gallery-thumbs .swiper-slide:nth-child(${activeIndex})`);
                                let nextSlide = document.querySelector(`.gallery-thumbs .swiper-slide:nth-child(${activeIndex + 1})`);
                                let prevSlide = document.querySelector(`.gallery-thumbs .swiper-slide:nth-child(${activeIndex - 1})`);

                                if (nextSlide && !nextSlide.classList.contains('swiper-slide-visible')) {
                                    this.thumbs.swiper.slideNext()
                                } else if (prevSlide && !prevSlide.classList.contains('swiper-slide-visible')) {
                                    this.thumbs.swiper.slidePrev()
                                }

                            }
                        }
                });
        });

    </script>
    <script src="{{asset('js/card.js')}}"></script>
    <script src="{{asset('js/favorite.js')}}"></script>
@endpush