<?php

namespace Dawnstar\Http\Requests;

use Dawnstar\Validations\Recaptcha;
use Illuminate\Foundation\Http\FormRequest as Request;

class WebFormRequest extends Request
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
            'g-recaptcha-response' => ['required'],
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
            'g-recaptcha-response' => 'Recaptcha',
        ];
    }
}
