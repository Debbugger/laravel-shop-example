<?php

namespace App\Modules\AdminManagementProduct\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Image;
use App\ImageProduct;
use App\Product;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use SaveTrait;
    private $NeedRedirect = false;
    private $ImagesEdit = false;
    private $multiLanguageFields = ['name', 'description'];
    private $form = [
        'name'          => ['required', 'array'],
        'type'          => ['required', 'numeric', 'max' => '9'],
        'name.*'        => ['required', 'max' => '255'],
        'description'   => ['nullable', 'array'],
        'description.*' => ['nullable', 'max' => '20000'],
        'image'         => ['required', 'max' => '2048'],
        'cost'          => ['required', 'numeric', 'max' => '99999999999'],
        'cost_to'       => ['nullable', 'numeric', 'max' => '99999999999'],
        'category_id'   => ['required', 'numeric', 'max' => '9999999999'],
        'slug'          => ['required', 'unique:products', 'max' => '255'],
        'images'        => ['nullable'],
        'start_date'    => ['nullable', 'date'],
        'end_date'      => ['nullable', 'date'],
        'discont'       => ['nullable', 'numeric', 'max' => '9999999999'],
        'type_discont'  => ['required', 'numeric', 'max' => '99']

    ];
    private $files = ['image' => ['path' => '/images/product', 'disk' => 'public']];

    public function createResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'message' => 'Товар успешно создан', 'redirect' => route('adminManagementProductValuesCreate', $instance->id)]);
    }

    public function updateResponse($instance, $callbackResult)
    {
        if ($this->NeedRedirect) {
            return response(['status' => 1, 'message' => 'Товар обновлен', 'redirect' => route('adminManagementProducts')]);
        }
        if ($this->ImagesEdit) {
            $images = $instance->images()->get();

            return response(view('adminManagementProduct::images')->with(['images' => $images, 'id' => $instance->id])->render());
        }

        return response(['status' => 1, 'message' => 'Товар обновлен']);
    }

    public function index()
    {
        return view('adminManagementProduct::index');
    }

    public function image(Request $request)
    {
        $this->form = ['image' => ['required', 'max' => '2048']];

        return $this->save(Product::findOrFail($request->input('id')));
    }

    public function category(Request $request, $id)
    {
        $this->form = ['category_id' => ['required', 'exists' => 'categories,id']];

        return $this->save(Product::findOrFail($id));
    }

    public function images(Request $request, $id)
    {
        $this->form = ['images' => ['nullable']];
        $this->ImagesEdit = true;

        return $this->save(Product::findOrFail($id));
    }

    public function imagesDelete(Request $request, $id)
    {
        $images = ImageProduct::where('product_id', $id)->where('image_id', $request->input('id'));
        if ($images->count()) {
            $images->delete();
        }
        $image = Image::findOrFail($request->input('id'));
        if ($image) {
            $image->delete();
        }

        return response(['status' => 1, 'message' => 'Картинка удалена']);
    }

    public function table()
    {
        return DataTables::eloquent(Product::with('category'))->only(['id', 'image', 'name', 'category', 'cost', 'slug', 'edit'])->editColumn('edit', function (Product $item) {
            return '<a  href="' . route('adminManagementProductEdit', $item->id) . '" class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" ></a>
                    <a  class="fas  fa-trash delete mr-2 get-modal" data-toggle="modal" data-target="#delete-modal"   > </a>
                    <a  class="fas fa-globe get-modal get-seo-modal seo-modal" data-toggle="modal" data-target="#seo-modal"   > </a>';

        })->editColumn('image', function (Product $item) {
            return '<div class="hover-img" data-type="table"><img class="edit-img" src="' . asset($item->image) . '" data-type="table"><label class="uploadbutton loader-file" data-type="table">
                         <i class="fa fa-file-image-o" aria-hidden="true"></i>
                    </label></div>';
        })->editColumn('category', function (Product $item) {
            return (!empty($item->category)) ? parseMultiLanguageString($item->category->name ?? [], LaravelLocalization:: getCurrentLocale()) : 'отсутсвует категория';
        })->editColumn('name', function (Product $item) {
            return parseMultiLanguageString($item->name ?? [], LaravelLocalization:: getCurrentLocale());
        })->setRowAttr([
            'data-id' => function ($item) {
                return $item->id;
            }
        ])->filter(function ($query) {
            if (request()->has('search')) {
                $query->whereRaw('lower(JSON_EXTRACT(name, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower(request('search')['value']) . '%"');
                $query->OrWhereHas('category', function ($q) {
                    $q->whereRaw('lower(JSON_EXTRACT(name, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower(request('search')['value']) . '%"');
                });
            }
        })->rawColumns(['edit', 'image', 'category'])->toJson();
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            return $this->save(Product::class);
        }
        $parents = Category::whereNotNull('parent_id')->select('id')->get();
        $notShow = [];
        foreach ($parents as $val) {
            $notShow[] = $val->id;
        }
        return view('adminManagementProduct::create', ['category' => Category::all(), 'notShow' => $notShow]);
    }

    public function delete(Request $request)
    {
        Product::findOrFail($request->input('delete'))->delete();

        return response(['status' => 1, 'message' => 'Товар удален']);
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($request->ajax()) {
            $this->form['slug'] = ['required', 'unique' => Rule::unique('products')->ignore($id), 'max' => '128'];
            $this->form['image'] = ['nullable', 'image', 'max' => '2048'];

            return $this->save($product);
        }
        /*$parents = Category::whereNotNull('parent_id')->select('id')->get();*/
        $notShow = [];
      /*  foreach ($parents as $val) {
            $notShow[] = $val->id;
        }*/
        return view('adminManagementProduct::edit', ['category' => Category::all(), 'product' => $product, 'id' => $id, 'images' => $product->images()->get(), 'notShow' => $notShow]);
    }

    public function getSeoModal(Request $request)
    {
        if ($request->input('id')) {
            return response(view('adminManagementProduct::modal-seo')->with(['item' => Product::findOrFail($request->input('id'))])->render());
        }

        return response(['status' => 1]);
    }

    public function changeSeo(Request $request)
    {
        $item = Product::whereId($request->input('id'))->firstOrFail();

        $this->form = [
            'slug'               => ['required', 'max' => '255'],
            'meta_title'         => ['required', 'array', 'max' => '3'],
            'meta_title.*'       => ['required', 'max' => '64'],
            'meta_keywords'      => ['required', 'array', 'max' => '3'],
            'meta_keywords.*'    => ['required', 'max' => '2000'],
            'meta_description'   => ['required', 'array', 'max' => '3'],
            'meta_description.*' => ['required', 'max' => '10000'],
        ];
        $this->form['slug'] = ['required', 'unique' => Rule::unique('products')->ignore($request->input('id')), 'max' => '128'];
        $this->multiLanguageFields = [
            'meta_title',
            'meta_keywords',
            'meta_description'
        ];

        return $this->save($item);
    }

}
