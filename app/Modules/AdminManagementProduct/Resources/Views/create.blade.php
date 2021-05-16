@extends('admin::main')

@section('title', 'Создание товаров')

@section('content')
    <table class="empty-row" style="display: none;">
        <tbody>
        @include('adminManagementProduct::images')
        </tbody>
    </table>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Товар</h4>
                @include('admin.blocks.breadcrumbs')
            </div>
            <div class="row">
                <div class="col-12">
                    <form id="create" class="card" method="post" action="{{route('adminManagementProductCreate')}}" enctype="multipart/form-data">
                        <div class="card-header">
                            <h3 class="card-title">Создать товар</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Категория</label>
                                        <select class="js-select2" name="category_id">
                                            @foreach($category as $option)
                                                @if (!in_array($option->id,$notShow??[]))
                                                    <option value="{{$option->id}}">{{parseMultiLanguageString($option->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Тип</label>
                                        <select class="js-select2" name="type">
                                            <option value="0">Обычный товар</option>
                                            <option value="1">@lang('home.product-day')</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ссылка</label>
                                        <input type="text" class="form-control" name="slug" placeholder="Ссылка">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Цена от</label>
                                        <input class="form-control" type="number" min="0" step="1" name="cost" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Цена до</label>
                                        <input class="form-control" type="number" min="0" step="1" name="cost_to" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Тип скидки</label>
                                        <select class="form-control" name="type_discont">
                                            <option selected value="0">Отсутвует</option>
                                            <option value="1">Числовое значение</option>
                                            <option value="2">На % от текущей стоимости</option>
                                        </select>
                                    </div>
                                    <div class="form-group dicont-data-inputs d-none">
                                        <label class="form-label">Начало скидки</label>
                                        <input autocomplete="off" class="datepicker-here form-control " data-date-format="yyyy-mm-dd" name="start_date" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group dicont-data-inputs d-none">
                                        <label class="form-label">Завершение скидки</label>
                                        <input autocomplete="off" class="datepicker-here form-control " data-date-format="yyyy-mm-dd" name="end_date" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group dicont-data-inputs d-none">
                                        <label class="form-label">Скидка</label>
                                        <input class="form-control" type="number" min="0" step="1" name="discont" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu ">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                    <li class=""><a class="nav-link @if($localeCode==LaravelLocalization :: getCurrentLocale ()) active  @endif" data-toggle="tab" href="#{{ $localeCode }}" role="tab">{{ $properties['native'] }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <div class="tab-pane @if($localeCode==LaravelLocalization :: getCurrentLocale ())active @endif" id="{{ $localeCode }}" role="tabpanel">
                                                <div class="form-group localization">
                                                    <label class="form-label">Название</label>
                                                    <input type="text" class="form-control" name="name[]" placeholder="Имя">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group localization localizationLast">
                                                    <label class="form-label">Описание</label>
                                                    <textarea class="ckeditor" name="description[]" rows="6" placeholder="Описание"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-label">Главная картинка</div>
                                    <div class="form-group">
                                        <div class="hover-img" data-type="edit" data-id="0">
                                            <img class="edit-img" data-type="edit" src="{{asset('images/default/default_product.jpg')}}"><label class="uploadbutton loader-file ">
                                                <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                        <input type="file" name="image" data-type="edit" data-id="0" hidden/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label">Картинки</div>
                                        <div class="custom-file multi-images">
                                            <input type="file" class="custom-file-input images" name="images[]" multiple>
                                            <label class="custom-file-label label-images">Выберете картинки</label>
                                            <input type="hidden" name="deleted">
                                        </div>
                                        <table class="table-images" width="100%">
                                            <thead>
                                            <tr>
                                                <th width="80%">Картинка</th>
                                                <th width="20%">Удалить</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div class="d-flex justify-content-between">
                                @include('admin.blocks.back',['redirectBack'=>route('adminManagementProducts')])
                                <button type="submit" class="btn btn-success  btn-sm waves-effect waves-light">Далее</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let Images = [];

        function updateTableImages() {
            let n = Images.length;
            let row = $('.empty-row');
            let table = $('.table-images');
            table.find('tbody').html(' ');
            for (let i = 0; i < n; i++) {
                if (Images[i] != null) {
                    row.find('img').attr('src', URL.createObjectURL(Images[i]));
                    row.find('.delete-tr').attr('data-id', i);
                    table.find('tbody').append(row.find('tbody').html());
                }
            }

            $('.delete-tr').on('click', function () {
                delete Images[$(this).data('id')];
                $(this).parent().parent().remove();
            });

        }

        $(document).ready(function () {
            changeImage();
            $('.table-images').css('display', 'none').append($('.empty-row').html());
            $('.js-select2').off().select2();
            $('.images').on('change', function (e) {
                $('.table-images').css('display', 'block');
                for (let i = 0; i < e.target.files.length; i++)
                    Images.push(e.target.files[i]);
                $(this).val(null);
                updateTableImages();

            });
            (new SaveTrait({selector: '#create'}).setAdditionalData(function (callback) {
                callback.delete('images[]');
                let j = 0;
                for (let i = 0; i <= Images.length; i++) {
                    if (Images[i] != null) {
                        callback.set('images[' + j + ']', Images[i]);
                        j++;
                    }
                }
                return callback;
            }));
            $('[name=type_discont]').on('change', function () {
                if ($(this).val() == 0)
                    $('.dicont-data-inputs').addClass('d-none');
                else
                    $('.dicont-data-inputs').removeClass('d-none');

            });
        });

    </script>
@endpush