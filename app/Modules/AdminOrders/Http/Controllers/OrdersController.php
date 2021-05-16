<?php

namespace App\Modules\AdminOrders\Http\Controllers;

use App\Order;
use App\OrderProduct;
use App\Stock;
use App\Traits\SaveTrait;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OrdersController extends Controller
{
    use SaveTrait;
    private $form = [
        'status' => ['required'],
    ];

    public function index()
    {
        return view('adminOrders::index');
    }

    public function table()
    {
        return DataTables::eloquent(Order::with('user'))->only(['id', 'user', 'status', 'created_at', 'updated_at', 'edit'])->editColumn('edit', function (Order $item) {
            return '<a  class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>';
        })->editColumn('status', function (Order $item) {
            if ($item->status == 1) {
                return trans('profile.home-status-ready');
            }
            if ($item->status == 2) {
                return trans('profile.home-status-lost');
            }
            if ($item->status == 3) {
                return trans('profile.home-status-finish');
            }
        })->editColumn('created_at', function (Order $item) {
            return $item->created_at->format('d.m.y H:i');
        })->editColumn('updated_at', function (Order $item) {
            if ($item->created_at != $item->updated_at) {
                return $item->updated_at->format('d.m.y H:i');
            } else {
                return '-';
            }
        })->editColumn('user', function (Order $item) {
            return $item->user->name;
        })->setRowAttr([
            'data-id' => function ($item) {
                return $item->id;
            },
        ])->rawColumns(['edit', 'user', 'status', 'updated_at', 'created_at'])->toJson();
    }

    public function create()
    {
        return $this->save(Order::class);
    }

    public function delete(Request $request)
    {
        Order::findOrFail($request->input('delete'))->delete();

        return response(['status' => 1, 'message' => 'Характеристика удалена']);
    }

    public function edit(Request $request)
    {
        $elem = Order::findOrFail($request->input('id'));
        if ($request->input('status') == 3) {
            foreach (OrderProduct::where('order_id', $request->input('id'))->get() as $orderProduct) {
                Stock::create(['product_id' => $orderProduct->product_id, 'type' => 2, 'count' => $orderProduct->count, 'comment' => 'Отправка заказа #' . $elem->id]);
            }
        }
        if ($request->input('status') != 3) {
            foreach (OrderProduct::where('order_id', $request->input('id'))->get() as $orderProduct) {
                Stock::where(['comment' => 'Отправка заказа #' . $elem->id])->delete();
            }
        }

        return $this->save($elem);
    }

    public function getModal(Request $request)
    {
        if ($request->input('id') > 0) {
            $item = Order::findOrFail($request->input('id'));
            $orderProducts = OrderProduct::with('product')->where('order_id', $request->input('id'))->get();

            return response(view('adminOrders::modal-edit')->with(['item' => $item, 'orderProducts' => $orderProducts])->render());
        }

        return response(view('adminOrders::modal-add')->render());
    }
}
