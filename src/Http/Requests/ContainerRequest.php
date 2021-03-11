<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class ContainerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => "filled|unique:containers,key,{$this->id},id,deleted_at,NULL,website_id," . session('dawnstar.website.id'),
            'status' => 'required',
            'type' => 'filled',
            'details.*.name' => 'required_if:details.*.status, 1',
            'details.*.slug' => 'required_if:details.*.status, 1',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return __('DawnstarLang::container.labels');
    }
}
