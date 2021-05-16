<?php

namespace App\Modules\AdminManagementStock\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\Stock;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    use SaveTrait;
    private $form = [
        'type'       => ['required'],
        'count'      => ['required','integer','min'=>'1','max'=>'99999999'],
        'product_id' => ['required'],
        'comment'    => ['nullable','max' => '20000']
    ];

    public function index()
    {
        return view('adminManagementStock::index');
    }

    public function edit(Request $request)
    {
        if ($request->input('type') == 1 || Stock::countProductLeft($request->product_id) >= $request->count) {
            return $this->save(Stock::findOrFail($request->input('id')));
        }

        return response(['status' => 0, 'message' => 'На скаладе нету столько товаров']);
    }

    public function create(Request $request)
    {
        if ($request->input('type') == 1 || Stock::countProductLeft($request->product_id) >= $request->count) {
            return $this->save(Stock::class);
        }

        return response(['status' => 0, 'message' => 'На скаладе нету столько товаров']);
    }

    public function delete(Request $request)
    {
        if (empty($stock = Stock::findOrFail($request->input('delete')))) {
            return response(['status' => 0, 'message' => 'Запись не найдено']);
        }
        $stock->delete();

        return response(['status' => 1, 'message' => 'Запись удалена']);
    }

    public function getModal(Request $request)
    {
        return response(view('adminManagementStock::' . ($request->input('id') > 0 ? 'modal-edit' : 'modal-add'), [
            'item'     => ($request->input('id') > 0) ? Stock::findOrFail($request->input('id')) : null,
            'products' => Product::all()
        ])->render());
    }

    public function table()
    {
        return DataTables::eloquent(Stock::with('product'))->only(['id', 'name', 'type', 'count', 'product', 'comment', /*'edit'*/])/*->editColumn('edit', function (Stock $item) {
            return '<a class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>
                    <a class="fas  fa-trash delete get-modal" data-toggle="modal" data-target="#delete-modal"> </a>';
        })*/->editColumn('type', function (Stock $item) {
            return $item->type == 1 ? 'Получение' : 'Отправка';
        })->editColumn('product', function (Stock $item) {
            return parseMultiLanguageString($item->product->name ?? null, LaravelLocalization :: getCurrentLocale ());
        })->filter(function ($query) {
                if (request('search')['value']!=null) {
                    $query->where('comment', 'like', '%' . request('search')['value'] . '%');
                    $query->OrWhereHas('product', function ($q) {
                        $q->whereRaw('lower(JSON_EXTRACT(name, "$.'.app()->getLocale().'")) like "%'.mb_strtolower(request('search')['value']).'%"');
                    });
                }
        })->setRowAttr([
            'data-id' => function ($item) {
                return $item->id;
            },
        ])->rawColumns([/*'edit',*/ 'type', 'product'])->toJson();
    }


}
