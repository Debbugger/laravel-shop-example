<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Количество</th>
                        <th>Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderProducts as $order)
                    <tr>
                        <th scope="row">{{$order->id}}</th>
                        <td>{{parseMultiLanguageString($order->product->name ?? null, LaravelLocalization :: getCurrentLocale ())}}</td>
                        <td>{{$order->count}}</td>
                        <td>{{$order->costFront}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th scope="row">#</th>
                        <td>Сума:</td>
                        <td>{{$item->count}}</td>
                        <td>{{$item->sum}}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label class="form-label">Отправить:</label>
                    <select class="custom-select form-control" name="status">
                        <option @if ($item->status==1) selected @endif value="1">@lang('profile.home-status-ready')</option>
                        <option @if ($item->status==2) selected @endif value="2">@lang('profile.home-status-lost')</option>
                        <option @if ($item->status==3) selected @endif value="3">@lang('profile.home-status-finish')</option>
                    </select>
                    <div class="invalid-feedback"></div>
                    <input type="hidden" name="id" value="{{$item->id}}">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="col-md-6">
        <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">Отмена</button>
    </div>
    <div class="col-md-6">
        <button type="submit" class="btn btn-success waves-effect waves-light w-100">Отправить</button>
    </div>
</div>