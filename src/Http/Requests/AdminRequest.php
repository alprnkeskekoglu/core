<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class AdminRequest extends Request
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
            'role_id' => 'required',
            'status' => 'required',
            'fullname' => "required",
            'username' => "nullable",
            'email' => "required|email|unique:admins,email,{$this->id}",
            'password' => $this->id ? 'present' : 'required' . "|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*#?.&]/",
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return __('DawnstarLang::admin.labels');
    }

    public function messages()
    {
        return [
            'password.regex' => __('DawnstarLang::admin.password_regex')
        ];
    }
}
