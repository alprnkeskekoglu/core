<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class MenuRequest extends Request
{
    public function rules()
    {
        return [
            'status' => ['required', 'numeric'],
            'name' => ['required', 'string'],
        ];
    }

    public function attributes()
    {
        return __('Dawnstar::menu.labels');
    }
}
