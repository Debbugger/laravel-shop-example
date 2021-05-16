@extends('admin::main')

@section('title', 'Новости')

@section('content')
    <div id="seo-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Seo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('adminNewsChangeSeo')}}" id="form-seo" class="form-modal">
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
                        <form method="post" action="{{route('adminNewsDeletePage')}}" id="form-delete">
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
                <h4 class="page-title">Новости</h4>
                {{ Breadcrumbs::render('adminNews') }}
            </div>
            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <div class="card">
                        <div class="d-flex card-header">
                            <h3 class="p-2 flex-grow-1 card-title">Список новостей</h3>
                            <a href="{{ route('adminNewsAddPage') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light">Создать</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pages-table" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th class="wd-15p">#</th>
                                        <th class="wd-15p">На сайте</th>
                                        <th class="wd-30p">Название</th>
                                        <th class="wd-15p">Адрес</th>
                                        <th class="wd-15p"></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <form id="changeShow" class="form-edit-show" action="{{route('adminNewsChangeShow')}}">
                            <input name="id" hidden>
                        </form>
                        <form id="get-seo-modal" method="get">
                            <input hidden name="id">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <link rel="stylesheet" href="{{ asset('admin-styles/plugins/datatable/dataTables.bootstrap4.min.css') }}">
        <script src="{{ asset('admin-styles\plugins\datatable\jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin-styles\plugins\datatable\dataTables.bootstrap4.min.js') }}"></script>

        <script>
            let modal=$('.modal');
            function updateModal() {
                pages
                    .clear()
                    .draw();
            }
            let pages = $('#pages-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {method: 'post', url: window.location.href},
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'status', name: 'status', className: "icon-center changeShow"},
                    {data: 'title', name: 'title'},
                    {data: 'slug', name: 'slug'},
                    {data: 'action', name: 'action'},
                ],
                language: lang,
            }).on('draw.dt', function () {
                changeStatus();
                deleteModal();
                $(".get-seo-modal").click(function () {
                    $('[name=id]').val($(this).parent().parent().data('id'));
                    $('#get-seo-modal').trigger('submit');
                });

                (new SaveTrait({selector:'#get-seo-modal',showSuccessToast:false, actionUrl: '{{route('adminNewsSeoModal')}}'}).setAdditionalFailCallback(function (callback) {
                    $('#form-seo').html(callback);
                }).setAdditionalSuccessCallback(function () {
                    modal.modal("hide");
                }));

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
            (new SaveTrait({selector: '#form-seo'}).setAdditionalSuccessCallback(function () {
                updateModal();
                setTimeout(function () {
                    modal.modal("hide");
                }, 600);
            }));
            (new SaveTrait({selector: '#form-delete'}).setAdditionalSuccessCallback(function () {
                setTimeout(function () {
                    modal.modal("hide");
                }, 600);
                updateModal();
            }).setAdditionalFailCallback(function () {
                setTimeout(function () {
                    modal.modal("hide");
                }, 600);
                updateModal();
            }));

        </script>
    @endpush
@endsection
