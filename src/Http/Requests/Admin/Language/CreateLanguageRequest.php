<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\Language;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateLanguageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'label' => 'string|nullable',
            'locale' => 'string|required',
            'locale_php' => 'string|required',
        ];
    }
}
