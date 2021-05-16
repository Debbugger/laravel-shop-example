<?php

namespace App\Modules\AdminSettingsAdvantage\Http\Controllers;

use App\Advantage;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class AdvantageController extends Controller
{
    use SaveTrait;
    private $multiLanguageFields = ['description'];
    private $form = [
        'description'   => ['required', 'array'],
        'description.*' => ['required', 'max' => '255'],
        'image'         => ['required', 'max' => '2048'],
        'status'        => ['required']
    ];
    private $files = [
        'image' => ['path' => '/images/category', 'disk' => 'public']
    ];
    private $changeStatus = 0;

    public function updateResponse($instance, $callbackResult)
    {
        if ($this->changeStatus) {
            return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $instance->status, 'id' => $instance->id]);
        }

        return response(['status' => 1, 'message' => 'Преимущество обновлено']);
    }


    public function index()
    {
        return view('adminSettingsAdvantage::index');
    }

    public function table()
    {
        return DataTables::eloquent(Advantage::query())->only(['id', 'status', 'image', 'description', 'edit'])->editColumn('edit', function (Advantage $item) {
            return '<a  class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>
                <a  class="fas  fa-trash delete get-modal" data-toggle="modal" data-target="#delete-modal"   > </a>';
        })->editColumn('status', function (Advantage $item) {
            if ($item->status == 1) {
                return '<i data-id="' . $item->id . '" class= "changeStatus far fa-2x fa-check-circle show-icon"></i>';
            }

            return '<i data-id="' . $item->id . '" class="changeStatus fas fa-2x fa-ban unshow-icon"></i>';
        })->editColumn('description', function (Advantage $item) {
            return parseMultiLanguageString($item->description ?? null, LaravelLocalization:: getCurrentLocale());
        })->editColumn('image', function (Advantage $item) {
            return '<div class="hover-img"   data-type="table"><img   class="edit-img" src="' . asset($item->image) . '" data-type="table">
                        <label  class="uploadbutton loader-file"  data-type="table">
                            <i  class="fa fa-file-image-o" aria-hidden="true"></i>    
                        </label></div>';
        })->filter(function ($query) {
            if (request()->has('search')) {
                $query->whereRaw(' lower(JSON_EXTRACT(description, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower(request('search')['value']) . '%"');
            }
        })->setRowAttr([
            'data-id'   => function ($item) {
                return $item->id;
            },
            'data-show' => function ($item) {
                return $item->status;
            },
        ])->rawColumns(['edit', 'image', 'status'])->toJson();
    }

    public function changeShow(Request $request)
    {
        $item = Advantage::findOrFail($request->input('id'));
        $item->status = !$item->status;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->status, 'id' => $item->id]);
    }


    public function create()
    {
        return $this->save(Advantage::class);
    }

    public function delete(Request $request)
    {
        Advantage::findOrFail($request->input('delete'))->delete();

        return response(['status' => 1, 'message' => 'Характеристика удалена']);
    }

    public function edit(Request $request)
    {
        $this->form['image'] = ['nullable', 'image', 'max' => '2048'];
        $elem = Advantage::findOrFail($request->input('id'));

        return $this->save($elem);
    }

    public function image(Request $request)
    {
        $this->form = [
            'image' => ['required', 'max' => '2048']
        ];

        return $this->save(Advantage::findOrFail($request->input('id')));
    }

    public function getModal(Request $request)
    {
        if ($request->input('id') > 0) {
            $item = Advantage::findOrFail($request->input('id'));

            return response(view('adminSettingsAdvantage::modal-edit')->with(['item' => $item])->render());
        }

        return response(view('adminSettingsAdvantage::modal-add')->render());
    }
}
