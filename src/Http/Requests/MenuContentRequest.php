<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class MenuContentRequest extends Request
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
            'contents.*.status' => 'required',
            'contents.*.name' => 'required_if:contents.*.status, 1',
            'contents.*.type' => 'required_if:contents.*.status, 1',
            'contents.*.url_id' => 'required_if:contents.*.type, 1',
            'contents.*.out_link' => 'required_if:contents.*.type, 2',
            'contents.*.target' => 'required_if:contents.*.type, 1|required_if:contents.*.type, 2',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'contents.*.status' => __('DawnstarLang::menu_content.labels.status'),
            'contents.*.name' => __('DawnstarLang::menu_content.labels.name'),
            'contents.*.type' => __('DawnstarLang::menu_content.labels.type'),
            'contents.*.url_id' => __('DawnstarLang::menu_content.labels.url_id'),
            'contents.*.out_link' => __('DawnstarLang::menu_content.labels.out_link'),
            'contents.*.target' => __('DawnstarLang::menu_content.labels.target'),
        ];
    }
}
