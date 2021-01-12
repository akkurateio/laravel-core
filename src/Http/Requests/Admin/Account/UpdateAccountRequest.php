<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required','string','min:2','max:255', Rule::unique('admin_accounts')->ignore($this->account)],
            'email' => ['nullable','email:dns','max:255', Rule::unique('admin_accounts')->ignore($this->account)],
            'is_active' => 'nullable|boolean',
            'website' => 'nullable|string',
            'internal_reference' => 'nullable|string',
            'parent_id' => 'nullable|integer',
            'pagination' => 'integer',
            'language_id' => 'integer',
        ];
    }
}
