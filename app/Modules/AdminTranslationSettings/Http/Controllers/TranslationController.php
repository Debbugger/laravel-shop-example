<?php

namespace App\Modules\AdminTranslationSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\SaveTrait;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Spatie\TranslationLoader\LanguageLine;

class TranslationController extends Controller
{
    use SaveTrait;
    private $form = [
        'text.*' => ['required'],
        'group'  => ['required'],
        'key'    => ['required'],
        'type_text'=>['required'],

    ];



    private $multiLanguageFields = ['text'];

    public function groups()
    {
        return view('adminTranslationSettings::groups', ['groups' => LanguageLine::orderBy('group')->distinct()->get(['group'])]);
    }

    public function group($group)
    {
        return view('adminTranslationSettings::group', ['group' => $group, 'items' => LanguageLine::whereGroup($group)->orderByDesc('id')->paginate(30)]);
    }

    public function createResponse($instance, $callbackResult)
    {
        return response(['status' => 1, 'message' => 'Запись успешно добавлена', 'redirect' => route('adminTranslationSetting')]);
    }

    public function delete(Request $request, $id = null)
    {
        if (empty($item = LanguageLine::whereId($request->id)->first())) {
            return response(['status' => 0, 'message' => 'Запись не найдена']);
        }
        $item->delete();

        return response(['status' => 1, 'message' => 'Запись успешно удалена', 'redirect' => route('adminTranslationSetting')]);
    }

    public function edit(Request $request, $group, $id)
    {
        $item = LanguageLine::where('id', $id)->firstOrFail();

        if ($request->isMethod('post')) {
            $slug = new Slugify();

            $request->merge(['group' => $slug->slugify($request->group), 'key' => $slug->slugify($request->key)]);
           if ($request->input('type_text')==2)
                $request->merge(['text'=>Purifier::clean($request->input('text2'))]);

            return $this->save($item);
        }

        return view('adminTranslationSettings::edit')->with(['item' => $item, 'group' => $group]);
    }

    public function add(Request $request, $group, $id = null)
    {

        if ($request->isMethod('post')) {
            $slug = new Slugify();

            $request->merge(['group' => $slug->slugify($request->group), 'key' => $slug->slugify($request->key)]);
            if ($request->input('type_text')==2)
                $request->merge(['text'=>Purifier::clean($request->input('text2'))]);
            return $this->save(LanguageLine::class);
        }

        return view('adminTranslationSettings::add', ['group' => $group]);
    }
}
