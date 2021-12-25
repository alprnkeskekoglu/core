<?php

namespace Dawnstar\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WebsiteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => ['required', 'boolean'],
            'default' => ['required', 'boolean'],
            'name' => ['required'],
            'domain' => [
                'required',
                Rule::unique('websites')->ignore($this->website)
            ],
            'languages' => ['required', 'array'],
            'default_language' => ['required']
        ];
    }

    public function attributes()
    {
        return __('Core::website.labels');
    }
}
