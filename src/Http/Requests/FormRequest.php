<?php

namespace Dawnstar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class FormRequest extends Request
{
    public function rules()
    {
        return [
            'status' => ['required', 'numeric'],
            'recaptcha_status' => ['required', 'boolean'],
            'name' => ['required', 'string'],
            'sender_email' => ['required', 'email'],
            'receiver_emails' => ['required', 'array'],
        ];
    }

    public function attributes()
    {
        return __('Dawnstar::form.labels');
    }
}
