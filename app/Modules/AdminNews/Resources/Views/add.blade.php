@extends('admin::main')

@section('title', 'Добавление страницы')

@section('content')
    <table class="empty-row" style="display: none;">
        <tbody>
        @include('adminManagementProduct::images')
        </tbody>
    </table>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Добавление новости</h4>
                {{ Breadcrumbs::render('adminNewsAddPage') }}
            </div>
            <div class="row">
                <div class="col-12">
                    <form method="post" action="{{ route('adminNewsAddPage') }}" class="card">
                        @csrf
                        <div class="card-header">
                            <div class="card-title">Страница новости</div>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-label">Главная картинка</div>
                                    <div class="hover-img" data-type="edit" data-id="0">
                                        <img class="edit-img" src="{{asset('images/default/default_category.png')}}" data-type="edit"><label class="uploadbutton loader-file ">
                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <input type="file" name="image" data-type="edit" data-id="0" hidden/>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Адрес:</label>
                                    <input type="text" class="form-control" name="slug">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label">Изображения:</div>
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
                                <div class="col-12">
                                    <div class="d-flex">
                                        <label class="custom-control custom-checkbox mt-2 ml-1">
                                            <input type="checkbox" class="custom-control-input" name="status" checked value="1">
                                            <span class="custom-control-label">Показать на сайте?</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 tabs-menu1">
                                <ul class="nav panel-tabs" role="tablist">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li class="nav-item"><a class="nav-link @if($loop->first)active @endif" data-toggle="tab" href="#{{ $localeCode }}" role="tab">{{ $properties['native'] }}</a></li>
                                    @endforeach
                                </ul>
                                <div class="tab-content mt-3 border">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <div class="tab-pane @if($loop->first)active @endif" id="{{ $localeCode }}" role="tabpanel">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Заголовок:</label>
                                                    <input type="text" class="form-control" name="title[]">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Короткое описание:</label>
                                                    <textarea class="form-control ckeditor" id="ckeditor_short-{{ $localeCode }}" name="short_text[]" rows="12"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Описание:</label>
                                                    <textarea class="form-control ckeditor" id="ckeditor-{{ $localeCode }}" name="full_text[]" rows="12"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @include('admin.blocks.back',['redirectBack'=>route('adminNews')])
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-light float-right"> Сохранить</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
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
            $('.images').on('change', function (e) {
                $('.table-images').css('display', 'block');
                for (let i = 0; i < e.target.files.length; i++)
                    Images.push(e.target.files[i]);
                $(this).val(null);
                updateTableImages();
            });
        });
        (new SaveTrait({selector: '.card', enableButtonOnSuccess: false, fixCkEditorData: true})).setAdditionalData(function (data) {
            data.delete('images[]');
            let j = 0;
            for (let i = 0; i <= Images.length; i++) {
                if (Images[i] != null) {
                    data.set('images[' + j + ']', Images[i]);
                    j++;
                }
            }
            data.append('type', $('.panel-tabs').find('.active').data('type'));
            return data;
        });
        changeImage();
        CKEDITOR.replaceAll('ckeditor');
    </script>
    <script src="{{ asset('admin-styles/js/articleImg.js') }}"></script>
@endpush

