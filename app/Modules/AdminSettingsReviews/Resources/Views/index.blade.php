@extends('admin::main')

@section('title', 'Отзывы')

@section('content')
    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Редактирование отзыва</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('adminSettingsReviewsEdit')}}" id="form-edit" class="form-modal">
                    <img class="preload-category" src="{{asset('admin-styles/images/loader.gif')}}">
                </form>
            </div>
        </div>
    </div>
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
                        <form method="post" action="{{route('adminSettingsReviewsDelete')}}" id="form-delete">
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
                <h4 class="page-title">Отзывы</h4>
                @include('admin.blocks.breadcrumbs')
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Таблица отзывов</div>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-striped table-bordered">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <form id="changeShow" class="form-edit-show" action="{{route('adminSettingsReviewsChangeShow')}}">
                            <input name="id" hidden>
                        </form>
                        <form id="edit-form-img" enctype="multipart/form-data" action="{{route('adminSettingsReviewsImage')}}">
                            <input type="file" name="image" data-id="" data-type="table" hidden/>
                            <input name="id" data-type="table" hidden/>
                        </form>
                        <form id="get-modal-edit">
                            <input hidden name="id">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <!-- Data table js -->
    <script>
        let modal = $('.modal');
        let id = 0;

        function updateModal() {
            data_table.clear().draw();
        }

        let data_table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('adminSettingsReviewsTable')}}',
            columns: [
                {data: 'id', 'title': '#'},
                {data: 'status', 'title': 'На сайте', className: "icon-center changeShow"},
                {data: 'user', name:'user.name', 'title': 'Пользователь'},
                {data: 'value', 'title': 'Отзыв'},
                {data: 'edit', 'title': '',"searchable": false}
            ],
            'columnDefs': [ {
                'targets': [4], /* column index */
                'orderable': false, /* true or false */
            }],
            language: lang,
            "order": [[0, "desc"]],
        }).on('draw.dt', function () {
            deleteModal();
            changeImage();
            $('.edit-modal').on('click', function () {
                $('[name=id]').val($(this).parent().parent().data('id'));
                $('#get-modal-edit').trigger('submit');
            });
            (new SaveTrait({selector: '#get-modal-edit', actionUrl: '{{route('adminSettingsReviewsModal')}}'}).setAdditionalFailCallback(function (callback) {
                $('#form-edit').html(callback);
            }));
            changeStatus();
            (new SaveTrait({selector: '#changeShow', selectorType: 'editShow'}).setAdditionalData(function (callback) {
                return callback;
            }).setAdditionalSuccessCallback(function (callback) {
                if (callback.show == 1)
                    $('tr[data-id=' + callback.id + ']').find('.changeShow').html('<i data-id="' + callback.id + '" class="far fa-2x fa-check-circle show-icon changeStatus"  ></i>').removeClass('no-active');
                else
                    $('tr[data-id=' + callback.id + ']').find('.changeShow').html('<i data-id="' + callback.id + '" class="fas fa-2x fa-ban unshow-icon changeStatus" ></i>').removeClass('no-active');
                changeStatus();
            }));

        });

        (new SaveTrait({selector: '.get-modal-add', selectorType: 'click', actionUrl: '{{route('adminSettingsReviewsModal')}}'}).setAdditionalData(function (callback) {
            return callback;
        }).setAdditionalFailCallback(function (callback) {
            $('#form-add').html(callback);
        }));
        (new SaveTrait({selector: '#form-add'}).setAdditionalSuccessCallback(function () {
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

        (new SaveTrait({selector: '#edit-form-img',  selectorType: 'sendImage'}).setAdditionalSuccessCallback(function () {
            $('#edit-form-img').find('[name=image]').val(null);
        }));
    </script>,
@endpush