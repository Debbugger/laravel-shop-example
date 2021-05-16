<?php

namespace App\Modules\AdminSettingsReviews\Http\Controllers;

use App\Review;
use App\Traits\SaveTrait;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ReviewsController extends Controller
{
    use SaveTrait;
    private $form = [
        'user_id' => ['required'],
        'value'   => ['required', 'max' => '255'],
        'status'  => ['required']
    ];


    public function image(Request $request)
    {
        $this->form = [
            'image' => ['required']
        ];

        return $this->save(Review::findOrFail($request->input('id')));
    }

    public function index()
    {
        return view('adminSettingsReviews::index');
    }

    public function table()
    {
        return DataTables::eloquent(Review::with('user'))->only(['id', 'status', 'user', 'value', 'edit'])->editColumn('edit', function (Review $item) {
            return '<a  class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>
                    <a  class="fas  fa-trash delete get-modal" data-toggle="modal" data-target="#delete-modal"   > </a>';
        })->editColumn('status', function (Review $item) {
            return $item->status ? '<i data-id="' . $item->id . '" class="far fa-2x fa-check-circle show-icon changeStatus"></i>' : '<i data-id="' . $item->id . '" class="fas fa-2x fa-ban unshow-icon changeStatus"></i>';
        })->editColumn('user', function (Review $item) {
            return $item->user->name;
        })->editColumn('value', function (Review $item) {
            return $item->value;
        })->setRowAttr([
            'data-id' => function ($item) {
                return $item->id;
            },
        ])->rawColumns(['edit', 'status', 'user'])->toJson();
    }


    public function delete(Request $request)
    {
        if (empty($spec = Review::findOrFail($request->input('delete')))) {
            return response(['status' => 0, 'message' => 'Отзыв не найден']);
        };
        $spec->delete();

        return response(['status' => 1, 'message' => 'Отзыв удален']);
    }

    public function edit(Request $request)
    {
        if (empty($spec = Review::findOrFail($request->input('id')))) {
        return response(['status' => 0, 'message' => 'Отзыв не найден']);
    };
        $this->form['image'] = ['nullable', 'image', 'max' => '2048'];

        return $this->save($spec);
    }

    public function getModal(Request $request)
    {
        return response(view('adminSettingsReviews::modal-edit', ['item' => Review::where('id', $request->input('id'))->firstOrFail(),'users'=>User::all()])->render());
    }

    public function changeShow(Request $request)
    {
        $item = Review::findOrFail($request->input('id'));
        $item->status = !$item->status;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->status, 'id' => $item->id]);
    }
}
