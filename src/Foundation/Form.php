<?php

namespace Dawnstar\Foundation;

use Dawnstar\Mail\FormSender;
use Dawnstar\Models\Form as Model;
use Dawnstar\Models\FormMessage;
use Illuminate\Support\Facades\Mail;

class Form
{
    public string $key;
    public Model $form;
    public string $storeUrl;
    public bool $recaptchaStatus = false;
    public ?string $recaptchaKey;

    public function __construct(string $key)
    {
        $this->key = $key;
        $this->form = $this->getForm();
    }

    public function init()
    {
        if(is_null($this->form)) {
            return $this;
        }

        $this->setRecaptcha();
        $this->storeUrl = route('form_store', $this->key);

        return $this;
    }

    public function setRecaptcha()
    {
        if ($this->form->recaptcha_status == 1) {
            $this->recaptchaStatus = true;
            $this->recaptchaKey = ''; //TODO setting import
        }
    }

    public function store()
    {
        $requestData = request()->except('_token', 'g-recaptcha-response');
        $data = [
            'email' => $requestData['email'] ?? null,
            'data' => $requestData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        $message = $this->form->messages()->create($data);

        $this->sendEmail($message);

        if (Mail::failures()) {
            return back()->withErrors(implode(', ', Mail::failures()));
        }
        return back()->with('success', custom('form.' . $this->form->id  . '.success_message', 'Form başarıyla gönderildi.'));
    }

    public function sendEmail(FormMessage $message)
    {
        $formClass = 'App\Mail\Form';
        if (class_exists($formClass)) {
            Mail::to($this->form->receivers)->send(new $formClass($this->form, $message));
        } else {
            Mail::to($this->form->receivers)->send(new FormSender($this->form, $message));
        }
    }

    private function getForm(): ?Model
    {
        return Model::where('key', $this->key)
            ->where('website_id', dawnstar()->website->id)
            ->active()
            ->first();
    }
}
