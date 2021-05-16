@extends('admin::main')

@section('title', 'Склад')

@section('content')
    <div id="add-modal" data-type="add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Добавление записи в склад</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('adminManagementStockCreate')}}" id="form-add" class="form-modal">
                    <img class="preload-category" src="{{asset('admin-styles/images/loader.gif')}}">
                </form>
            </div>
        </div>
    </div>
  <!--  <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Редактирование записи в складе</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('adminManagementStockEdit')}}" id="form-edit" class="form-modal">
                    <img class="preload-category" src="{{asset('admin-styles/images/loader.gif')}}">
                </form>
            </div>
        </div>
    </div> -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Удаление записи</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <h5 class="modal-body text-center">Вы уверены, что хотите удалить запись?</h5>
                <div class="modal-footer">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">Отмена</button>
                    </div>
                    <div class="col-md-6">
                        <form method="post" action="{{route('adminManagementStockDelete')}}" id="form-delete">
                            <input hidden name="delete">
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
                <h4 class="page-title">Склад</h4>
                @include('admin.blocks.breadcrumbs')
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Таблица склада</div>
                            @include('admin.blocks.create')
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form id="get-modal-edit">
                        <input hidden name="id">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let modal = $('.modal');
            let id = 0;

            $.fn.modal.Constructor.prototype._enforceFocus = function () {
            };

            function updateModal() {
                data_table.clear().draw();
            }

            let data_table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('adminManagementStockTable')}}',
                columns: [
                    {data: 'id', 'title': '#'},
                    {data: 'product',name:'product.name', 'title': 'Товар'},
                    {data: 'type', 'title': 'Тип'},
                    {data: 'count', 'title': 'Количество'},
                    {data: 'comment', 'title': 'Коментарий'},
                  /*  {data: 'edit', 'title': ''}*/
                ],
                language: lang,
                "order": [[0, "desc"]],
            }).on('draw.dt', function () {
                deleteModal();
                $('.edit-modal').on('click', function () {
                    $('[name=id]').val($(this).parent().parent().data('id'));
                    $('#get-modal-edit').trigger('submit');
                });
                (new SaveTrait({selector: '#get-modal-edit', actionUrl: '{{route('adminManagementStockModal')}}'}).setAdditionalFailCallback(function (callback) {
                    $('#form-edit').html(callback);
                }));
            });

        });

        (new SaveTrait({selector: '.get-modal-add', selectorType: 'click', actionUrl: '{{route('adminManagementStockModal')}}'}).setAdditionalData(function (callback) {
            return callback;
        }).setAdditionalFailCallback(function (callback) {
            $('#form-add').html(callback);
        }));
        (new SaveTrait({selector: '#form-add',showFailToast:true}).setAdditionalSuccessCallback(function () {
            updateModal();
            setTimeout(function () {
                $("#add-modal").modal("hide");
            }, 600);
        }));
        (new SaveTrait({selector: '#form-edit'}).setAdditionalSuccessCallback(function () {
            updateModal();
            setTimeout(function () {
                $("#edit-modal").modal("hide");
            }, 600);
        }));
        (new SaveTrait({selector: '#form-delete'}).setAdditionalSuccessCallback(function () {
            updateModal();
        }));
    </script>,
@endpush