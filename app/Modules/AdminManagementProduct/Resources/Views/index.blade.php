@extends('admin::main')

@section('title', 'Товары')

@section('content')
    <div id="seo-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Seo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('adminManagementProductChangeSeo')}}" id="form-seo" class="form-modal">
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
                        <form method="post" action="{{route('adminManagementProductDelete')}}" id="form-delete">
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
                <h4 class="page-title">Товары</h4>
                @include('admin.blocks.breadcrumbs')
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Таблица товаров</div>
                            @include('admin.blocks.create',['href'=> route('adminManagementProductCreate')])
                        </div>
                        <div class="card-body">
                                <table id="table" class="table table-striped table-bordered" >
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                        </div>
                        <form id="edit-form-img" enctype="multipart/form-data" action="{{route('adminManagementProductImage')}}">
                            <input type="file" name="image" data-id="" data-type="table" hidden/>
                            <input name="id" data-type="table" hidden/>

                        </form>
                        <form id="get-seo-modal" method="get">
                            <input hidden name="id">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let modal=$(".modal");
        function updateModal(){
            data_table
                .clear()
                .draw();
        }
          let  data_table= $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('adminManagementProductTable')}}',
                columns: [
                    {data: 'id', 'title': '#'},
                    {data: 'image', 'title': 'Картинка',"searchable": false},
                    {data: 'category',name:'category.name', 'title': 'Категория'},
                    {data: 'name', 'title': 'Имя'},
                    {data: 'cost', 'title': 'Цена'},
                    {data: 'slug', 'title': 'Ссылка'},
                    {data: 'edit', 'title': '',"searchable": false}

                ],
                 language: lang,
                "order": [[0, "desc"]],
            }).on('draw.dt', function () {
              $(".get-seo-modal").click(function () {
                  $('[name=id]').val($(this).parent().parent().data('id'));
                  $('#get-seo-modal').trigger('submit');
              });
              (new SaveTrait({selector:'#get-seo-modal',showSuccessToast:false, actionUrl: '{{route('adminManagementProductSeoModal')}}'}).setAdditionalFailCallback(function (callback) {
                  $('#form-seo').html(callback);
              }).setAdditionalSuccessCallback(function () {
                  modal.modal("hide");
              }));
                changeImage();
                deleteModal();
            });

        (new SaveTrait({selector: '#form-delete'}).setAdditionalSuccessCallback(function () {
            updateModal();
        }));
        (new SaveTrait({selector: '#edit-form-img', selectorType: 'sendImage'}));
        (new SaveTrait({selector: '#form-seo'}).setAdditionalSuccessCallback(function () {
            setTimeout(function () {
                modal.modal("hide");
            }, 600);
        }));
    </script>
@endpush