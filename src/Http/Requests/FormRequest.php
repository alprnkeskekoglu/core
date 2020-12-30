<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class FormRequest extends Request
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
            'status' => 'required',
            'name' => 'required|unique:forms',
            'sender' => 'required|email',
            'receivers' => 'required',
            'recaptcha_status' => 'required',
            'recaptcha_site_key' => 'required_if:recaptcha_status, 1',
            'recaptcha_secret_key' => 'required_if:recaptcha_status, 1',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return __('DawnstarLang::form.labels');
    }
}
