<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\Account;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255|unique:admin_accounts',
            'parent_id' => 'nullable|integer',
            'email' => 'nullable|email:dns|max:255|unique:admin_accounts',
            'website' => 'nullable|string|url',
            'internal_reference' => 'nullable|string',
            'registry_siret' => 'nullable|string',
            'registry_rcs' => 'nullable|string',
            'registry_intra' => 'nullable|string',
            'capital' => 'nullable|string',
            'ape' => 'nullable|string',
            'legal_form_id' => 'nullable|string',
            'country_id' => 'nullable|integer',
            'number' => 'nullable',
            'street1' => 'nullable',
            'zip' => 'nullable',
            'city' => 'nullable',
        ];
    }
}
