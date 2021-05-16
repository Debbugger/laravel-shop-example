<?php

namespace App\Observers;

use App\SmsCode;
use App\User;
use GuzzleHttp\Client;

class SmsCodeObserver
{
    /**
     * Handle the sms code "created" event.
     *
     * @param  \App\SmsCode  $smsCode
     * @return void
     */
    public function created(SmsCode $smsCode)
    {
        $client = new Client();
        $user=User::find($smsCode->user_id);
        if (empty($user)){
            $phone=$smsCode->phone;
            $text='Код для создания пароля: ';
        }
        else{
            $phone=$user->phone;
            $text='Код для изменения пароля: ';
        }
       if ($smsCode->type=='registerGuest')
           $text='Пароль: ';
        $res = $client->request('POST', 'https://integrationapi.net/rest/v2/Sms/Send', [
            'query' => [
                'Login'              => env('SMS_LOGIN', null),
                'Password'           => env('SMS_PASS', null),
                'SourceAddress'      => 'Centralnyi',
                'DestinationAddress' => str_replace(' ', '', $phone),
                'Data'               => $text . $smsCode->code
            ]
        ]);
    }

    /**
     * Handle the sms code "updated" event.
     *
     * @param  \App\SmsCode  $smsCode
     * @return void
     */
    public function updated(SmsCode $smsCode)
    {
        //
    }

    /**
     * Handle the sms code "deleted" event.
     *
     * @param  \App\SmsCode  $smsCode
     * @return void
     */
    public function deleted(SmsCode $smsCode)
    {
        //
    }

    /**
     * Handle the sms code "restored" event.
     *
     * @param  \App\SmsCode  $smsCode
     * @return void
     */
    public function restored(SmsCode $smsCode)
    {
        //
    }

    /**
     * Handle the sms code "force deleted" event.
     *
     * @param  \App\SmsCode  $smsCode
     * @return void
     */
    public function forceDeleted(SmsCode $smsCode)
    {
        //
    }
}
