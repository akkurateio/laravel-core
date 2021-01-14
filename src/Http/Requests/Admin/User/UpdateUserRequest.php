<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\User;

use Akkurate\LaravelCore\Rules\Firstname;
use Akkurate\LaravelCore\Rules\Lastname;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => ['required', 'string', 'max:255', new Firstname],
            'lastname' => ['required', 'string', 'max:255', new Lastname],
            'email' => 'required|email:dns|max:255|unique:users,email,' . auth()->user()->id,
            'birth_date' => 'nullable|date',
            'is_active' => 'boolean',
        ];
    }
}
