<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Фильтр:</label>
                <div class="changeStatusModal">
                    @if ($item->filter==1)
                        <i class="far fa-2x fa-check-circle show-icon "></i>
                    @else
                        <i class="fas fa-2x fa-ban unshow-icon "></i>
                    @endif
                </div>
                <input hidden name="filter" value="{{$item->filter}}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
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
                        <div class="form-group localization localizationLast">
                            <label class="form-label"> Имя</label>
                            <input class="form-control" name="name[]" placeholder="Введите имя" value="{{parseMultiLanguageString($item->name ?? null, $localeCode) }}">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
            <input type="hidden" class="form-control" name="id" value="{{$item->id}}">
    </div>
</div>
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
        $('.changeStatusModal').off().on('click', function () {
            $('[name=filter]').val(1 - $('[name=filter]').val());
            if ($('[name=filter]').val() == 1)
                $(this).html('<i class="far fa-2x fa-check-circle show-icon "></i>');
            else
                $(this).html('<i  class="fas fa-2x fa-ban unshow-icon"></i>');
        });
    });
</script>