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
            <div class="form-group">
                <label class="form-label">Пользователь:</label>
                <select class="js-select2" name="user_id">
                    @foreach($users as $option)
                        <option value="{{$option->id}}">{{$option->name}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label class="form-label"> Отзыв</label>
                <textarea class="form-control" name="value" placeholder="Введмте ссылку" >{{$item->value}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <input name="id" hidden value="{{$item->id}}">
        </div>
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
        $('.js-select2').off().select2();
        changeImage();
        changeStatusModal();
    });
</script>