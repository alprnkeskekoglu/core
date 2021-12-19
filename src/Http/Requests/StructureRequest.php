<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StructureRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => ['required'],
            'type' => ['required'],
            'key' => [
                'required',
                Rule::unique('structures')->ignore($this->structure)
            ],
            'has_detail' => ['required', 'boolean'],
            'has_category' => ['required', 'boolean'],
            'has_property' => ['required', 'boolean'],
            'has_url' => ['required', 'boolean'],
            'is_searchable' => ['required', 'boolean'],

            'translations.*.name' => ['required_if:languages.*,1'],
            'translations.*.slug' => ['required_if:has_url,1']
        ];
    }

    public function attributes()
    {
        return __('Dawnstar::structure.labels');
    }
}
