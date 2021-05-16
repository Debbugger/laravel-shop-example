@extends('admin::main')

@section('title', 'Редактирование товаров')

@section('content')
    <table class="empty-row" style="display: none;">
        <tbody>
        <tr>
            <td class="image-td"><img src=""></td>
            <td class="image-td"><a class="delete-tr" data-type="new" style="color:red"><i class="fas fa-trash"></i></a></td>

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
                    <form id="edit" class="card" method="post" action="{{route('adminManagementProductEdit',$id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Редактировать товар</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Категория</label>
                                        <select class="js-select2" name="category_id">
                                            @foreach($category as $option)
                                                @if (!in_array($option->id,$notShow??[]))
                                                    <option @if ($product->category_id==$option->id) selected @endif value="{{$option->id}}">{{parseMultiLanguageString($option->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Тип</label>
                                        <select class="js-select2" name="type">
                                            <option value="0">Обычный товар</option>
                                            <option @if ($product->type==1) selected @endif value="1">@lang('home.product-day')</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ссылка</label>
                                        <input type="text" class="form-control" name="slug" placeholder="Ссылка" value="{{$product->slug}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Цена от</label>
                                        <input class="form-control" type="number" min="0" step="1" name="cost" value="{{$product->currentCost}}" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Цена до</label>
                                        <input class="form-control" type="number" min="0" step="1" name="cost_to" value="{{$product->currentCostTo}}" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Характеристики</label>
                                        <a class="btn btn-outline-primary btn-sm waves-effect waves-light" href="{{route('adminManagementProductValues',$id)}}">редактировать</a>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Тип скидки</label>
                                        <select class="form-control" name="type_discont">
                                            <option value="0">Отсутвует</option>
                                            <option @if ($product->type_discont==1) selected @endif value="1">Числовое значение</option>
                                            <option @if ($product->type_discont==2) selected @endif  value="2">На % от текущей стоимости</option>
                                        </select>
                                    </div>
                                    <div class="form-group dicont-data-inputs @if ($product->type_discont==0) d-none @endif">
                                        <label class="form-label">Начало скидки</label>
                                        <input autocomplete="off" class="datepicker-here form-control " data-date-format="yyyy-mm-dd" value="{{$product->start_date}}" name="start_date" value="{{$product->cost}}" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group dicont-data-inputs @if ($product->type_discont==0) d-none @endif">
                                        <label class="form-label">Завершение скидки</label>
                                        <input autocomplete="off" class="datepicker-here form-control " data-date-format="yyyy-mm-dd" value="{{$product->end_date}}" name="end_date" value="{{$product->cost}}" placeholder="0">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group dicont-data-inputs @if ($product->type_discont==0) d-none @endif">
                                        <label class="form-label">Скидка</label>
                                        <input class="form-control" type="number" min="0" step="1" name="discont" value="{{$product->discont}}" placeholder="0">
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
                                                    <input type="text" class="form-control" name="name[]" value="{{parseMultiLanguageString($product->name ?? null, $localeCode)}}" placeholder="Имя">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group localization localizationLast">
                                                    <label class="form-label">Описание</label>
                                                    <textarea class="ckeditor" name="description[]" rows="6" placeholder="Описание">{{parseMultiLanguageString($product->description ?? null, $localeCode)}}</textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">

                                    <div class="form-group">
                                        <div class="form-label">Главная картинка</div>
                                        <div class="hover-img" data-type="edit" data-id="0">
                                            <img class="edit-img" src="{{asset($product->image)}}" data-type="edit"><label class="uploadbutton loader-file ">
                                                <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                        <input type="file" name="image" data-type="edit" data-id="0" hidden/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label">Картинки</div>
                                        <div class="custom-file multi-images">
                                            <label class="custom-file-label label-images">Выберете картинки</label>
                                            <input type="hidden" name="deleted">
                                        </div>
                                        <table class="table-images" width="100%" @if (empty($images)) style="display: none;" @endif>
                                            <thead>
                                            <tr>
                                                <th width="80%">Картинка</th>
                                                <th width="20%">Удалить</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @include('adminManagementProduct::images')
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div class="d-flex justify-content-between">
                                @include('admin.blocks.back',['redirectBack'=>route('adminManagementProducts')])
                                <button type="submit" class="btn btn-success  btn-sm waves-effect waves-light">Сохранить</button>
                            </div>
                        </div>
                    </form>
                    <form id="form-delete" action="{{route('adminManagementProductImagesDelete',$id)}}">
                        <input type="hidden" name="id">
                    </form>
                    <form id="files">
                        <input type="file" class="custom-file-input images" name="images[]" multiple>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function deleteImage() {
                $('.delete-tr').off().on('click', function () {
                    $('#form-delete').find('[name=id]').val($(this).data('id')).trigger('delete');

                    $(this).parent().parent().remove();
                });
            }

            $(document).ready(function () {
                changeImage();
                deleteImage();
                $('.js-select2').off().select2();
                $('.custom-file-label').on('click', function () {
                    $('.images').trigger('click');
                });
                $('.images').on('change', function (e) {
                    $('.table-images').find('tbody').html('<img class="preload-product" src="{{asset("admin-styles/images/loader.gif")}}" >');
                    $('#files').trigger('getImages');
                    $(this).val(null);
                });
                $('[name=category_id]').on('change', function () {
                    $('#edit').trigger('changeCategory');
                });

                (new SaveTrait({selector: '#form-delete', selectorType: 'delete'}));
                (new SaveTrait({selector: '#files', showFailToast: false, selectorType: 'getImages', actionUrl: "{{route('adminManagementProductImages',$id)}}"}).setAdditionalFailCallback(function (callback) {
                    $('.table-images').find('tbody').html(callback);
                    deleteImage();

                }));
                (new SaveTrait({selector: '#edit', showFailToast: false, selectorType: 'category', actionUrl: "{{route('adminManagementProductCategory',$id)}}"}));
                (new SaveTrait({selector: '#edit'}).setAdditionalData(function (callback) {
                    callback.delete('images[]');
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
@endsection