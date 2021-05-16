<?php

namespace App\Modules\Products\Http\Controllers;

use App\Category;
use App\CategorySpecification;
use App\Favorite;
use App\Http\Controllers\GlobalCardController;
use App\Http\Controllers\GlobalFavoriteController;
use App\Product;
use App\ProductValue;
use App\Specification;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ProductsController extends Controller
{
    public function catalog(){
        $categories=Category::whereNull('parent_id')->where('status',1)->get();

        return view('modules.products.categories')->with(['name'=>'Каталог','categoriesIn'=>$categories]);
    }

    public function show(Request $request, $category, $slug)
    {
        $category = Category::where('slug', $category)->firstOrFail();
        $product = Product::where('slug', $slug)->with('images')->with('category')->firstOrFail();
        $specifications = $category->specifications;
        $values = ProductValue::where('product_id', $product->id)->get()->toArray();
        $selected = array_column($values, 'value_id');
        $noEmpty = array_column($values, 'specification_id');
        $likeProducts = Product::where('category_id', $category->id)->where('id', "!=", $product->id)->where('count', '>', 0)->with('category')->limit(5)->get();
        $globalCard = new GlobalCardController();
        $globalFavorite = new GlobalFavoriteController();

        return view('modules.products.product')->with([
            'specifications' => $specifications,
            'id'             => $product->id,
            'selected'       => $selected,
            'noEmpty'        => $noEmpty,
            'product'        => $product,
            'likeProducts'   => $likeProducts,
            'card'           => array_keys($globalCard->getCookie()),
            'favorites'      => array_column($globalFavorite->favorites(), 'product_id')
        ]);
    }


    public function index(Request $request)
    {
        $valuesSearcUrl = [];
        if (!empty($request->input('type'))) {
            $type = $request->input('type');
        } else {
            $type = 1;
        }

        $specification = $request->input('specification');


        for ($i = 1; $i <= 3; $i++) {
            $types[$i] = route('productSearch', ['specification' => $specification, 'type' => $i, 'to' => $request->input('to'), 'from' => $request->input('from'), 'search' => $request->input('search')]);
        }

        if ($type == 1) {
            $products = Product::orderBy('created_at', 'asc')->where('count', '>', 0);
        }
        if ($type == 2) {
            $products = Product::orderBy('cost', 'asc')->where('count', '>', 0);
        }
        if ($type == 3) {
            $products = Product::orderBy('cost', 'desc')->where('count', '>', 0);
        }
        if (!empty($request->input('from'))) {
            $products = $products->where('cost', '>=', intval($request->input('from')));
        }
        if (!empty($request->input('to'))) {
            $products = $products->where('cost', '<=', intval($request->input('to')));
        }
        if (!empty($specification)) {
            $products = $products->where(function ($q) use ($specification) {
                foreach ($specification as $key => $val) {
                    $q->whereHas('values', function ($q1) use ($val, $key) {
                        $q1->where('value_id', $val)->where('specification_id', $key);
                    });
                }
            });
        }

        $products = $products->with('category')->whereHas('category', function ($q) {
            $q->where('status', 1);
        })->whereRaw(' lower(JSON_EXTRACT(name, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower($request->input('search')) . '%"')->paginate(12);
        foreach (Specification::with('values')->get() as $spec) {
            $help = $specification;
            unset($help[$spec->id]);
            $valuesSearcUrl['sp_' . $spec->id] = route('productSearch', ['specification' => $help, 'type' => $type, 'to' => $request->input('to'), 'from' => $request->input('from'), 'search' => $request->input('search')]);
            foreach ($spec->values as $val) {
                $help = $specification;
                $help[$spec->id] = $val->id;
                $valuesSearcUrl[$val->id] = route('productSearch', ['specification' => $help, 'type' => $type, 'to' => $request->input('to'), 'from' => $request->input('from'), 'search' => $request->input('search')]);

            }
        }
        $specifications = Specification::with('values')->where('filter', 1)->get();
        $globalCard = new GlobalCardController();
        $globalFavorite = new GlobalFavoriteController();

        return view('modules.products.indexSearch')->with([
            'specifications'       => $specifications,
            'products'             => $products,
            'specificationsSearch' => $specification,
            'valuesSearcUrl'       => $valuesSearcUrl,
            'type'                 => $type,
            'types'                => $types,
            'clearUrl'             => route('productCategory', ['type' => $type, 'search' => $request->input('search')]),
            'card'                 => array_keys($globalCard->getCookie()),
            'favorites'            => array_column($globalFavorite->favorites(), 'product_id'),
            'search'               => $request->input('search'),
            'categories'           => Category::all(),
            'from'                 => $request->input('from'),
            'to'                   => $request->input('to')
        ]);

    }

    public function indexCategory($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories=Category::where('parent_id',$category->id)->where('status',1)->get();
        if ($categories->count()>0){
            return view('modules.products.categories')->with(['name'=>parseMultiLanguageString($category->name, app()->getLocale()),'categoriesIn'=>$categories]);
        }
        $valuesSearcUrl = [];
        if (!empty($request->input('type'))) {
            $type = $request->input('type');
        } else {
            $type = 1;
        }

        $specification = $request->input('specification');
        if (!empty($request->input('specificationInForm'))) {
            $specification = json_decode($request->input('specificationInForm'), true);
        }

        for ($i = 1; $i <= 3; $i++) {
            $types[$i] = route('productCategory', ['specification' => $specification, 'type' => $i, 'slug' => $slug, 'to' => $request->input('to'), 'from' => $request->input('from'), 'search' => $request->input('search')]);
        }

        if ($type == 1) {
            $products = Product::orderBy('created_at', 'asc')->where('count', '>', 0)->where('category_id', $category->id);
        }
        if ($type == 2) {
            $products = Product::orderBy('cost', 'asc')->where('count', '>', 0)->where('category_id', $category->id);
        }
        if ($type == 3) {
            $products = Product::orderBy('cost', 'desc')->where('count', '>', 0)->where('category_id', $category->id);
        }
        if (!empty($specification)) {
            $products = $products->where(function ($q) use ($specification) {
                foreach ($specification as $key => $val) {
                    $q->whereHas('values', function ($q1) use ($val, $key) {
                        $q1->where('value_id', $val)->where('specification_id', $key);
                    });
                }
            });
        }
        $allProducts=$products->get();
        $idProduct=[];
        foreach ($allProducts as $elem) {
            $idProduct[]=$elem->id;
        }
        $productValue=ProductValue::whereIn('product_id',$idProduct)->get();
        $valueIds=[];
        foreach ($productValue as $val){
            $valueIds[]=$val->value_id;
        }
        if (!empty($request->input('from'))) {
            $products = $products->where('cost', '>=', intval($request->input('from')));
        }
        if (!empty($request->input('to'))) {
            $products = $products->where('cost', '<=', intval($request->input('to')));
        }

        $products = $products->whereRaw(' lower(JSON_EXTRACT(name, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower($request->input('search')) . '%"')->paginate(12);
        $category_id = $category->id;
        $specifications = Specification::with([
            'values' => function ($q) use ($category_id) {
                $q->whereHas('category', function ($q1) use ($category_id) {
                    $q1->where('category_id', $category_id);
                });
            }
        ])->with('categories')->where('filter', 1)->whereHas('categories', function ($q) use ($category) {
            $q->where('categories.id', $category->id);
        })->get();
        foreach ($specifications as $spec) {
            $help = $specification;
            unset($help[$spec->id]);
            $valuesSearcUrl['sp_' . $spec->id] = route('productCategory', ['specification' => $help, 'type' => $type, 'slug' => $slug, 'to' => $request->input('to'), 'from' => $request->input('from'), 'search' => $request->input('search')]);
            foreach ($spec->values as $val) {
                $help = $specification;
                $help[$spec->id] = $val->id;
                $valuesSearcUrl[$val->id] = route('productCategory', ['specification' => $help, 'type' => $type, 'slug' => $slug, 'to' => $request->input('to'), 'from' => $request->input('from'), 'search' => $request->input('search')]);

            }
        }

        $globalCard = new GlobalCardController();
        $globalFavorite = new GlobalFavoriteController();

        return view('modules.products.index')->with([
            'specifications'       => $specifications,
            'products'             => $products,
            'specificationsSearch' => $specification,
            'valuesSearcUrl'       => $valuesSearcUrl,
            'type'                 => $type,
            'types'                => $types,
            'slug'                 => $slug,
            'clearUrl'             => route('productCategory', ['slug' => $slug, 'type' => $type]),
            'card'                 => array_keys($globalCard->getCookie()),
            'favorites'            => array_column($globalFavorite->favorites(), 'product_id'),
            'search'               => $request->input('search'),
            'category_id'          => $category->id,
            'category'             => $category,
            'from'                 => $request->input('from'),
            'to'                   => $request->input('to'),
            'valueIds'=>$valueIds,
        ]);

    }

}
