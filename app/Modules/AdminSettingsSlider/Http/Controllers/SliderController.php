<?php

namespace App\Modules\AdminSettingsSlider\Http\Controllers;

use App\Slider;
use App\Traits\SaveTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    use SaveTrait;
    private $multiLanguageFields = ['description','slug'];
    private $form = [
        'description'    => ['required', 'array'],
        'description.*'         => ['required', 'max' => '255'],
        'image'          => ['required', 'image', 'max' => '2048'],
        'slug'=> ['required', 'array'],
        'slug.*'       => ['required', 'max' => '255'],
        'status'=>['required']

    ];
    private $files = [
        'image' => ['path' => '/images/slides', 'disk' => 'public']
    ];

    public function updateResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'message' => 'Cлайд обновлен']);
    }

    public function index()
    {
        $specifications = Slider::all();

        return view('adminSettingsSlider::index', ['specifications' => $specifications]);
    }

    public function image(Request $request)
    {
        $this->form = [
            'image' => ['required']
        ];

        return $this->save(Slider::findOrFail($request->input('id')));
    }

    public function changeShow(Request $request)
    {
        $item = Slider::findOrFail($request->input('id'));
        $item->status = !$item->status;
        $item->save();

        return response(['status' => 1, 'message' => 'Статус обновлен', 'show' => $item->status, 'id' => $item->id]);
    }

    public function table()
    {

        return DataTables::eloquent(Slider::query())->only(['id', 'status', 'image','description', 'edit'])->editColumn('status', function (Slider $item) {
            if ($item->status == 1) {
                return '<i data-id="' . $item->id . '" class="far fa-2x fa-check-circle show-icon changeStatus"></i>';
            }

            return '<i data-id="' . $item->id . '" class="fas fa-2x fa-ban unshow-icon changeStatus"></i>';
        })->editColumn('edit', function (Slider $item) {
            return '<a  class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" data-toggle="modal" data-target="#edit-modal" ></a>
                <a  class="fas  fa-trash delete get-modal" data-toggle="modal" data-target="#delete-modal"   > </a>';
        })->editColumn('image', function (Slider $item) {
            return '<div class="hover-img"   data-type="table"><img   class="edit-img" src="' . asset($item->image) . '" data-type="table">
                        <label  class="uploadbutton loader-file"  data-type="table">
                            <i  class="fa fa-file-image-o" aria-hidden="true"></i>    
                        </label></div>';
        })->editColumn('description', function (Slider $item) {
            if (strlen(parseMultiLanguageString($item->description ?? null, app()->getLocale())) > 100) {
                return substr(parseMultiLanguageString($item->description ?? null, app()->getLocale()), 0, 100) . '...';
            } else {
                return parseMultiLanguageString($item->description ?? null, app()->getLocale());
            }
        })->filter(function ($query) {
            if (request()->has('search')) {
                $query->WhereRaw(' lower(JSON_EXTRACT(description, "$.' . app()->getLocale() . '")) like "%' . mb_strtolower(request('search')['value']) . '%"');
            }
        })
            ->setRowAttr([
                'data-id'   => function ($item) {
                    return $item->id;
                },
                'data-show' => function ($item) {
                    return $item->show;
                },
            ])->rawColumns(['status', 'edit', 'image'])->toJson();
    }

    public function create(Request $request)
    {
        return $this->save(Slider::class);
    }

    public function delete(Request $request)
    {
            Slider::findOrFail($request->input('delete'))->delete();
            return response(['status' => 1, 'message' => 'Слайд удален']);

    }

    public function edit(Request $request)
    {
        $elem = Slider::findOrFail($request->input('id'));
        $this->form['image'] = ['nullable', 'image', 'max' => '2048'];
        return $this->save($elem);
    }

    public function getModal(Request $request)
    {
        if ($request->input('id') > 0) {
            $slider = Slider::findOrFail($request->input('id'));

            return response(view('adminSettingsSlider::modal-edit')->with(['item' => $slider])->render());
        }

        return response(view('adminSettingsSlider::modal-add')->render());
    }

}
