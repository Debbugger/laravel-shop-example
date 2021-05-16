@extends('admin::main')

@section('title', 'Создание акции')

@section('content')
    <table class="empty-row" style="display: none;">
        <tbody>
        <tr>
            <td class="image-td"><img src=""></td>
            <td class="image-td"><a class="delete-tr" style="color:red"><i class="fas fa-trash"></i></a></td>

        </tr>
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
                    <form id="create" class="card" method="post" action="{{route('adminDiscountCreate')}}" enctype="multipart/form-data">
                        <div class="card-header">
                            <h3 class="card-title">Создание акции</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">На сайте:</label>
                                        <div class="changeStatusModal">
                                            <i class="far fa-2x fa-check-circle show-icon"></i>
                                        </div>
                                        <input hidden name="status" value="1">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="form-label">Картинка акции</div>
                                        <div class="hover-img" data-type="edit" data-id="0">
                                            <img class="edit-img" data-type="edit" src="{{asset('images/default/default_category.png')}}"><label class="uploadbutton loader-file ">
                                                <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                        <input type="file" name="image" data-type="edit" data-id="0" hidden/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ссылка</label>
                                        <input type="text" class="form-control" name="slug" placeholder="Ссылка">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Тип скидки</label>
                                        <select class="form-control" name="type_discont">
                                            <option value="0">Отсутвует</option>
                                            <option value="1">Числовое значение</option>
                                            <option value="2">На % от текущей стоимости</option>
                                        </select>
                                    </div>
                                    <div class="form-group dicont-data-inputs d-none ">
                                        <label class="form-label">Начало скидки</label>
                                        <input autocomplete="off" class="datepicker-here form-control " data-date-format="yyyy-mm-dd" name="start_date" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group dicont-data-inputs  d-none">
                                        <label class="form-label">Завершение скидки</label>
                                        <input autocomplete="off" class="datepicker-here form-control " data-date-format="yyyy-mm-dd"  name="end_date" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group dicont-data-inputs  d-none">
                                        <label class="form-label">Скидка</label>
                                        <input class="form-control" type="number" min="0" step="1" name="discont"  placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group dicont-data-inputs d-none ">
                                        <label class="form-label">Товары с данной скидкой</label>
                                        <select class="multi-select" name="products[]" multiple="multiple">
                                            @foreach($categories as $category)
                                                <optgroup label="{{parseMultiLanguageString($category->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}">
                                                    @foreach($category->products as $product)
                                                        <option value="{{$product->id}}" >{{parseMultiLanguageString($product->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group dicont-data-inputs d-none">
                                        <div class="form-label">Значия скидок товаров</div>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="change_discont" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Обновить значения в выбраных товарах</span>
                                        </label>
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
                                                    <label class="form-label">Заголовок</label>
                                                    <input class="form-control" name="name[]" placeholder="Название">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group localization">
                                                    <label class="form-label">Кототкое описание</label>
                                                    <textarea class="ckeditor" name="short_description[]" rows="3" placeholder="Короткое описание"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group localization localizationLast">
                                                    <label class="form-label">Полное описание</label>
                                                    <textarea class="ckeditor" name="description[]"  rows="8" placeholder="Полное описание"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div class="d-flex justify-content-between">
                                @include('admin.blocks.back',['redirectBack'=>route('adminDiscount')])
                                <button type="submit" class="btn btn-success  btn-sm waves-effect waves-light">Сохранить</button>
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
        $(document).ready(function () {
            $('.multi-select').select2();
            changeImage();
            changeStatusModal();
            $('[name=type_discont]').on('change', function () {
                if ($(this).val() == 0)
                    $('.dicont-data-inputs').addClass('d-none');
                else
                    $('.dicont-data-inputs').removeClass('d-none');

            });
            (new SaveTrait({selector: '#create',fixCkEditorData:true}));
        });

    </script>
@endpush