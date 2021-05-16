<div class="col-12">
    @if($advansed->isNotEmpty())
        <div class=" reasons-b d-flex flex-wrap ">
            @foreach($advansed as $advanse)
                <div class="reasons-b-item">
                        <div class="reasons-b-ico">
                            <img src="{{asset($advanse->image)}}" class="img-fluid" alt="">
                        </div>
                    <div class="reasons-t">{{parseMultiLanguageString($advanse->description ?? null, LaravelLocalization::getCurrentLocale())}}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>