<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">На сайте:</label>
                <div class="changeStatusModal">
                    @if ($item->status==1)
                        <i class="far fa-2x fa-check-circle show-icon "></i>
                    @else
                        <i class="fas fa-2x fa-ban unshow-icon "></i>
                    @endif
                </div>
                <input hidden name="status" value="{{$item->status}}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Картинка:</label>
                <div class="hover-img" data-type="add" data-id="0">
                    <img class="edit-img" data-type="add" data-id="0" src="{{asset($item->image)}}"><label class="uploadbutton loader-file " data-id="0" data-type="add">
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
                        <div class="form-group localization ">
                            <label class="form-label"> Описание</label>
                            <textarea rows="3" class="form-control" name="description[]" placeholder="Введмте описание"> {{parseMultiLanguageString($item->description ?? null, $localeCode) }}</textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group localization localizationLast">
                            <label class="form-label"> Ссылка</label>
                            <input class="form-control" name="slug[]" placeholder="Введмте ссылку" value="{{parseMultiLanguageString($item->slug ?? null, $localeCode) }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<input hidden name="id" value="{{$item->id}}">
<div class="modal-footer">
    <div class="col-md-6">
        <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">Отмена</button>
    </div>
    <div class="col-md-6">
        <button type="submit" class="btn btn-success waves-effect waves-light w-100">Изменить</button>

    </div>
</div>
<script>
    $(document).ready(function () {
        $('.js-multiple-select2').off().select2();
        changeImage();
        changeStatusModal();
    });
</script>