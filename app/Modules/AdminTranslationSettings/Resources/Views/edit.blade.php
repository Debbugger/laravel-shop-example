@extends('admin::main')

@push('scripts')
    <script>
        $(document).ready(function () {
            new SaveTrait({selector: 'form.card',fixCkEditorData:true});
            new SaveTrait({
                selector: '.modal-footer .delete-item',
                selectorType: 'click',
                actionUrl: '{{ route('adminTranslationDeleteGroup', ['id' => $item->id]) }}',
                button: '.modal-footer .delete-item',
                showFailToast: true,
                redirectTimeout: 500
            }).setAdditionalSuccessCallback(function (response) {
                $('.modal').modal('hide');
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
        });
    </script>
@endpush

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Редактирование перевода</h4>
                <ol class="breadcrumb">
                    {{  Breadcrumbs::render('adminTranslationEdit',$group,$item) }}
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <form method="post" class="card form-horizontal form-material" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header justify-content-between">
                            <h3 class="card-title">Редактирование перевода</h3>
                        </div>
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
                                        <input type="text" class="form-control" value="{{$item->key}}" name="key" placeholder="Ключ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <ul class="nav nav-tabs customtab2 m-0" role="tablist">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <li class="nav-item"><a class="nav-link @if($loop->first)active @endif" data-toggle="tab" href="#{{ $localeCode }}" role="tab">{{ $properties['native'] }}</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <label class="form-label">Тип значения</label>
                                            <select class="form-control" name="type_text">
                                                <option @if ($item->type_text==1) selected @endif value="1">Обычный текст</option>
                                                <option @if ($item->type_text==2) selected @endif  value="2">Страница</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="tab-content mt-3">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <div class="tab-pane @if($loop->first)active @endif" id="{{ $localeCode }}" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 input-for-data @if ($item->type_text==2) d-none @endif">
                                                        <div class="form-group">
                                                            <label class="form-label">Текст</label>
                                                            <input type="text" class="form-control" value="@if ($item->type_text==1) {{parseMultiLanguageString($item->text,$localeCode)}} @endif" name="text[]" placeholder="Текст"/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 textarea-for-data @if ($item->type_text==1) d-none @endif">
                                                        <div class="form-group">
                                                            <label class="form-label">Текст</label>
                                                            <textarea name="text2[]" class="ckeditor">@if ($item->type_text==2) {!!  parseMultiLanguageString($item->text,$localeCode)!!} @endif</textarea>
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
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('adminTranslationGroup',$group) }}" class="btn btn-outline-primary btn-sm waves-effect"> Назад</a>
                            <div class="d-flex">
                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm waves-effect mr-2" data-toggle="modal" data-target="#deleteModal">Удалить</a>
                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-light ">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
