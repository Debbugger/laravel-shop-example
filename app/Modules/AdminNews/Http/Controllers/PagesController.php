<?php

namespace App\Modules\AdminNews\Http\Controllers;

use App\Http\Controllers\Controller;
use App\News;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PagesController extends Controller
{
    use SaveTrait;
    protected $firstError = false;

    private $form = [
        'slug'               => ['required', 'max' => '128', 'unique' => 'news,slug'],
        'title'              => ['required', 'array', 'max' => '3'],
        'title.*'            => ['required', 'max' => '255'],
        'full_text'          => ['required', 'array', 'max' => '3'],
        'full_text.*'        => ['required', 'max' => '20000'],
        'short_text'          => ['required', 'array', 'max' => '3'],
        'short_text.*'        => ['required', 'max' => '20000'],
        'images'             => ['nullable', 'array', 'max' => '10'],
        'images.*'           => ['nullable', 'image', 'max' => '2048'],
        'status'             => ['required'],
        'image'=>['required']
    ];

    private $multiLanguageFields = [
        'title',
        'full_text',
        'short_text',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    private $files = [
        'images' => ['path' => 'images/news', 'disk' => 'public'],
        'image' => ['path' => 'images/news', 'disk' => 'public'],
    ];

    public function all(Request $request)
    {
        if ($request->isMethod('post')) {
            return DataTables::eloquent(News::query())->only(['id', 'slug', 'title', 'status', 'action'])->editColumn('title', function (News $item) {
                return parseMultiLanguageString($item->title);
            })->editColumn('status', function (News $item) {
                return $item->status ? '<i data-id="' . $item->id . '"  class="far fa-check-circle changeStatus show-icon fa-2x text-success">' : '<i data-id="' . $item->id . '" class="fas fa-ban changeStatus unshow-icon fa-2x text-danger">';
            })->addColumn('action', function (News $item) {
                return '<a href="' . route('adminNewsEditPage', $item->id) . '"><i class="fa fa-edit mr-2" style="font-size: 19px"></i></a>
                    <a  class="delete" data-id="' . $item->id . '" data-toggle="modal" data-target="#delete-modal"><i class="fas fa-trash text-primary mr-2" style="font-size: 18px"></i></a>
                    <a  class="fas fa-globe get-modal get-seo-modal seo-modal" data-toggle="modal" data-target="#seo-modal"   > </a>';
            }) ->setRowAttr([
                'data-id'   => function ($item) {
                    return $item->id;
                }])->rawColumns(['status', 'action'])->toJson();
        }

        return view('adminNews::all');
    }

    public function deleteItem(Request $request)
    {
        if (empty($item = News::findOrFail($request->delete))) {
            $this->firstError = true;

            return response(['status' => 0, 'message' => 'Запись не найдено']);
        }
        $item->delete();

        return response(['status' => 1, 'message' => 'Удалено']);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->merge(['status' => $request->status ? 1 : 0]);

            return $this->save(News::class);
        }

        return view('adminNews::add');
    }

    public function edit(Request $request, $id)
    {
        $News = News::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->merge(['status' => $request->status ? 1 : 0]);
            $this->form['image'][0] = 'nullable';
            $this->form['slug'] = ['required', 'max:128', Rule::unique('news', 'slug')->ignore($id)];
            return $this->save($News);
        }

        return view('adminNews::edit', ['item' => $News]);
    }
    public function editImage(Request $request, $id){
        $News = News::findOrFail($id);
        $this->form = [
            'images'       => ['nullable', 'array', 'max' => '10'],
            'images.*'     => ['nullable', 'image', 'max' => '2048'],
        ];
        return $this->save($News);
    }


    public function deleteImage(Request $request)
    {
        if (empty($item = News::findOrFail($request->id))) {
            return response(['status' => 0, 'message' => 'Запись не найдена']);
        }

        $item->deleteImage = $request->img;
        $item->save();

        return response(['status' => 1, 'message' => 'Изображение успешно удалено']);
    }
    public function changeShow(Request $request){
        $item = News::findOrFail($request->input('id'));
        $item->status = !$item->status;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->status, 'id' => $item->id]);
    }
    public function getSeoModal(Request $request)
    {
        if ($request->input('id')) {
            return response(view('adminManagementCategory::modal-seo')->with(['item' => News::findOrFail($request->input('id'))])->render());
        }

        return response(['status' => 1]);
    }

    public function changeSeo(Request $request)
    {
        $item=News::whereId($request->input('id'))->firstOrFail();
        $this->form = [
            'slug'               => ['required', 'max' => '255'],
            'meta_title'         => ['required', 'array', 'max' => '3'],
            'meta_title.*'       => ['required', 'max' => '64'],
            'meta_keywords'      => ['required', 'array', 'max' => '3'],
            'meta_keywords.*'    => ['required', 'max' => '2000'],
            'meta_description'   => ['required', 'array', 'max' => '3'],
            'meta_description.*' => ['required', 'max' => '10000'],
        ];
        $this->multiLanguageFields=[
            'meta_title',  'meta_keywords', 'meta_description'
        ];
        $this->form['slug'] = ['required', 'unique' => Rule::unique('news')->ignore($request->input('id')), 'max' => '128'];
        return $this->save($item);
    }
    public function createResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'message' => 'Создано', 'redirect' => route('adminNews')]);
    }

    public function updateResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'message' => 'Изменено', 'images' => view('adminNews::images', ['item' => $instance])->render()]);
    }
}
