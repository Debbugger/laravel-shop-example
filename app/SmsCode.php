<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'type',
        'phone',
    ];
}
