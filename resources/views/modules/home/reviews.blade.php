<div id="review-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">@lang('review.modal-title')</h4>
                <a class="close" style="cursor: pointer;" data-dismiss="modal" aria-hidden="true">×</a>
            </div>
            <form method="post" class="form-modal" id="add-review" action="{{route('reviewAdd')}}">
                <div class="modal-body">
                    <div class="form-group">
                        <textarea rows="5" name="value" class="form-control w-100 p-3" placeholder="@lang('placeholder.review-create')"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary waves-effect w-100" data-dismiss="modal">@lang('modal.off')</button>
                    <button type="submit" class="btn btn-primary btn-shadow w-100">@lang('review.modal-send')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="">
            <div class="reviews-b-h">
                <h2 class="h2 text-primary text-center mb-2">@lang('home.reviews')</h2>
            </div>
            <div class="reviews-b-top reviews-show">
                <div class="reviews-b-list d-flex flex-wrap justify-content-start all-reviews">
                    @foreach($reviews as $review)
                        <div class="reviews-b-item">
                            <div class="user-info d-flex align-items-center">
                                <div class="d-flex align-items-center mr-3">
                                    <img src="{{asset('img/user-img.png')}}" class="img-fluid" alt="">
                                </div>
                                <div class="d-flex flex-column">
                                    <div>{{$review->user->name}}</div>
                                    <div>{{  $review->created_at->format('d.m.y H:i')}}</div>
                                </div>
                            </div>
                            <div class="description mt-3">
                                {{$review->value}}
                            </div>
                        </div>
                    @endforeach
                    @if (empty($currentUser))
                        <div class="d-flex align-items-center w-100 justify-content-center">
                            <a href="{{route('register')}}" class="btn btn-primary btn-sm d-flex  align-items-center text-white mx-1">@lang('review.create')</a>
                            <a href="{{route('reviewAll')}}" class="btn btn-primary btn-sm d-flex  align-items-center text-white mx-1">@lang('review.all')</a>
                        </div>
                    @endif
                </div>
                @if (!empty($currentUser))
                    <div class="d-flex align-items-center w-100 justify-content-center">
                        <button type="button" data-toggle="modal" data-target="#review-modal" class="btn btn-primary btn-sm d-flex  align-items-center text-white mx-1">@lang('review.modal')</button>
                        <a href="{{route('reviewAll')}}" class="btn btn-primary btn-sm d-flex  align-items-center text-white mx-1">@lang('review.all')</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.open-reviews').on('click', function () {
                if ($('.reviews-show').hasClass('d-none')) {
                    $('.reviews-show').removeClass('d-none');
                    $(this).html("@lang('home.reviews-close')");
                } else {
                    $('.reviews-show').addClass('d-none');
                    $(this).html("@lang('home.reviews-open')");
                }
            });

            (new SaveTrait({selector: '#add-review', showFailToast: false, showSuccessToast: false}).setAdditionalSuccessCallback(function (callback) {
                $('.all-reviews').prepend(callback.view);
                if (callback.clear)
                    $('[name=value]').val(null);
            }));
        });
    </script>
@endpush