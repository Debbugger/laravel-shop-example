<?php

namespace App\Modules\AdminSeo\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Seo;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SeoController extends Controller
{
    use SaveTrait;
    protected $multiLanguageFields = ['meta_title', 'meta_description', 'meta_keywords'];
    protected $form = [
        'address'            => ['required', 'unique' => 'seo,address', 'max' => '255'],
        'meta_title'         => ['required', 'array', 'max' => '3'],
        'meta_title.*'       => ['required', 'max' => '64'],
        'meta_keywords'      => ['required', 'array', 'max' => '3'],
        'meta_keywords.*'    => ['required', 'max' => '2000'],
        'meta_description'   => ['required', 'array', 'max' => '3'],
        'meta_description.*' => ['required', 'max' => '10000'],
    ];

    public function deleteItem(Request $request)
    {
        if (empty($seo = Seo::findOrFail($request->id))) {
            return response(['status' => 0, 'message' => 'Запись не найдено']);
        }
        $seo->delete();

        return response(['status' => 1, 'message' => 'Запись удалена']);
    }

    public function seo(Request $request)
    {
        Cache::forget(str_replace('/', '-', $request->input('address')));
        if ($request->isMethod('post')) {
            if ($request->id) {
                $this->form['address']['unique'] = Rule::unique('seo')->ignore($request->id);
            }

            return $this->save(Seo::findOrFail($request->id) ?? Seo::class);
        }

        return DataTables::eloquent(Seo::orderByDesc('id'))->only(['id', 'meta_title', 'meta_description', 'meta_keywords', 'address', 'updated_at', 'action'])
            ->editColumn('address', function ($item) {
                return '<div class="text-truncate" style="max-width: 100px">' . $item->address . '</div>';
            })->editColumn('meta_title', function ($item) {
                return '<div class="text-truncate" style="max-width: 100px">' . parseMultiLanguageString($item->meta_title) . '</div>';
            })->editColumn('meta_description', function ($item) {
                return '<div class="text-truncate" style="max-width: 200px">' . parseMultiLanguageString($item->meta_description) . '</div>';
            })->editColumn('meta_keywords', function ($item) {
                return '<div class="text-truncate" style="max-width: 100px">' . parseMultiLanguageString($item->meta_keywords) . '</div>';
            })->addColumn('action', function ($item) {
                return '<a href="javascript:void(0)" class="show-modal mr-1" data-toggle="modal" data-target=".modal-item"  data-id="' . $item->id . '"><i class="fa fa-edit" style="font-size: 19px"></i></a>
                <a href="javascript:void(0)"  class="delete" data-id="' . $item->id . '"><i class="fas fa-trash text-primary" style="font-size: 18px"></i></a>';
            })->setRowClass('text -center')->editColumn('created_at', function ($item) {
                return $item->created_at->format('d.m.Y');
            })->editColumn('updated_at', function ($item) {
                return $item->updated_at->format('d.m.Y');
            })->setRowClass('text-center')->rawColumns(['meta_title', 'meta_description', 'meta_keywords', 'address', 'action'])->toJson();
    }

    public function all(Request $request)
    {
        if ($request->isMethod('post')) {
            return response(view('adminSeo::seo', ['item' => Seo::findOrFail($request->id)])->render());
        }

        return view('adminSeo::all');
    }
}
