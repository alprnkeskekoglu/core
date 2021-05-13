<?php

namespace Dawnstar\Validations;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class Recaptcha implements Rule
{
    public string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params' =>
                [
                    'secret' => $this->secretKey,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]
            ]
        );

        if ($response->getStatusCode() == 200) {
            $body = json_decode((string)$response->getBody());

            return $body->success;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('DawnstarLang::form.recaptcha');
    }
}
