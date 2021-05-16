@extends('admin::main')

@section('title', 'Акции')

@section('content')
    <div id="seo-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Seo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('adminDiscountChangeSeo')}}" id="form-seo" class="form-modal">
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
                        <form method="post" action="{{route('adminDiscountDelete')}}" id="form-delete">
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
                <h4 class="page-title">Акции</h4>
                @include('admin.blocks.breadcrumbs')
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Таблица акций</div>
                            @include('admin.blocks.create',['href'=> route('adminDiscountCreate')])
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>


                        <!-- table-wrapper -->
                    </div>
                    <form id="edit-form-img" enctype="multipart/form-data" action="{{route('adminDiscountImage')}}">
                        <input type="file" name="image" data-id="" data-type="table" hidden/>
                        <input name="id" data-type="table" hidden/>
                    </form>
                    <form id="changeShow" class="form-edit-show" action="{{route('adminDiscountChangeShow')}}">
                        <input name="id" hidden>
                    </form>
                    <form id="get-seo-modal" method="get">
                        <input hidden name="id">
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let modal = $('.modal');
        let id = 0;
        let showElem = 0;

        function updateModal() {
            data_table.clear().draw();
        }

        let data_table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('adminDiscountTable')}}',
            columns: [
                {data: 'id', 'title': '#'},
                {data: 'status', 'title': 'На сайте', className: "icon-center changeShow","searchable": false},
                {data: 'image', 'title': 'Иконка', className: "td-image ","searchable": false},
                {data: 'name', 'title': 'Название'},
                {data: 'edit', 'title': '',"searchable": false}
            ],
            'columnDefs': [ {
                'targets': [2,4], /* column index */
                'orderable': false, /* true or false */
            }],
            language: lang,
            "order": [[0, "desc"]],
        }).on('draw.dt', function () {
            deleteModal();
            changeImage();
            changeStatus();
            $(".get-seo-modal").click(function () {
                $('[name=id]').val($(this).parent().parent().data('id'));
                console.log($(this).parent().parent().data('id'));
                $('#get-seo-modal').trigger('submit');
            });

            (new SaveTrait({selector:'#get-seo-modal',showSuccessToast:false, actionUrl: '{{route('adminDiscountSeoModal')}}'}).setAdditionalFailCallback(function (callback) {
                $('#form-seo').html(callback);
            }).setAdditionalSuccessCallback(function () {
                modal.modal("hide");
            }));
            (new SaveTrait({selector: '#changeShow', selectorType: 'editShow'}).setAdditionalData(function (callback) {
                return callback;
            }).setAdditionalSuccessCallback(function (callback) {
                if (callback.show==1)
                    $('tr[data-id=' + callback.id + ']').find('.changeShow').html('<i data-id="'+ callback.id +'" class="far fa-2x fa-check-circle show-icon changeStatus "  ></i>').removeClass('no-active');
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
        (new SaveTrait({selector: '#edit-form-img',  selectorType: 'sendImage'}).setAdditionalSuccessCallback(function () {
            $('#edit-form-img').find('[name=image]').val(null);
        }));
        (new SaveTrait({selector: '#form-delete'})).setAdditionalSuccessCallback(function () {
            updateModal();
        });
    </script>,
@endpush