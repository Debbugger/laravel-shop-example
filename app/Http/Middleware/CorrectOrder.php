<?php

namespace App\Http\Middleware;


use App\Http\Controllers\GlobalCardController;
use Closure;
use Illuminate\Support\Facades\Cookie;

class CorrectOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $card=new GlobalCardController();
        if (count($card->getCookie())==0){
            return redirect(route('card'));
        }

        return $next($request);
    }
}
