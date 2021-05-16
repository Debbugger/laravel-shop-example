<?php

namespace App\Modules\AdminDiscount\Http\Controllers;

use App\Category;
use App\Discount;
use App\Product;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    use SaveTrait;
    private $multiLanguageFields = ['description', 'short_description', 'name'];
    private $form = [
        'description'         => ['required', 'array'],
        'description.*'       => ['required', 'max' => '20000'],
        'name'                => ['required', 'array'],
        'name.*'              => ['required', 'max' => '255'],
        'short_description'   => ['required', 'array'],
        'short_description.*' => ['required', 'max' => '255'],
        'image'               => ['required'],
        'status'              => ['required'],
        'slug'                => ['required', 'max' => '128', 'unique' => 'discounts,slug',],
        'discont'             => ['nullable', 'numeric', 'max' => '999999999', 'min' => '1'],
        'type_discont'        => ['nullable'],
        'start_date'          => ['nullable'],
        'end_date'            => ['nullable'],
        'products'            => ['nullable']
    ];
    private $files = [
        'image' => ['path' => '/images/category', 'disk' => 'public']
    ];
    private $changeStatus = 0;

    public function updateResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'message' => 'Cкидка обновлена']);
    }

    public function createResponse($instance, $callbackResult)
    {
        if (!empty($this->products)) {
            Product::whereIn('id', $this->products)->update(['discont_id' => $instance->id]);
        }

        return response(['status' => 1, 'message' => 'Скидка создана','redirect'=>route('adminDiscount')]);
    }


    public function index()
    {
        return view('adminDiscount::index');
    }

    public function table()
    {
        return DataTables::eloquent(Discount::query())->only(['id', 'status', 'image', 'name', 'edit'])->editColumn('edit', function (Discount $item) {
            return '<a href="' . route('adminDiscountEdit', $item->id) . '" class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit"  ></a>
                <a  class="fas  fa-trash delete get-modal mr-2" data-toggle="modal" data-target="#delete-modal"   > </a>
                <a  class="fas fa-globe get-modal get-seo-modal seo-modal" data-toggle="modal" data-target="#seo-modal"   > </a>';
        })->editColumn('status', function (Discount $item) {
            if ($item->status == 1) {
                return '<i data-id="' . $item->id . '" class="far fa-2x fa-check-circle show-icon changeStatus"></i>';
            }

            return '<i data-id="' . $item->id . '" class="fas fa-2x fa-ban unshow-icon changeStatus"></i>';
        })->editColumn('name', function (Discount $item) {
            return parseMultiLanguageString($item->name ?? null, LaravelLocalization:: getCurrentLocale());
        })->editColumn('image', function (Discount $item) {
            return '<div class="hover-img"   data-type="table"><img   class="edit-img" src="' . asset($item->image) . '" data-type="table">
                        <label  class="uploadbutton loader-file"  data-type="table">
                            <i  class="fa fa-file-image-o" aria-hidden="true"></i>    
                        </label></div>';
        })->filter(function ($query) {
            if (request()->has('search')) {
                $query->whereRaw(' lower(JSON_EXTRACT(name, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower(request('search')['value']) . '%"');
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
        $item = Discount::findOrFail($request->input('id'));
        $item->status = !$item->status;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->status, 'id' => $item->id]);
    }


    public function create(Request $request)
    {
        if ($request->ajax()) {
            $this->products = $request->input('products');
            if ((!empty($request->input('type_discont'))) && (!empty($request->input('change_discont'))) && (!empty($request->input('products')))) {
                Product::whereIn('id', $request->input('products'))->update(['start_date' => $request->input('start_date'), 'end_date' => $request->input('end_date'), 'discont' => $request->input('discont'), 'type_discont' => $request->input('type_discont')]);
            }

            return $this->save(Discount::class);
        }

        return view('adminDiscount::create')->with(['categories' => Category::with('products')->get()]);
    }

    public function delete(Request $request)
    {
        $discount=Discount::findOrFail($request->input('delete'));
        Product::whereIn('id', $discount->products)->update(['discont_id'=>null]);
        $discount->delete();
        return response(['status' => 1, 'message' => 'Cкидка удалена']);
    }

    public function edit($id, Request $request)
    {
        if ($request->ajax()) {
            $this->form['image'] = ['nullable', 'image', 'max' => '2048'];
            $this->form['slug'] = ['nullable', 'max' => '128'];
            $elem = Discount::findOrFail($id);
            $this->form['slug'] = ['nullable', 'max' => '128', 'unique' => Rule::unique('discounts', 'slug')->ignore($id)];

            if ((!empty($request->input('type_discont'))) && (!empty($request->input('change_discont'))) && (!empty($request->input('products')))) {
                Product::whereIn('id', $request->input('products'))->update(['start_date' => $request->input('start_date'), 'end_date' => $request->input('end_date'), 'discont' => $request->input('discont'), 'discont_id' => $id, 'type_discont' => $request->input('type_discont')]);
            }

            return $this->save($elem);
        }

        return view('adminDiscount::edit')->with(['item' => Discount::findOrFail($id), 'id' => $id, 'categories' => Category::with(['products'=>function($q) use ($id){
            $q->whereNull('discont_id')->orWhere('discont_id',$id);
        }])->get()]);
    }

    public function image(Request $request)
    {
        $this->form = [
            'image' => ['required']
        ];

        return $this->save(Discount::findOrFail($request->input('id')));
    }

    public function getSeoModal(Request $request)
    {
        if ($request->input('id')) {
            return response(view('adminDiscount::modal-seo')->with(['item' => Discount::findOrFail($request->input('id'))])->render());
        }

        return response(['status' => 1]);
    }

    public function changeSeo(Request $request)
    {
        $item = Discount::whereId($request->input('id'))->firstOrFail();
        $this->form = [
            'slug'               => ['required', 'max' => '255'],
            'meta_title'         => ['required', 'array', 'max' => '3'],
            'meta_title.*'       => ['required', 'max' => '64'],
            'meta_keywords'      => ['required', 'array', 'max' => '3'],
            'meta_keywords.*'    => ['required', 'max' => '2000'],
            'meta_description'   => ['required', 'array', 'max' => '3'],
            'meta_description.*' => ['required', 'max' => '10000'],
        ];
        $this->multiLanguageFields = [
            'meta_title',
            'meta_keywords',
            'meta_description'
        ];

        return $this->save($item);
    }

}
