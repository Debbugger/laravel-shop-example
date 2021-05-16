<div class="card">
    <div class="card-header">
        <h3 class="card-title">Изображения</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Доп. изображения</label>
                    <div class="row">
                        @foreach($item->images as $img)
                            <div class="col-md-6 img-scale-b" data-row-image="{{$img}}">
                                <div class="img-scale">
                                    <a href="#" class="fa fa-close delete-item" id="deleteImage" data-id="{{ $item->id }}" data-img="{{ $img }}" style="font-size: 20px"></a>
                                    <img class="img-thumbnail" src="{{ asset($img) }}">
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div class="alert alert-info text-small mb-0 mt-3" style="margin-bottom: 0px!important;">
                                Для добавления картинок перетащите их в редактор
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
