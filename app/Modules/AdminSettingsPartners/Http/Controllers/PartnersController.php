<?php

namespace App\Modules\AdminSettingsPartners\Http\Controllers;

use App\Partner;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PartnersController extends Controller
{
    use SaveTrait;
    private $form = [
        'link'   => ['required', 'max' => '255'],
        'image'  => ['required', 'max' => '255'],
        'status' => ['required']
    ];
    private $files = [
        'image' => ['path' => '/images/partners', 'disk' => 'public']
    ];

    public function image(Request $request)
    {
        $this->form = [
            'image' => ['required']
        ];

        return $this->save(Partner::findOrFail($request->input('id')));
    }

    public function index()
    {
        return view('adminSettingsPartners::index');
    }

    public function table()
    {
        return DataTables::eloquent(Partner::query())->only(['id', 'status', 'image', 'link', 'edit'])->editColumn('edit', function (Partner $item) {
            return '<a  class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>
                    <a  class="fas  fa-trash delete get-modal" data-toggle="modal" data-target="#delete-modal"   > </a>';
        })->editColumn('status', function (Partner $item) {
            return $item->status ? '<i data-id="' . $item->id . '" class="far fa-2x fa-check-circle show-icon changeStatus"></i>' : '<i data-id="' . $item->id . '" class="fas fa-2x fa-ban unshow-icon changeStatus"></i>';
        })->editColumn('image', function (Partner $item) {
            return '<div class="hover-img" data-type="table"><img class="edit-img" src="' . asset($item->image) . '" data-type="table"><label class="uploadbutton loader-file" data-type="table">
                         <i class="fa fa-file-image-o" aria-hidden="true"></i>
                    </label></div>';
        })->editColumn('link', function (Partner $item) {
            return '<a href="' . $item->link . '" target="_blank">Ссылка парнера</a>';
        })->setRowAttr([
            'data-id' => function ($item) {
                return $item->id;
            },
        ])->rawColumns(['edit', 'status', 'image', 'link'])->toJson();
    }

    public function create()
    {
        return $this->save(Partner::class);
    }

    public function delete(Request $request)
    {
        if (empty($spec = Partner::findOrFail($request->input('delete')))) {
            return response(['status' => 0, 'message' => 'Партнер не найден']);
        };
        $spec->delete();

        return response(['status' => 1, 'message' => 'Парнер удален']);
    }

    public function edit(Request $request)
    {
        if (empty($spec = Partner::findOrFail($request->input('id')))) {
            return response(['status' => 0, 'message' => 'Партнер не найден']);
        };
        $this->form['image'] = ['nullable', 'image', 'max' => '2048'];

        return $this->save($spec);
    }

    public function getModal(Request $request)
    {
        if ($request->input('id') > 0) {
            $item = Partner::find($request->input('id'));
        }

        return response(view('adminSettingsPartners::' . ($request->input('id') > 0 ? 'modal-edit' : 'modal-add'), ['item' => $item ?? null])->render());
    }

    public function changeShow(Request $request)
    {
        $item = Partner::findOrFail($request->input('id'));
        $item->status = !$item->status;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->status, 'id' => $item->id]);
    }
}
