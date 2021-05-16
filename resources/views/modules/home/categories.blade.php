<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
    @if($categories->isNotEmpty())
        <div class="sidebar-menu">
            <div class="sidebar-menu-scroll">
                @foreach( $categories as $category)
                    <a href="{{route('productCategory',$category->slug)}}">
                        @if(mb_strpos($category->image, '.svg') === false)
                            <img src="{{ asset($category->image) }}" class="img-fluid">
                        @else
                            {!! file_get_contents(public_path($category->image)) !!}
                        @endif
                        <span>{{parseMultiLanguageString($category->name ?? null, LaravelLocalization::getCurrentLocale())}}</span>
                    </a>
                @endforeach
                @if(count($categories) > 10)
                    <div class="show-more">@lang('global.show-more')</div>
                @endif
            </div>
        </div>
    @endif
</div>