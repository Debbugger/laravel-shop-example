<?php

namespace App\Modules\Review\Http\Controllers;

use App\Review;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use SaveTrait;
    private $form = [
        'user_id' => ['required'],
        'value'   => ['required', 'min:30', 'max:200'],
        'status'  => ['required']
    ];

    public function createResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'view' => view('review::review')->with('review', Review::with('user')->where('id', $instance->id)->firstOrFail())->render(), 'clear' => 1]);
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response(['status' => 0, 'message' => trans('alert.review-fail')]);
        }
        $request->merge(['user_id' => Auth::user()->id]);

        $request->merge(['status' => 0]);

        return $this->save(Review::class);
    }
    public function all(){
        $reviews=Review::orderBy('id','desc')->where('status',1)->get();
        return view('modules.review.all')->with('reviews',$reviews);
    }
}
