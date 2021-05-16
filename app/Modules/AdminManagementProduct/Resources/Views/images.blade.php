@if (!empty($images))
    @foreach($images as $image)
        <tr>
            <td class="image-td"><img src="{{asset($image->path)}}"></td>
            <td class="image-td "><a class="delete delete-tr" data-id="{{$image->id}}" style="color:red"><i class="fas fa-trash"></i></a></td>
        </tr>
    @endforeach
@else
    <tr>
        <td class="image-td"><img src=""></td>
        <td class="image-td "><a class="delete delete-tr" data-id="" style="color:red"><i class="fas fa-trash"></i></a></td>
    </tr>
@endif