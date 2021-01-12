<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\Country;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|required',
            'code' => 'string|required',
        ];
    }
}
