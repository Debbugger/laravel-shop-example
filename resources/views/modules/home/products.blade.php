@if($categoriesDay->isNotEmpty())
    <div class="product-tab">
        <h2 class="h2 text-primary py-3 pl-4">@lang('home.product-day')</h2>
        <ul class="nav nav-tabs pl-4" id="myTab" role="tablist">
            @foreach($categoriesDay as $category)
                <li class="nav-item">
                    <a data-id="s{{$category->id}}" class="nav-link @if($loop->first) active @endif" id="home-tab-{{$category->id}}" data-toggle="tab" href="#home{{$category->id}}" role="tab" aria-controls="home{{$category->id}}" aria-selected="true">{{parseMultiLanguageString($category->name ?? null, LaravelLocalization::getCurrentLocale())}}</a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content px-3 " id="myTabContent">
            @foreach($categoriesDay as $category)

                <div class="tab-pane fade show @if ($loop->first) active @endif " id="home{{$category->id}}" role="tabpanel" aria-labelledby="home-tab">
                    <div data-id="s{{$category->id}}" class="swiper-container swiper-product @if ($loop->first) first-swiper @endif s1 py-4">
                        <div class="swiper-wrapper">
                            @foreach($category->products as $product)
                                @if ($product->count>0)
                                    <div class="swiper-slide">
                                        <div class="product-slide w-100 h-100 d-flex flex-column">
                                            <a href="{{route('product',['category'=>$category->slug,'slug'=>$product->slug])}}" class="image px-2 mb-2">
                                                <img src="{{asset($product->image)}}" class="img-fluid" alt="">
                                            </a>
                                            <a href="{{route('product',['category'=>$category->slug,'slug'=>$product->slug])}}" class="name text-grey my-2">
                                                {{parseMultiLanguageString($product->name ?? null, LaravelLocalization::getCurrentLocale())}}
                                            </a>
                                            <div class="d-flex align-items-center justify-content-around mt-auto">
                                                <div class="price text-primary">{{$product->costFront}} грн</div>
                                                <a data-id="{{$product->id}}" data-type="page" class="btn btn-primary btn-sm d-flex  align-items-center card-add-product text-white">@lang('global.buy')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('global.formCard')
@endif
@push('scripts')
    <script src="{{asset('js/swiper.min.js')}}"></script>

    <script src="{{asset('js/card.js')}}"></script>
    <script>
        $(document).ready(function () {
            {{--{{dd($categoriesDay->first()->id)}}--}}
            {{--        initSwiper('#home{{$categoriesDay->first()->id ?? null}} .swiper-product');--}}
            function initSwiper(selector) {
                new Swiper(selector, {
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    preventClicksPropagation: false,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpointsInverse: true,
                    breakpoints: {
                        576: {
                            slidesPerView: 1,
                        },
                        678: {
                            slidesPerView: 2,
                        },
                        991: {
                            slidesPerView: 3,
                        },
                        1200: {
                            slidesPerView: 4,
                        }
                    }
                });
            }

            initSwiper('.first-swiper');
           $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                initSwiper('.swiper-product[data-id="'+$(this).data('id')+'"]');
            });
        });
    </script>
@endpush