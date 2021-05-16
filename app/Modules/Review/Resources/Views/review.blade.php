<div class="reviews-b-item ">
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