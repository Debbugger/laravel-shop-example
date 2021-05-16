<?php

namespace App\Modules\AdminManagementCategory\Http\Controllers;

use App\Category;
use App\CategorySpecification;
use App\Http\Controllers\GlobalCategoryController;
use App\Modules\Card\Http\Controllers\CardController;
use App\Product;
use App\Specification;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use SaveTrait;
    private $multiLanguageFields = ['name', 'description'];
    private $form = [
        'name'           => ['required', 'array'],
        'name.*'         => ['required', 'max' => '255'],
        'description'    => ['required', 'array'],
        'description.*'  => ['nullable', 'max' => '20000'],
        'image'          => ['required', 'max' => '2048'],
        'specifications' => ['nullable'],
        'status'         => ['nullable'],
        'parent_id'      => ['nullable']

    ];
    private $files = [
        'image' => ['path' => '/images/category', 'disk' => 'public']
    ];

    public function updateResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'message' => 'Категория обновлена']);
    }

    public function index()
    {
        $specifications = Specification::all();


        return view('adminManagementCategory::index', ['specifications' => $specifications]);
    }

    public function image(Request $request)
    {
        $this->form = [
            'image' => ['required', 'max' => '2048']
        ];

        return $this->save(Category::findOrFail($request->input('id')));
    }

    public function changeShow(Request $request)
    {
        $item = Category::findOrFail($request->input('id'));
        $item->status = !$item->status;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->status, 'id' => $item->id]);
    }
    function add($parent_id,$pref) {
        $categoryToAdd=$this->categories->where('parent_id',$parent_id);
        foreach ($categoryToAdd as $category) {
            $category->depth=$pref.$category->id;
            $this->collectCategory->push($category);
            $this->add($category->id,$pref.$category->id.' - ');
        }
    }

    public function table()
    {
         $this->categories=Category::orderBy('parent_id')->get();
        $this->collectCategory=new Collection();
        $this->add(null,'');
        return DataTables::of($this->collectCategory)->only(['id', 'status', 'image', 'name', 'description', 'edit'])->editColumn('id', function (Category $item) {
            return $item->depth;
        })->editColumn('status', function (Category $item) {
            if ($item->status == 1) {
                return '<i data-id="' . $item->id . '" class="far fa-2x fa-check-circle show-icon changeStatus"></i>';
            }
            return '<i data-id="' . $item->id . '" class="fas fa-2x fa-ban unshow-icon changeStatus"></i>';
        })->editColumn('edit', function (Category $item) {
            return '<a  class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>
                <a  class="fas mr-2  fa-trash delete get-modal" data-toggle="modal" data-target="#delete-modal"   > </a>
                <a  class="fas fa-globe get-modal get-seo-modal seo-modal" data-toggle="modal" data-target="#seo-modal"   > </a>';
        })->editColumn('image', function (Category $item) {
            return '<div class="hover-img"   data-type="table"><img   class="edit-img" src="' . asset($item->image) . '" data-type="table">
                        <label  class="uploadbutton loader-file"  data-type="table">
                            <i  class="fa fa-file-image-o" aria-hidden="true"></i>    
                        </label></div>';
        })->editColumn('name', function (Category $item) {
            return parseMultiLanguageString($item->name ?? null, app()->getLocale());
        })->editColumn('description', function (Category $item) {
            if (strlen(parseMultiLanguageString($item->description ?? null, app()->getLocale())) > 100) {
                return mb_substr(parseMultiLanguageString($item->description ?? null, app()->getLocale()), 0, 100) . '...';
            } else {
                return parseMultiLanguageString($item->description ?? null, app()->getLocale());
            }
        })/*->filter(function ($query) {
            if (request()->has('search')) {
                $query->whereRaw(' lower(JSON_EXTRACT(name, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower(request('search')['value']) . '%"');
                $query->orWhereRaw(' lower(JSON_EXTRACT(description, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower(request('search')['value']) . '%"');
            }
        })*/
            ->setRowAttr([
                'data-id'   => function ($item) {
                    return $item->id;
                },
                'data-show' => function ($item) {
                    return $item->show;
                },
            ])->rawColumns(['id','status', 'edit', 'image'])->toJson();
    }

    public function create(Request $request)
    {
        return $this->save(Category::class);
    }

    public function delete(Request $request)
    {

        if (!Product::where('category_id', $request->input('delete'))->first()) {
            Category::findOrFail($request->input('delete'))->delete();

            return response(['status' => 1, 'message' => 'Категория удалена']);
        } else {
            return response(['status' => 0, 'message' => 'Существуют товары с данной категорией']);
        }

    }

    public function edit(Request $request)
    {
        $this->form['image'] = ['nullable', 'max' => '2048'];
        $elem = Category::findOrFail($request->input('id'));
        CategorySpecification::where('category_id', $elem->id)->delete();
        if ($elem->id==$request->input('parent_id')){
            return response(['status'=>0,'message'=>'Главная категория не может совпадать с текущей']);
        }
        return $this->save($elem);
    }

    public function getModal(Request $request)
    {
        $specifications = Specification::all();

        if ($request->input('id') > 0) {
            $categories = Category::where('parent_id', '!=', $request->input('id'))->orWhereNull('parent_id')->get();
            $category = Category::findOrFail($request->input('id'));
            return response(view('adminManagementCategory::modal-edit')->with(['category' => $category, 'specifications' => $specifications, 'categories' => $categories])->render());
        }
        $categories = Category::all();

        return response(view('adminManagementCategory::modal-add')->with(['specifications' => $specifications, 'categories' => $categories])->render());
    }

    public function getSeoModal(Request $request)
    {
        if ($request->input('id')) {
            return response(view('adminManagementCategory::modal-seo')->with(['item' => Category::findOrFail($request->input('id'))])->render());
        }

        return response(['status' => 1]);
    }

    public function changeSeo(Request $request)
    {
        $category = Category::whereId($request->input('id'))->firstOrFail();
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
        $this->form['slug'] = ['required', 'unique' => Rule::unique('categories')->ignore($request->input('id')), 'max' => '128'];

        return $this->save($category);
    }

}
