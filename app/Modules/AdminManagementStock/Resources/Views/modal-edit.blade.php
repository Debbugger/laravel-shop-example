<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Тип</label>
                <select class="custom-select form-control" name="type">
                    <option  value="1">Получение</option>
                    <option @if ($item->type==2)selected @endif value="2">Отправка</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Количество</label>
                <input class="form-control" type="number" min="0" step="1" name="count" placeholder="0" value="{{$item->count}}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Товар</label>
                <select class="js-select2" name="product_id">
                    @foreach($products as $product)
                        <option @if ($item->product_id==$product->id) selected @endif value="{{$product->id}}">{{parseMultiLanguageString($product->name ?? null, LaravelLocalization :: getCurrentLocale ())}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group ">
                <label class="form-label"> Коментарий</label>
                <textarea rows="4" class="form-control" name="comment" placeholder="Введите описание">{{$item->comment}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <input type="hidden" name="id" value="{{$item->id}}">
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
        $('.js-select2').select2();
    });

</script>