@if($sliders->isNotEmpty())
    <div class="col-12 col-md-8 col-lg-9">
        <div class="swiper-container swiper-discount">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <div class="swiper-slide" style="background: url('{{asset($slider->image)}}')">
                        <div class="description-b">
                            <div class="description mb-4">{{parseMultiLanguageString($slider->description ?? null, LaravelLocalization :: getCurrentLocale ()) }}</div>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{parseMultiLanguageString($slider->slug ?? null, LaravelLocalization :: getCurrentLocale ()) }}" class="show-more">@lang('button.more')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
@endif