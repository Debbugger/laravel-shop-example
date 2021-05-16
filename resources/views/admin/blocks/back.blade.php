<a @if (empty($redirectBack)) href="{{url()->previous()}}" @else  href="{{$redirectBack}}" @endif class="btn btn-outline-primary btn-sm waves-effect">
    Назад
</a>