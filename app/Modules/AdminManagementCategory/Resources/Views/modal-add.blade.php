<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">На сайте:</label>
                <div class="changeStatusModal">
                    <i class="far fa-2x fa-check-circle show-icon"></i>
                </div>
                <input hidden name="status" value="1">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Главная категория</label>
            <select name="parent_id" class="js-select2">
                <option value="0">Не выбрано</option>
                @foreach($categories as $elem)
                    <option  value="{{$elem->id}}">{{parseMultiLanguageString($elem->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Картинка:</label>
                <div class="hover-img" data-type="add" data-id="0">
                    <img class="edit-img" data-type="add" data-id="0" src="{{asset('images/default/default_category.png')}}"><label class="uploadbutton loader-file " data-id="0" data-type="add">
                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                    </label>
                </div>
                <input type="file" name="image" data-type="add" data-id="0" hidden/>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label"> Характеристики:</label>
                <select class="js-multiple-select2" name="specifications[]" multiple="multiple">
                    @foreach($specifications as $option)
                        <option value="{{$option->id}}">{{parseMultiLanguageString($option->name ?? null, LaravelLocalization :: getCurrentLocale ()) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
    <div class="tab-content">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <div class="tab-pane @if($localeCode==LaravelLocalization :: getCurrentLocale ())active @endif" id="{{ $localeCode }}" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group localization">
                            <label class="form-label"> Имя</label>
                            <input class="form-control" name="name[]" placeholder="Введмте имя">
                            <div class="invalid-feedback"></div>
                        </div>


                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group localization localizationLast">
                            <label class="form-label"> Описание</label>
                            <textarea rows="6" class="form-control" name="description[]" placeholder="Введмте описание"> </textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="modal-footer">
    <div class="col-md-6">
        <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">Отмена</button>
    </div>
    <div class="col-md-6">
        <button type="submit" class="btn btn-success waves-effect waves-light w-100">Создать</button>

    </div>

</div>
<script>
    $(document).ready(function () {
        $('.js-multiple-select2').off().select2();
        $('.js-select2').off().select2();
        changeImage();
        changeStatusModal();
    });
</script>