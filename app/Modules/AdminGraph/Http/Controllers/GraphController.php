<?php

namespace App\Modules\AdminGraph\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Stock;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function mounth(Request $request)
    {
        $days = array_values(Stock::graphMounth($request->input('mounth')));
        $colDays = count($days);

        return view('adminGraph::graph')->with(['days' => json_encode($days), 'currM' => intval(date('m')), 'colDays' => $colDays])->render();
    }

}
