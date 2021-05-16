<?php

namespace App\Modules\User\Http\Controllers;

use App\Favorite;
use App\Http\Controllers\GlobalCardController;
use App\Modules\Order\Http\Controllers\OrderController;
use App\Order;
use App\Product;
use App\Traits\SaveTrait;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use SaveTrait;
    private $redirect = '/home';
    private $form = [
        'email'    => ['required', 'email', 'unique:users'],
        'name'     => ['required'],
        'password' => ['required'],
        'phone'    => ['required', 'unique:users'],
        'date'     => ['required', 'date'],

    ];

    public function createResponse($instance, $callbackResult)
    {
        Auth::loginUsingId($instance->id);
        User::findOrFail($instance->id)->assignRole('user');

        return response(['status' => 1, 'message' => trans('alert.guest-register'), 'redirect' => route('userHome')]);
    }


    public function home(Request $request)
    {
        $orders = Order::where('user_id', Auth::user()->id)->with('products', 'products.category')->orderBy('updated_at', 'desc')->get();

        return view('modules.user.orders')->with('orders', $orders);
    }

    public function favorites(Request $request)
    {
        $favorites = Favorite::with('product')->where('user_id', Auth::user()->id)->get();
        $globalCard = new GlobalCardController;

        return view('modules.user.favorites')->with(['favorites' => $favorites, 'card' => array_keys($globalCard->getCookie())]);
    }

    public function updateResponse($instance, $callbackResult)
    {
        if ($this->redirect == route('userPass')) {
            return response(['status' => 1, 'message' => trans('alert.user-pass-edit'), 'redirect' => $this->redirect]);
        }

        return response(['status' => 1, 'message' => trans('alert.user-data-edit')]);
    }

    public function pass(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $this->redirect = route('userPass');
            if (!Hash::check($request->input('current'), $user->password)) {
                return response(['status' => 0, 'message' => trans('alert.user-current-pass-fail')]);
            }
            $this->form = [
                'password' => ['required', 'confirmed'],

            ];

            return $this->save($user);
        }

        return view('modules.user.pass');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $this->form = [
                'email' => ['required', 'email', 'unique' => Rule::unique('users', 'email')->ignore($user->id)],
                'phone' => ['required', 'phone:AUTO', 'unique' => Rule::unique('users', 'phone')->ignore($user->id)],
                'date'  => ['required', 'date'],

            ];;

            return $this->save($user);
        }

        return view('modules.user.data');
    }
}
