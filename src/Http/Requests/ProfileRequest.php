<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)->letters()->numbers()
            ],
        ];
    }

    public function attributes()
    {
        return __('Dawnstar::admin.labels');
    }
}
