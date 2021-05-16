<?php

namespace App\Modules\Card\Http\Controllers;

use App\Http\Controllers\GlobalCardController;
use App\Http\Controllers\GlobalFavoriteController;
use App\Mail\CreateUser;
use App\Modules\Order\Http\Controllers\OrderController;
use App\OrderProduct;
use App\Product;
use App\SmsCode;
use App\Stock;
use App\Traits\SaveTrait;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CardController extends Controller
{
    use SaveTrait;

    public function createResponse($instance, $callbackResult)
    {
        Auth::loginUsingId($instance->id);
        User::findOrFail($instance->id)->assignRole('user');
        $order = new OrderController();
        Mail::to($instance->email)->send(new CreateUser($instance->phone, $this->password));
        SmsCode::create(['phone' => $instance->phone, 'code' => $this->password,'type' => 'registerGuest','user_id'=>'0']);
        return $order->register();

    }


    public function add(Request $request)
    {
        if (!empty(Cookie::get('card'))) {
            $currentCookie = json_decode(Cookie::get('card'), true);
        } else {
            $currentCookie = [];
        }
        if (empty($currentCookie[$request->id])) {
            $currentCookie[$request->id] = 0;
        }

        $cardController = (new GlobalCardController());

        $currentCookie[$request->id] += $request->count;
        $cookie = Cookie::make('card', json_encode($currentCookie), 1440);
        if ($cardController->haveCountProduct($currentCookie[$request->id], $request->id)) {
            return response(['status' => 1, 'message' => trans('alert.card-add'), 'count' => $currentCookie[$request->id], 'cost' => Product::findOrFail($request->id)->costFront, 'id' => $request->input('id')])->withCookie($cookie);
        }
        $cookie = $cardController->updateCookie($currentCookie, $request->id);
        $count = $cardController->countProduct($request->id);
        $alert = str_replace('$count', $count, trans('alert.card-have'));

        return response(['status' => 0, 'message' => $alert, 'count' => $count, 'cost' => Product::findOrFail($request->id)->costFront, 'id' => $request->input('id')])->withCookie($cookie);

    }

    public function minus(Request $request)
    {
        $currentCookie = json_decode(Cookie::get('card'), true);
        if ($currentCookie[$request->id] + $request->count > 0) {
            $currentCookie[$request->id] += $request->count;
        }
        $cardController = (new GlobalCardController());
        $cookie = $cardController->updateCookie($currentCookie, $request->id);

        return response(['status' => 1, 'message' => trans('alert.card-remove'), 'count' => $currentCookie[$request->id], 'cost' => Product::findOrFail($request->id)->costFront, 'id' => $request->input('id')])->withCookie($cookie);

    }

    public function process(Request $request)
    {
        if ($request->ajax()) {
            try {
                $request->merge(['phone' => phone($request->input('phone'), 'UA', 1)]);
            } catch (\Exception $exception) {

            }
            $this->form = [
                'password' => ['required', 'min' => '6'],
                'name'     => ['required', 'min' => '3'],
                'phone'    => ['required', 'unique' => 'users,phone', 'phone' => 'phone:AUTO,UA'],
                'email'    => ['required', 'email', 'unique' => 'users,email']
            ];
            $this->password = Str::random(8);
            $request->merge(['password' => $this->password]);
            $this->redirectTo = route('userHome');
            $this->crateOrder = true;

            return $this->save(User::class);
        }

        return view('modules.auth.guest');

    }
    public function processOld(Request $request)
    {
            try {
                $request->merge(['phone' => phone($request->input('phone'), 'UA', 1)]);
            } catch (\Exception $exception) {

            }
            if (!Auth::attempt($request->only('phone', 'password'))) {
                return response(['status'=>0,'message'=>trans('alert.login-fail')]);
            }
            $this->redirectTo = route('userHome');
            $this->crateOrder = true;
            $order = new OrderController();

            return $order->register();
    }

    public function delete(Request $request)
    {
        $cardController = (new GlobalCardController());
        $currentCookie = json_decode(Cookie::get('card'), true);
        $cookie = $cardController->removeElemCookie($currentCookie, $request->id);

        return response(['status' => 1, 'message' => trans('alert.card-remove')])->withCookie($cookie);

    }

    public function index()
    {
        $currentCookie = json_decode(Cookie::get('card'), true);
        if (!empty($currentCookie)) {
            $products = Product::whereIn('id', array_keys($currentCookie))->get();
        } else {
            $products = null;
        }
        $globalFavorite = new GlobalFavoriteController();

        return view('modules.card.card')->with(['products' => $products, 'favorites' => array_column($globalFavorite->favorites(), 'product_id'), 'counts' => $currentCookie]);
    }
}