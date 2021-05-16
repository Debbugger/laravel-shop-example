<?php

namespace App\Modules\AdminManagement\Http\Controllers;

use Caffeinated\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    public function __invoke()
    {
        foreach (($modules = Module::sortBy('order')) as $key => $module) {
            if (!isset($module['Management']) || $module['Management'] == 0 || Module::isDisabled($module['slug'])
//                || !isset($module['roles']) || !Auth::user()->hasAnyRole(explode('|', $module['roles']))
            ) {
                unset($modules[$key]);
            }
        }

        return view('adminManagement::management', ['modules' => $modules]);
    }
}
