<?php

namespace App\Modules\AdminManagementProductValues\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductValue;
use App\Specification;
use App\SpecificationValue;
use App\Traits\SaveTrait;
use App\Value;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ValuesController extends Controller
{
    use SaveTrait;
    private $multiLanguageFields = ['value'];
    private $form = [
        'value'   => ['required', 'array'],
        'value.*' => ['required','max' => '255']

    ];

    public $specification_id;
    public $category_id;

    public function createResponse($instance, $callbackResult)
    {
        SpecificationValue::create(['specification_id' => $this->specification_id, 'category_id' => $this->category_id, 'value_id' => $instance->id]);

        return response(['status' => 1, 'message' => 'Значение создано', 'id' => $instance->id, 'specification_id' => $this->specification_id, 'value' => parseMultiLanguageString($instance->value ?? null, LaravelLocalization:: getCurrentLocale())]);
    }

    public function updateResponse($instance, $callbackResult)
    {
        $values = Specification::findOrFail($this->specification_id)->values()->where('category_id', $this->category_id)->select('values.id', 'value->' . app()->getLocale() . ' as text')->get();

        return response(['status' => 1, 'message' => 'Значение измененно', 'id' => $instance->id, 'specification_id' => $this->specification_id, 'json' => $values->toJson(), 'locale' => LaravelLocalization:: getCurrentLocale()]);
    }

    public function index($id, Request $request)
    {
        if ($request->ajax()) {
            $status = 1;
            foreach ($request->input('value') as $key => $val) {
                if ($val != 0) {
                    ProductValue::updateOrCreate(['specification_id' => $key, 'product_id' => $id], ['value_id' => $val, 'specification_id' => $key, 'product_id' => $id]);
                } else {
                    $status = 0;
                }
            }
            if ($status) {
                if (!empty($request->input('redirectTable'))) {
                    return response(['status' => $status, 'message' => 'Значения сохранены', 'redirect' => route('adminManagementProducts')]);
                }

                return response(['status' => $status, 'message' => 'Значения сохранены']);
            } else {
                return response(['status' => $status, 'message' => 'Выберете значения для всех характеристик']);
            }

        }

        $product = Product::findOrFail($id);
        $specifications = $product->category->specifications;
        $values = ProductValue::where(['product_id' => $id])->get()->toArray();
        $selected = array_column($values, 'value_id');
        $noEmpty = array_column($values, 'specification_id');

        return view('adminManagementProductValues::index')->with(['specifications' => $specifications, 'id' => $id, 'selected' => $selected, 'noEmpty' => $noEmpty, 'category_id' => $product->category_id]);
    }

    public function IndexCreate($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $specifications = $product->category->specifications;
        $values = ProductValue::where(['product_id' => $id])->get()->toArray();
        $selected = array_column($values, 'value_id');
        $noEmpty = array_column($values, 'specification_id');

        return view('adminManagementProductValues::indexCreate')->with(['specifications' => $specifications, 'id' => $id, 'selected' => $selected, 'noEmpty' => $noEmpty, 'category_id' => $product->category_id]);
    }

    public function create(Request $request)
    {
        $this->specification_id = $request->input('specification_id');
        $this->category_id = $request->input('category_id');

        return $this->save(Value::class);
    }

    public function delete(Request $request)
    {

        Value::findOrFail($request->input('value_id'))->delete();

        SpecificationValue::where('value_id', $request->input('value_id'))->firstOrFail()->delete();

        $values = Specification::findOrFail($request->input('specification_id'))->values()->where('category_id', $request->input('category_id'))->select('values.id', 'value->' . app()->getLocale() . ' as text')->get();

        return response(['status' => 1, 'message' => 'Значение удаленно', 'specification_id' => $request->input('specification_id'), 'json' => $values->toJson(), 'locale' => LaravelLocalization:: getCurrentLocale()]);
    }

    public function edit(Request $request)
    {

        $this->specification_id = $request->input('specification_id');
        $this->category_id = $request->input('category_id');

        return $this->save(Value::findOrFail($request->input('value_id')));
    }

    public function getModal(Request $request)
    {
        return response(view('adminManagementProductValues::' . (!empty($request->input('value_id')) ? 'modal-edit' : 'modal-add'), [
            'item'             => !empty($request->input('value_id')) ? Value::findOrFail($request->input('value_id')) : null,
            'category_id'      => $request->input('category_id'),
            'specification_id' => $request->input('specification_id'),
            'value_id'         => $request->input('value_id')
        ])->render());
    }

    public function products()
    {

        return view('adminManagementProductValues::index');

    }
}

