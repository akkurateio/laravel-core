<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\Country;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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
            'priority' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
