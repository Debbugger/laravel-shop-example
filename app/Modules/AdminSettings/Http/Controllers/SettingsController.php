<?php

namespace App\Modules\AdminSettings\Http\Controllers;

use Caffeinated\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __invoke()
    {
        foreach (($modules = Module::sortBy('order')) as $key => $module) {
            if (!isset($module['Settings']) || $module['Settings'] == 0 || Module::isDisabled($module['slug'])
//                || !isset($module['roles']) || !Auth::user()->hasAnyRole(explode('|', $module['roles']))
            ) {
                unset($modules[$key]);
            }
        }

        return view('adminSettings::settings', ['modules' => $modules]);
    }
}
