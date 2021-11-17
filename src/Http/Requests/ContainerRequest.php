<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContainerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'translations.*.name' => ['required_if:languages.*,1'],
            'translations.*.slug' => ['required_if:languages.*,1']
        ];
    }

    public function attributes()
    {
        return __('Dawnstar::container.labels');
    }
}
