<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalCardController;
use App\Modules\Order\Http\Controllers\OrderController;
use App\SmsCode;
use App\Traits\SaveTrait;
use App\User;
use App\Mail\CreateUser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class AuthController extends Controller
{

    protected $redirectTo = '/admin';
    protected $crateOrder = false;
    protected $password = null;
    protected $recovery = false;
    use SaveTrait;
    private $form = [
        'phone'    => ['required', 'unique:users', 'phone' => 'phone:AUTO,UA'],
        'password' => ['required', 'max' => '255'],
        'email'    => ['required', 'unique:users'],
        'name' => ['required']
    ];


    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function login(Request $request)
    {
        $this->form = [
            'phone'    => ['required', 'phone' => 'phone:AUTO,UA'],
            'password' => ['required', 'max' => '255'],
        ];
        if ($request->ajax()) {
            try {
                $request->merge(['phone' => phone($request->input('phone'), 'UA', 1)]);
            } catch (\Exception $exception) {

            }
            if (!(($validator = $this->validateRequest()) instanceof \Illuminate\Validation\Validator)) {
                return $validator;
            }
            if (Auth::attempt($request->only('phone', 'password'))) {
                if (!Auth::user()->hasRole('admin')) {
                    $this->redirectTo = route('userHome');
                }

                return response(['status' => 1, 'message' => trans('alert.login-success'), 'redirect' => $this->redirectTo]);
            }

            return response(['status' => 0, 'message' => trans('alert.login-fail')]);
        }

        return view('modules.auth.login');
    }

    public function createResponse($instance, $callbackResult)
    {
        Auth::loginUsingId($instance->id);
        User::findOrFail($instance->id)->assignRole('user');

        return response(['status' => 1, 'message' => trans('alert.profile-create'), 'redirect' => $this->redirectTo]);
    }

    public function updateResponse($instance, $callbackResult)
    {
        if ($this->recovery) {
            return response(['status' => 1, 'message' => trans('alert.pass-change'), 'redirect' => route('login')]);
        }
    }
    public function preRegister(Request $request){
        $this->form = [
            'phone'    => ['required', 'unique:users', 'phone' => 'phone:AUTO,UA'],
            'email'    => ['required', 'unique:users'],
            'name' => ['required']
        ];
        SmsCode::where('created_at', '<', Carbon::now()->addMinutes(-15))->delete();
            $this->messages['unique'] = 'Пользователя с такими данными уже есть';
            $secret_code = Str::random(6);
            try {
                $request->merge(['phone' => phone($request->input('phone'), 'UA', 1)]);
            } catch (\Exception $exception) {

            }

            if (!(($validator = $this->validateRequest()) instanceof \Illuminate\Validation\Validator)) {
                return $validator;
            }
            $oldSms = SmsCode::where(['phone' => $request->input('phone'), 'type' => 'register'])->first();
            if (!$oldSms) {
                $oldSms = SmsCode::create(['phone' => $request->input('phone'), 'code' => $secret_code,'type' => 'register','user_id'=>'0']);
            }

            return response(['status' => 1, 'message' => trans('alert.code-send'), 'created' => $oldSms->created_at->format('m.d H:i')]);
    }
    public function register(Request $request)
    {
        if ($request->ajax()) {
            $this->messages['unique'] = 'Пользователя с такими данными уже зарегистрирован';
            try {
                $request->merge(['phone' => phone($request->input('phone'), 'UA', 1)]);
            } catch (\Exception $exception) {

            }
            $smsCode = SmsCode::where('code', $request->input('code'))->first();
            if (!$smsCode) {
                return response(['status' => 0, 'message' => trans('alert.recovery-code-error')]);
            }
            $this->form = [
                'password' => ['required', 'min' => '6', 'max' => '255', 'confirmed'],
                'name'     => ['required', 'min' => '3', 'max' => '255'],
                'phone'    => ['required', 'unique' => 'users,phone', 'phone' => 'phone:AUTO,UA'],
                'email'    => ['required', 'unique:users'],
            ];
            $this->redirectTo = route('userHome');
            return $this->save(User::class);
        }

        return view('modules.auth.register');
    }

    public function recovery(Request $request)
    {
        $this->form = [
            'phone' => ['required', 'phone' => 'phone:AUTO,UA']
        ];
        SmsCode::where('created_at', '<', Carbon::now()->addMinutes(-15))->delete();
        if ($request->ajax()) {
            $secret_code = Str::random(6);
            try {
                $request->merge(['phone' => phone($request->input('phone'), 'UA', 1)]);
            } catch (\Exception $exception) {

            }
            if (!(($validator = $this->validateRequest()) instanceof \Illuminate\Validation\Validator)) {
                return $validator;
            }
            $user = User::where('phone', $request->input('phone'))->first();
            if (!$user) {
                return response(['status' => 0, 'message' => trans('alert.recovery-phone-error')]);
            }
            $oldSms = SmsCode::where(['user_id' => $user->id, 'type' => 'recovery'])->first();
            if (!$oldSms) {
                $oldSms = SmsCode::create(['user_id' => $user->id, 'code' => $secret_code, 'type' => 'recovery']);
            }

            return response(['status' => 1, 'message' => trans('alert.code-send'), 'created' => $oldSms->created_at->format('m.d H:i')]);
        }

        return view('modules.auth.recovery');
    }

    public function changePass(Request $request)
    {
        $this->form = [
            'password' => ['required', 'confirmed','min'=>'6'],

        ];
        if (!(($validator = $this->validateRequest()) instanceof \Illuminate\Validation\Validator)) {
            return $validator;
        }
        $smsCode = SmsCode::where('code', $request->input('code'))->first();
        if (!$smsCode) {
            return response(['status' => 0, 'message' => trans('alert.recovery-code-error')]);
        }
        $this->recovery = true;
        $smsCode->delete();
        return $this->save(User::findOrFail($smsCode->user_id));
    }
}
