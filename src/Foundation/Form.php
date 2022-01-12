<?php

namespace Dawnstar\Core\Foundation;

use Dawnstar\Core\Mail\FormSender;
use Dawnstar\Core\Models\Form as Model;
use Dawnstar\Core\Models\FormMessage;
use Illuminate\Support\Facades\Mail;

class Form
{
    /**
     * @var string
     */
    public string $key;
    /**
     * @var Model|null
     */
    public Model $form;
    /**
     * @var string
     */
    public string $storeUrl;
    /**
     * @var bool
     */
    public bool $recaptchaStatus = false;
    /**
     * @var string|null
     */
    public ?string $recaptchaKey;

    /**
     * Form constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
        $this->form = $this->getForm();
    }

    /**
     * @return $this
     */
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
            $this->recaptchaKey = setting('recaptcha_site_key');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param FormMessage $message
     */
    public function sendEmail(FormMessage $message)
    {
        $formClass = 'App\Mail\Form';
        if (class_exists($formClass)) {
            Mail::to($this->form->receivers)->send(new $formClass($this->form, $message));
        } else {
            Mail::to($this->form->receivers)->send(new FormSender($this->form, $message));
        }
    }

    /**
     * @return Model|null
     */
    private function getForm(): ?Model
    {
        return Model::where('key', $this->key)
            ->where('website_id', dawnstar()->website->id)
            ->active()
            ->first();
    }
}
