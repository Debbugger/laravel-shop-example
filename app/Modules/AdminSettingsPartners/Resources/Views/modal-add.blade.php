<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <input hidden name="status" value="1">
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
            <div class="form-group">
                <label class="form-label"> Ссылка</label>
                <input class="form-control" name="link" placeholder="Введмте ссылку" >
                <div class="invalid-feedback"></div>
            </div>
        </div>
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
        changeImage();
        changeStatusModal();
    });
</script>