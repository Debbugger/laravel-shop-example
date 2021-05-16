@extends('admin::main')

@section('title', 'Значения характеристик')

@section('content')
    <div id="add-modal" class="modal fade " data-type="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Добавление значения</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-modal" method="post" action="{{route('adminManagementSpecificationValueCreate')}}" id="form-add">
                    <img class="preload-category" src="{{asset("admin-styles/images/loader.gif")}}">
                </form>
                <form action="{{route('adminManagementSpecificationValueModal')}}" id="get-modal-add">
                    <input type="hidden" name="specification_id">
                    <input hidden name="category_id" value="{{$category_id}}">
                </form>
            </div>
        </div>
    </div>
    <div id="edit-modal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Изменение значения</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-modal" method="post" action="{{route('adminManagementSpecificationValueEdit')}}" id="form-edit">
                    <img class="preload-category" src="{{asset("admin-styles/images/loader.gif")}}">
                </form>
                <form action="{{route('adminManagementSpecificationValueModal')}}" id="get-modal-edit">
                    <input type="hidden" name="specification_id">
                    <input hidden name="category_id" value="{{$category_id}}">
                    <input name="value_id" hidden>
                </form>
            </div>
        </div>
    </div>
    <div id="delete-modal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Удаление записи</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <h5 class="modal-body text-center">Вы уверены, что хотите удалить запись?<br>
                    <p style="color: red">Если в других товарах используется это значение,<br>выбор будет изменен на (не выбрано)</p></h5>
                <div class="modal-footer">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">Отмена</button>
                    </div>
                    <div class="col-md-6">
                        <form method="post" action="{{route('adminManagementSpecificationValueDelete')}}" id="form-delete">
                            <input type="hidden" name="specification_id">
                            <input type="hidden" name="value_id">
                            <input hidden name="category_id" value="{{$category_id}}">
                            <button id="delete" aria-hidden="true" type="submit" class="btn btn-success waves-effect waves-light w-100 ">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Характеристики</h4>
                @include('admin.blocks.breadcrumbs',['redirectBack'=>route('adminManagementProductEdit',$id)])
            </div>
            <div class="row">
                <div class="col-12">
                    @if ($specifications->isNotEmpty())
                        <form class="card" action="{{route('adminManagementProductValues',['id'=>$id,'redirectTable'=>1])}}" id="edit-value">
                            <div class="card-header justify-content-between">
                                <h3 class="card-title">Значения характеристик товара</h3>
                            </div>
                            <div class="card-body">
                                @foreach($specifications as $spec)
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>{{parseMultiLanguageString($spec->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</label>
                                                <select data-id="{{$spec->id}}" class="js-select2 " name="value[{{$spec->id}}]">
                                                    <?php $count = 0; ?>
                                                    @foreach ($spec->values as $val)
                                                        @if ($val->category->category_id==$category_id)
                                                            <?php $count++; ?>
                                                            <option @if (in_array($val->id,$selected)) selected @endif value="{{$val->id}} ">{{parseMultiLanguageString($val->value ?? null, LaravelLocalization :: getCurrentLocale ())}}</option>
                                                        @endif
                                                    @endforeach
                                                    @if ($count==0)
                                                        <option value="0">Не выбрано</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label style="width: 100%;height: 15px"></label>
                                                <a data-toggle="modal" data-target="#add-modal" data-id="{{$spec->id}}" data-type="add" class="border-0 btn btn-outline-primary btn-sm waves-effect waves-light change-values get-modal-add"><i class="fas fa-plus"></i></a>
                                                <a data-toggle="modal" data-target="#edit-modal" data-id="{{$spec->id}}" data-type="edit" class="border-0 btn btn-outline-primary btn-sm waves-effect waves-light change-values get-modal-edit"><i class="fa fa-pencil-square-o "></i></a>
                                                <a data-toggle="modal" data-target="#delete-modal" data-id="{{$spec->id}}" data-type="delete" class="border-0 btn btn-outline-primary btn-sm waves-effect waves-light change-values"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <input name="category_id" value="{{$category_id}}" hidden>
                                <div class="card-footer text-right">
                                    <div class="d-flex justify-content-between">
                                        @include('admin.blocks.back',['redirectBack' => route('adminManagementProductEdit',$id)])
                                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-light">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        У категории даного товара нету характеристик
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                let locals = JSON.parse('{!!json_encode(LaravelLocalization::getSupportedLocales())!!}');

                function autoClose() {
                    setTimeout(function () {
                        $(".modal").modal("hide");
                    }, 600);
                }

                $(".modal").on("show.bs.modal", function () {
                    $('.updateClick').trigger('click');
                    $('.invalid-feedback').text('').removeClass('is-invalid');
                    $('.form-control').removeClass('is-invalid');
                    $('.add-value-input').val(null);
                });
                $('.js-select2').select2();
                $('.change-values').on('click', function () {
                    let thisSelect = $('.js-select2[data-id=' + $(this).data('id') + ']');
                    if ((thisSelect.val() == 0) && ($(this).data('type') != 'add')) {
                        alert('Выберете елемент перед редактированием');
                        $(this).attr('data-toggle', null);
                        return this;
                    }
                    $(this).attr('data-toggle', 'modal');
                    $('[name=specification_id]').val($(this).data('id'));
                    $('[name=value_id]').val(thisSelect.val());
                    if ($(this).data('type') == 'edit') {
                        $('#get-modal-edit').trigger('submit');
                    }
                    if ($(this).data('type') == 'add') {
                        $('#get-modal-add').trigger('submit');
                    }
                    thisSelect.trigger('change');
                });

                (new SaveTrait({selector: '#form-add', showFailToast: true}).setAdditionalSuccessCallback(function (response) {
                    let thisSelect = $('.js-select2[data-id=' + response.specification_id + ']');
                    thisSelect.append(new Option(response.value, response.id, false, false)).val(response.id).trigger('change');
                    autoClose();
                }));
                (new SaveTrait({selector: '#get-modal-edit'}).setAdditionalFailCallback(function (callback) {
                    $('#form-edit').html(callback);
                }));

                (new SaveTrait({selector: '#get-modal-add', actionUrl: '{{route('adminManagementSpecificationValueModal')}}'}).setAdditionalFailCallback(function (callback) {
                    $('#form-add').html(callback);
                }));
                (new SaveTrait({selector: '#form-edit', showFailToast: true}).setAdditionalSuccessCallback(function (response) {
                    let thisSelect = $('.js-select2[data-id=' + response.specification_id + ']');
                    let data = JSON.parse(response.json);
                    thisSelect.empty();
                    thisSelect.select2({data: data});
                    thisSelect.val(response.id).trigger('change');
                    autoClose();
                }));
                (new SaveTrait({selector: '#form-delete', showFailToast: true}).setAdditionalSuccessCallback(function (response) {
                    let thisSelect = $('.js-select2[data-id=' + response.specification_id + ']');
                    let data = JSON.parse(response.json);
                    thisSelect.empty();
                    thisSelect.select2({data: data});
                    thisSelect.val(null).trigger('change');
                    autoClose();
                }));
                (new SaveTrait({selector: '#edit-value', showFailToast: true}));
            });
        </script>
    @endpush
@endsection