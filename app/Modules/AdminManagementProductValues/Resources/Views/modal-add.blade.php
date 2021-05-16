<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class=""><a class="nav-link @if($localeCode==LaravelLocalization :: getCurrentLocale ()) active  updateClick @endif" data-toggle="tab" href="#{{ $localeCode }}add" role="tab">{{ $properties['native'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <div class="tab-pane @if($localeCode==LaravelLocalization :: getCurrentLocale ())active @endif" id="{{ $localeCode }}add" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group localization localizationLast">
                            <label class="form-label"> Значение</label>
                            <input class="form-control add-value-input" name="value[]" placeholder="Введмте значение">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<input hidden name="category_id" value="{{$category_id}}">
<input type="hidden" name="specification_id" value="{{$specification_id}}">
<div class="modal-footer">
    <div class="col-md-6">
        <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">Отмена</button>
    </div>
    <div class="col-md-6">
        <button type="submit" class="btn btn-success   waves-effect waves-light w-100">Создать</button>

    </div>
</div>