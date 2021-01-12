<?php

namespace Akkurate\LaravelCore\Http\Requests\Admin\User;

use Akkurate\LaravelCore\Rules\Firstname;
use Akkurate\LaravelCore\Rules\Lastname;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => ['required', 'string', 'min:2', 'max:255', new Firstname],
            'lastname' => ['required', 'string', 'min:2', 'max:255', new Lastname],
            'email' => 'required|email:dns|max:255|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
