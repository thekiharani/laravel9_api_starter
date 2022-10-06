<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'phone_number' => ['required', 'string', 'min:9', 'max:13', Rule::unique('users')],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function attributes()
    {
        return [];
    }
}
