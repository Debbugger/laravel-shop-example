<input type="number" hidden name="id" value="{{$item ? $item->id : null}}">
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Адрес</label>
                    <input type="text" class="form-control" value="{{ $item->slug}}" name="slug" placeholder="Укажите адрес"/>
                    <div class="invalid-feedback"></div>
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
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" value="{{parseMultiLanguageString($item ? $item->meta_title : [],$localeCode)}}" name="meta_title[]" placeholder="Укажите title"/>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Keywords</label>
                                    <input type="text" class="form-control" value="{{parseMultiLanguageString($item ? $item->meta_keywords : [],$localeCode)}}" name="meta_keywords[]" placeholder="Укажите keywords"/>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" value="{{parseMultiLanguageString($item ? $item->meta_description : [],$localeCode)}}" name="meta_description[]" placeholder="Укажите description"/>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary btn-sm waves-effect" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-success btn-sm waves-effect waves-light">Сохранить</button>
    </div>
<script>
    new SaveTrait({selector: 'form.send-form'}).setAdditionalSuccessCallback(function () {
        table.ajax.reload();
        $('.modal').modal('hide');
    });
</script>