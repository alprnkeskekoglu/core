<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class MenuItemRequest extends Request
{
    public function rules()
    {
        return [
            'language_id' => ['required'],
            'status' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
            'url_id' => ['required_if:type,1'],
            'external_link' => ['required_if:type,2'],
            'target' => ['required_if:type,1', 'required_if:type,2'],
            'name' => ['required'],
        ];
    }

    public function attributes()
    {
        return __('Dawnstar::menu_item.labels');
    }
}
