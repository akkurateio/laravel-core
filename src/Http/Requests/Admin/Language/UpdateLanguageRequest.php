<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\Language;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'locale' => 'string|required',
            'locale_php' => 'string|required',
            'label' => 'string|nullable',
            'priority' => 'integer',
            'is_active' => 'boolean'
        ];
    }
}
