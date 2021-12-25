<?php

namespace Dawnstar\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => ['required'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'role_id' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($this->admin)
            ],
            'password' => [
                Rule::requiredIf(is_null($this->admin)),
                'nullable',
                'confirmed',
                Password::min(8)->letters()->numbers()
            ],
        ];
    }

    public function attributes()
    {
        return __('Core::admin.labels');
    }
}
