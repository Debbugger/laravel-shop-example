@extends('admin::main')

@section('title', 'Редактирование страницы')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Редактирование: {{parseMultiLanguageString($item->title)}}</h4>
                {{ Breadcrumbs::render('adminNewsEditPage', $item) }}
            </div>
            <div class="row">
                <div class="col-8">
                    <form method="post" action="{{ route('adminNewsEditPage', $item->id) }}" class="card">
                        @csrf
                        <div class="card-header">
                            <div class="card-title">{{parseMultiLanguageString($item->title)}} </div>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-label">Главная картинка</div>
                                    <div class="hover-img" data-type="edit" data-id="0">
                                        <img class="edit-img" src="{{asset($item->image)}}" data-type="edit"><label class="uploadbutton loader-file ">
                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <input type="file" name="image" data-type="edit" data-id="0" hidden/>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Адрес:</label>
                                    <input type="text" class="form-control" name="slug" value="{{ $item->slug ?? null }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label">Изображения:</div>
                                    <div class="custom-file">
                                        <label class="custom-file-label">Виберите изображения</label>
                                        <img class="preload-news d-none" src="{{asset("admin-styles/images/loader.gif")}}" >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <label class="custom-control custom-checkbox mt-2 ml-1">
                                            <input type="checkbox" class="custom-control-input" name="status" @if($item->status) checked @endif value="1">
                                            <span class="custom-control-label">Показать на сайте?</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 tabs-menu1">
                                <ul class="nav panel-tabs" role="tablist">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li class="nav-item"><a class="nav-link @if($loop->first)active @endif" data-toggle="tab" href="#{{ $localeCode }}" role="tab">{{ $properties['native'] }}</a></li>
                                    @endforeach
                                </ul>
                                <div class="tab-content mt-3 border">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <div class="tab-pane @if($loop->first)active @endif" id="{{ $localeCode }}" role="tabpanel">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Заголовок:</label>
                                                    <input type="text" class="form-control" name="title[]" value="{{parseMultiLanguageString($item->title, $localeCode)}}">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Короткое описание:</label>
                                                    <textarea class="form-control ckeditor" id="ckeditor_short-{{ $localeCode }}" name="short_text[]" rows="12">{!!  parseMultiLanguageString($item->short_text, $localeCode)!!}</textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Описание:</label>
                                                    <textarea class="form-control ckeditor" id="ckeditor-{{ $localeCode }}" name="full_text[]" rows="12">{!! parseMultiLanguageString($item->full_text, $localeCode)!!}</textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @include('admin.blocks.back',['redirectBack'=>route('adminNews')])
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-light float-right">Сохранить</button>
                        </div>
                    </form>
                    <form id="send-images" action="{{ route('adminNewsEditPageImage', $item->id) }}" enctype="multipart/form-data">
                        <input type="file" class="custom-file-input multiple-images" name="images[]" id="addImages" multiple hidden>
                    </form>
                </div>
                <div class="col-4" id="images-block">
                    @include('adminNews::images', ['item' => $item])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <script>
        $('.custom-file').on('click', function () {
            $('#addImages').trigger('click');
        });
        $('#addImages').on('change', function () {
            $('.preload-news').removeClass('d-none');
            $('#send-images').trigger('submit');
        });


        let deleteImage = new SaveTrait({selector: '.delete-item', selectorType: 'click', actionUrl: '{{route('adminNewsPageDeleteImage')}}'}).setAdditionalData(function (data, target) {
            data.append('id', $(target).data('id'));
            data.append('img', $(target).data('img'));
            return data;
        }).setAdditionalSuccessCallback(function (response, target) {
            $('[data-row-image="' + $(target).data('img') + '"]').remove();
        });
        (new SaveTrait({selector: '#send-images', clearFormFieldsOnSuccess: ['images[]']}).setAdditionalFailCallback(function (response) {
            $('.preload-news').addClass('d-none');
        }).setAdditionalSuccessCallback(function (response) {
            $('.preload-news').addClass('d-none');
            $('#images-block').html(response.images);
            deleteImage.selectorRefresh();
        }));
        (new SaveTrait({selector: '.card', fixCkEditorData: true, clearFormFieldsOnSuccess: ['images[]']})).setAdditionalData(function (data) {
            data.append('type', $('.panel-tabs').find('.active').data('type'));
            return data;
        }).setAdditionalSuccessCallback(function (response) {
            $('#images-block').html(response.images);
            deleteImage.selectorRefresh();
            $('.preload-news').addClass('d-none');
        });
        CKEDITOR.replaceAll('ckeditor');
        changeImage();
    </script>
    <script src="{{ asset('admin-styles/js/articleImg.js') }}"></script>
@endpush