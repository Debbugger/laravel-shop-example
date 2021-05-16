<?php

namespace App\Modules\AdminManagementSpecification\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Specification;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class SpecificationController extends Controller
{
    use SaveTrait;
    private $multiLanguageFields = ['name'];
    private $form = [
        'name'   => ['required', 'array'],
        'name.*' => ['required','max' => '255'],
        'filter' => ['required'],
    ];

    public function index()
    {
        return view('adminManagementSpecification::index');
    }

    public function table()
    {
        return DataTables::eloquent(Specification::query())->only(['id', 'name', 'filter', 'edit'])->editColumn('edit', function (Specification $item) {
            return '<a  class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>
                    <a  class="fas  fa-trash delete get-modal" data-toggle="modal" data-target="#delete-modal"   > </a>';
        })->editColumn('service', function (Specification $item) {
            return 0;
        })->editColumn('name', function (Specification $item) {
            return parseMultiLanguageString($item->name ?? null, LaravelLocalization :: getCurrentLocale ());
        })->setRowAttr([
            'data-id' => function ($item) {
                return $item->id;
            },
        ])->filter(function ($query) {
            if (request()->has('search')) {
                $query->whereRaw(' lower(JSON_EXTRACT(name, "$.'.app()->getLocale().'")) like "%'.mb_strtolower(request('search')['value']).'%"');
            }
        })->rawColumns(['edit', 'filter'])->toJson();
    }

    public function create()
    {
        return $this->save(Specification::class);
    }

    public function delete(Request $request)
    {
        if (empty($spec = Specification::findOrFail($request->input('delete')))) {
            return response(['status' => 0, 'message' => 'Характеристика не найдена']);
        };
        $spec->delete();

        return response(['status' => 1, 'message' => 'Характеристика удалена']);
    }

    public function edit(Request $request)
    {
        if (empty($spec = Specification::findOrFail($request->input('id')))) {
            return response(['status' => 0, 'message' => 'Характеристика не найдена']);
        };

        return $this->save($spec);
    }

    public function getModal(Request $request)
    {

        return response(view('adminManagementSpecification::' . ($request->input('id') > 0 ? 'modal-edit' : 'modal-add'), ['item' => ($request->input('id') > 0) ? Specification::findOrFail($request->input('id')) : null])->render());
    }
    public function changeShow(Request $request)
    {
        $item = Specification::findOrFail($request->input('id'));
        $item->filter = !$item->filter;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->filter, 'id' => $item->id]);
    }

}
