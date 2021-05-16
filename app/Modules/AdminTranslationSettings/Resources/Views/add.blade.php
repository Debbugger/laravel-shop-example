@extends('admin::main')

@push('scripts')
    <script>
        $(document).ready(function () {
            new SaveTrait({selector: 'form.card', enableButtonOnSuccess: false, clearFormOnSuccess: true,fixCkEditorData:true});
        });
        $('[name=type_text]').on('change', function () {
            if ($(this).val() == 2) {
                $('.input-for-data').addClass('d-none');
                $('.textarea-for-data').removeClass('d-none');
            } else {
                $('.textarea-for-data').addClass('d-none');
                $('.input-for-data').removeClass('d-none');
            }
        });
    </script>
@endpush

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Добавление перевода</h4>
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('adminTranslationAdd') }}
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <form method="post" class="card form-horizontal form-material" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Група</label>
                                        <input type="text" class="form-control" value="{{$group ?? null}}" name="group" placeholder="Група">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Ключ</label>
                                        <input type="text" class="form-control" name="key" placeholder="Ключ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs customtab2" role="tablist">
                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <li class="nav-item"><a class="nav-link @if($loop->first)active @endif" data-toggle="tab" href="#{{ $localeCode }}" role="tab">{{ $properties['native'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <label class="form-label">Тип значения</label>
                                            <select class="form-control" name="type_text">
                                                <option  selected  value="1">Обычный текст</option>
                                                <option  value="2">Страница</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="tab-content mt-3">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <div class="tab-pane @if($loop->first)active @endif" id="{{ $localeCode }}" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 input-for-data">
                                                        <div class="form-group">
                                                            <label class="form-label">Текст</label>
                                                            <input type="text" class="form-control" name="text[]" placeholder="Текст"/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 textarea-for-data  d-none ">
                                                        <div class="form-group">
                                                            <label class="form-label">Текст</label>
                                                            <textarea name="text2[]" class="ckeditor"></textarea>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('adminTranslationSetting') }}" class="btn btn-outline-primary btn-sm waves-effect">Назад</a>
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-light float-right">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection