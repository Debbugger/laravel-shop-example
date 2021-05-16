<?php
/**
 * Created by PhpStorm.
 * User: SVV
 * Date: 01.03.2019
 * Time: 7:39
 */

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

trait SaveTrait
{
    public $messages = [
        'required'   => 'Заполните поле',
        'unique'     => 'Данное значение уже используется',
        'min'        => 'Минимальная длина :min символа(-ов)',
        'max'        => 'Максимальная длина :max символа(-ов)',
        'phone'      => 'Проверьте правильность телефона',
        'exists'     => 'Проверьте корректность',
        'email'      => 'Укажите релаьный email',
        'case_diff'  => 'Должен содержать буквы разного регистра (z и Z)',
        'symbols'    => 'Должен содержать хотя бы 1 символ (@,/%&^%@#)',
        'numbers'    => 'Должен содержать хотя бы 1 число',
        'letters'    => 'Должен содержать хотя бы 1 букву',
        'confirmed'  => 'Повторите указанный пароль ниже',
        'dimensions' => 'Изображение должно быть квадратным',
        'mimes'      => 'Неверный формат файла ',
        'image_fix'  => 'Неверный формат файла (imageFix)',
        'image'      => 'Файл должен быть изображением',
        'date' => 'Выберете дату в календаре',
    ];

    public function save($model)
    {
        if (!(($validator = $this->validateRequest()) instanceof \Illuminate\Validation\Validator)) {
            return $validator;
        }
        $instance = (isset($model->id) ? $model : new $model);
        $validated = collect($validator->validated());

        $multiLangFields = $validated->filter(function ($value, $key) {
            return in_array($key, $this->multiLanguageFields ?? []);
        });
        $locales = array_keys(\LaravelLocalization::getSupportedLocales());
        foreach ($multiLangFields as $field => $value) {
            $aggregatedValue = [];
            foreach ($value as $key => $val) {
                $aggregatedValue[$locales[$key]] = $val instanceof UploadedFile && isset($this->files[$field]) ? $val->store($this->files[$field]['path'], $this->files[$field]['disk']) : $val;
            }
            $instance->$field = $aggregatedValue;
        }

        $fields = $validated->filter(function ($value, $key) {
            return !in_array($key, $this->multiLanguageFields ?? []);
        });
        foreach ($fields as $field => $value) {
            if (isset($this->ignoredFields) && in_array($field, $this->ignoredFields)) {
                continue;
            }
            if (is_array($value)) {
                $aggregatedValue = [];
                foreach ($value as $val) {
                    $aggregatedValue[] = $val instanceof UploadedFile && isset($this->files[$field]) ? $val->store($this->files[$field]['path'], $this->files[$field]['disk']) : $val;
                }
                $instance->$field = $aggregatedValue;
                continue;
            }
            $instance->$field = $value instanceof UploadedFile && isset($this->files[$field]) ? $value->store($this->files[$field]['path'], $this->files[$field]['disk']) : $value;
        }

        $instance->save();

        $callbackResult = isset($model->id) ? $this->afterUpdateCallback($instance) : $this->afterCreateCallback($instance);

        return isset($model->id) ? $this->updateResponse($instance, $callbackResult) : $this->createResponse($instance, $callbackResult);
    }

    public function validateRequest()
    {
        $validator = Validator::make(request()->all(), $this->prepareFormRules(), $this->messages);
        if ($validator->fails()) {
            return request()->ajax() ? response(['status' => 0, 'errors' => $validator->errors()]) : back()->withErrors($validator)->withInput();
        }

        return $validator;
    }

    private function prepareFormRules()
    {
        $formRules = [];
        foreach ($this->form as $field => $rules) {
            foreach ($rules as $rule => $value) {
                if (is_string($value)) {
                    $formRules[$field][] = is_numeric($rule) ? $value : $rule . ':' . $value;
                    continue;
                }
                $formRules[$field][] = $value;
            }

        }

        return $formRules;
    }

    public function afterUpdateCallback($instance)
    {
        return $instance;
    }

    public function afterCreateCallback($instance)
    {
        return $instance;
    }

    public function updateResponse($instance, $callbackResult)
    {
        return request()->ajax() ? response(['status' => 1, 'message' => 'Изменения сохранены']) : back()->with(['status' => 1, 'message' => 'Изменения сохранены']);
    }

    public function createResponse($instance, $callbackResult)
    {
        return request()->ajax() ? response(['status' => 1, 'message' => 'Запись успешно создана']) : back()->with(['status' => 1, 'message' => 'Запись успешно создана']);
    }

}