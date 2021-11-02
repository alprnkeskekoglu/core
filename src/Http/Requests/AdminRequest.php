<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => ['required'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($this->admin)
            ],
            'password' => ['nullable', 'confirmed'],
        ];
    }

    public function attributes()
    {
        return __('Dawnstar::admin.labels');
    }
}
