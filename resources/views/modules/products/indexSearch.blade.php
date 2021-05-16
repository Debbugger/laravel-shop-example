@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3 mb-md-5">
                <div class="filter-b">
                    <div class="filter-item px-3 py-3">
                        <div class="filter-item-h mb-3">@lang('products.cost')</div>
                        <form id="change-prise" class="d-flex align-items-center justify-content-between" action="{{route('productSearch')}}" method="get">
                            <input type="number" class="price input-el mr-3 mr-md-0 change-prise " value="{{$from ?? null}}" placeholder="@lang('placeholder.cost-from')" name="from" min="1">
                            <input type="number" class="price input-el mr-auto mr-md-0 change-prise" value="{{$to ?? null}}" placeholder="@lang('placeholder.cost-to')" name="to" min="{{$from ?? 1}}">
                            <input name="type" value="{{$type ?? null}}" hidden>
                            <input name="search" value="{{$search ?? null}}" hidden>
                        </form>
                    </div>
                    <div class="filter-item  px-3 py-3">
                        <div class="filter-item-h mb-3">{{parseMultiLanguageString($specification->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</div>
                        <select class="custom-select search-redirect" id="inputGroupSelect01">
                            <option selected data-url="{{route('productSearch',['search'=>$search])}}" value="0">@lang('global.no-choice')</option>
                            @foreach ($categories as $category)
                                <option value="{{'category_'.$category->id}}" data-url="{{route('productCategory',['slug'=>$category->slug,'search'=>$search,'from'=>$from,'to'=>$to])}}">{{parseMultiLanguageString($category->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @if ($products->isNotEmpty())
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="list-product-b mt-5 ">
                        <div class="list-product-h">@lang('products.search')</div>
                        <ul class="nav nav-tabs pl-md-4" id="myTab" role="tablist">
                            <li class="nav-item ml-auto">
                                <a class="nav-link @if ($type==1) active @endif" id="home-tab-1" href="{{$types[1]}}" role="tab" aria-controls="home1" aria-selected="false">@lang('button.new')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($type==2) active @endif" id="home-tab-2" href="{{$types[2]}}" role="tab" aria-controls="home2" aria-selected="false">@lang('button.poor')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($type==3) active @endif" id="home-tab-3" href="{{$types[3]}}" role="tab" aria-controls="home3" aria-selected="true">@lang('button.rich')</a>
                            </li>
                        </ul>
                        <div class="tab-content " id="myTabContent">
                            <div class="tab-pane fade active show" id="home1" role="tabpanel" aria-labelledby="home-tab">
                                <div class="product-list-b d-flex flex-wrap">
                                    @foreach($products as $product)
                                        <div class="product-list-item d-flex flex-column">
                                            <a class="image" href="{{route('product',['category'=>$product->category->slug,'slug'=>$product->slug])}}">
                                                <img src="{{asset($product->image)}}" class="img-fluid" alt="">
                                            </a>
                                            <div class="description mt-auto">
                                                <div class="d-flex align-items-center justify-content-center name mb-2">
                                                    <a class="name text-grey my-2" href="{{route('product',['slug'=>$product->slug,'category'=>$product->category->slug])}}"> {{parseMultiLanguageString($product->name ?? null, LaravelLocalization :: getCurrentLocale ()) }} </a>
                                                </div>
                                                <div class="d-flex align-items-center mt-2 mb-3">
                                                    <div class="price">{{$product->costFront}} грн</div>
                                                    <a data-id="{{$product->id}}" data-type="page" class="checkout-link favorite-add-product  @if(in_array($product->id,$favorites)) active  @endif  ml-auto mr-2" style="cursor: pointer">
                                                        <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M18.4248 1.27834C17.4599 0.480103 16.2208 0.041421 14.9364 0.041421C13.4529 0.041421 12.0169 0.631312 10.9971 1.66164C10.8138 1.84714 10.6419 2.04626 10.4806 2.26252C9.23182 0.600542 7.14522 -0.252205 5.08149 0.124938C3.36896 0.435707 2.02258 1.37681 1.08236 2.9201C-0.244229 5.099 -0.352801 7.20054 0.761485 9.1667C1.35709 10.2186 2.12984 11.2436 3.12412 12.3003C4.94522 14.2361 7.10083 16.0735 9.9083 18.0805C10.0876 18.2093 10.2797 18.2744 10.4802 18.2744C10.7887 18.2744 10.9971 18.1183 11.1004 18.0419C13.6336 16.2331 15.6235 14.5658 17.3632 12.7922C18.3347 11.8023 19.4371 10.5856 20.2432 9.06604C20.5887 8.41681 20.9826 7.54296 20.9593 6.54472C20.9074 4.39659 20.0551 2.62472 18.4248 1.27834ZM18.9237 8.36538C18.2059 9.71659 17.1931 10.8318 16.2964 11.7452C14.6876 13.3856 12.8481 14.9381 10.4775 16.6498C7.89775 14.7834 5.90083 13.0696 4.21291 11.2744C3.3017 10.306 2.59797 9.37549 2.06126 8.42824C1.21159 6.92933 1.3061 5.42516 2.35929 3.69681C3.06786 2.53285 4.07357 1.82516 5.34918 1.59351C5.59357 1.54867 5.84104 1.5267 6.085 1.5267C7.59709 1.5267 8.93643 2.36186 9.69291 3.81197L9.82127 4.05417C9.95313 4.30164 10.2248 4.4423 10.4929 4.44889C10.7738 4.44362 11.0274 4.28318 11.1509 4.03087C11.4164 3.48933 11.7061 3.06911 12.0595 2.71131C12.8006 1.96362 13.849 1.53417 14.9364 1.53417C15.874 1.53417 16.7747 1.85197 17.4731 2.42955C18.7725 3.50252 19.4239 4.86076 19.4657 6.57856C19.4802 7.22692 19.2002 7.84494 18.9237 8.36538Z"
                                                                  fill="#FF0D0D"/>
                                                        </svg>
                                                    </a>
                                                    <a data-id="{{$product->id}}" data-type="page" class="checkout-link card-add-product @if(in_array($product->id,$card)) active  @endif  ">
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
                                                <a href="{{route('product',['category'=>$product->category->slug,'slug'=>$product->slug])}}" class="btn btn-primary w-100">@lang('button.more')</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="debbugger" >
                                    <div> {{$products->appends(['type' => $type,'to'=>$to,'from'=>$from,'search'=>$search])->render()}}</div>
                                </div>
                            </div>
                            @include('global.formCard')
                            @include('global.formFavorite')
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 col-md-8 col-lg-9">
                    <div class=" mt-5">
                        @lang('products.search-empty')
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/card.js')}}"></script>
    <script src="{{asset('js/favorite.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.search-redirect').on('change', function () {
                window.location.href = $('[value="' + $(this).val() + '"]').data('url');
            });
        });
        $('.change-prise').on('change', function () {
            let formPrise = $('#change-prise');
            if ($(this).attr('name') == 'to') {
                if ((formPrise.find('[name=from]').val() != null) && (parseInt(formPrise.find('[name=to]').val()) < parseInt(formPrise.find('[name=from]').val())))
                    $(this).val(formPrise.find('[name=from]').val());
            } else {
                if ((formPrise.find('[name=to]').val() != null) && (parseInt(formPrise.find('[name=to]').val()) < parseInt(formPrise.find('[name=from]').val())))
                    $(this).val(formPrise.find('[name=to]').val());
            }
            formPrise.trigger('submit');
        });

    </script>

@endpush
