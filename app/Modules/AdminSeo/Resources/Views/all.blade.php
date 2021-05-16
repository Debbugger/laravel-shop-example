@extends('admin::main')

@section('title', 'SEO')

@push('scripts')

    <link rel="stylesheet" href="{{ asset('admin-styles/plugins/datatable/dataTables.bootstrap4.min.css') }}">
    <script src="{{ asset('admin-styles\plugins\datatable\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-styles\plugins\datatable\dataTables.bootstrap4.min.js') }}"></script>
    <script>
        let getModal = new SaveTrait({selector: '.show-modal', disableButtonOnProcess: false, enableButtonOnSuccess: false, enableButtonOnFail: false, buttonSpinnerOnProcess: false, showFailToast: false, showSuccessToast: false, selectorType: 'click', actionUrl: '{{route('adminSeo')}}'}).setAdditionalData(function (data, target) {
            data.append('id', $(target).data('id'));
            return data;
        }).setAdditionalFailCallback(function (response) {
            $('.modal-content').html(response);
            $('body').on('hidden.bs.modal hide.bs.modal', function () {
                $('.modal-content').html($('.loader-item').children()[0]);
            });
        });

        let table = $('#seo-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {method: 'get', url: '{{route('adminCreateOrEditSeo')}}'},
            columns: [
                {data: 'id', name: 'id'},
                {data: 'address', name: 'address'},
                {data: 'meta_title', name: 'meta_title'},
                {data: 'meta_keywords', name: 'meta_keywords'},
                {data: 'meta_description', name: 'meta_description'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action'},
            ],
            language: lang,
        }).on('draw.dt', function () {
            getModal.selectorRefresh();
            deleteItem.selectorRefresh();
        });

        let deleteItem = new SaveTrait({selector: '.delete', selectorType: 'click', actionUrl: '{{route('adminSeoDelete')}}'}).setAdditionalData(function (data, target) {
            data.append('id', $(target).data('id'));
            return data;
        }).setAdditionalSuccessCallback(function () {
            table.ajax.reload();
            getModal.selectorRefresh();
        }).setSendMiddleware(async function (eventa, target) {
            let res = await (function () {
                return Swal.fire({
                    title: 'Удаление',
                    text: "Вы действительно хотите удалить запись?",
                    showCancelButton: true,
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                });
            })();
            return !!res.value;
        });


    </script>
@endpush

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Управление мета данными страниц</h4>
                {{ Breadcrumbs::render('adminSeo') }}
            </div>
            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">Список SEO</div>
                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary show-modal" data-toggle="modal" data-target=".modal-item">Добавить</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="seo-table" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th class="wd-15p">#</th>
                                        <th class="wd-15p">Адрес</th>
                                        <th class="wd-20p">Title</th>
                                        <th class="wd-20p">Keywords</th>
                                        <th class="wd-20p">Description</th>
                                        <th class="wd-15p">Изменен</th>
                                        <th class="wd-25p"></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="loader-item" hidden>
        <div class="lds-hourglass"></div>
    </div>
    <div class="modal modal-item fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content" style="min-height: 200px">
                <div class="lds-hourglass"></div>
            </div>
        </div>
    </div>
@endsection