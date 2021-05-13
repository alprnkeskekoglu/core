<?php

namespace Dawnstar\Foundation;

use Dawnstar\Mail\FormSender;
use Dawnstar\Models\Form;
use Dawnstar\Models\FormResult;
use Dawnstar\Models\Language;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormKit
{
    public Form $form;
    public string $storeUrl;
    public bool $recaptchaStatus;

    public function __construct(Form $form)
    {
        $this->form = $form;
        $this->recaptchaStatus = $form->recaptcha_status == 1;
        $this->storeUrl = route('form_store', [$form]);
        $this->initRecaptchaAttributes($form);
    }

    public function initRecaptchaAttributes()
    {
        if ($this->recaptchaStatus) {
            $this->recaptchaSiteKey = $this->form->recaptcha_site_key;
            $this->recaptchaSecretKey = $this->form->recaptcha_secret_key;
            $this->recaptchaScript = '<script src="https://www.google.com/recaptcha/api.js?hl=' . optional(dawnstar()->language)->code . '" async defer></script>';
        }
    }

    public function getAlertsHtml()
    {
        return view('DawnstarWebView::partials.alerts')->render();
    }

    public function store(Request $request)
    {
        $language = $this->getLanguage($request);
        $requestData = $request->except('_token', 'g-recaptcha-response');
        $data = [
            'email' => $requestData['email'] ?? null,
            'data' => $requestData,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        $result = $this->form->results()->create($data);
        $this->sendEmail($result, $language);


        if (Mail::failures()) {
            return back()->withErrors(implode(', ', Mail::failures()));
        }
        return back()->with('success_message', custom($this->form->key . '.success_message', null, $language->id));
    }

    public function sendEmail(FormResult $result, Language $language)
    {
        $formClass = 'App\Mail\Form';
        if (class_exists($formClass)) {
            Mail::to($this->form->receivers)->send(new $formClass($this->form, $result, $language));
        } else {
            Mail::to($this->form->receivers)->send(new FormSender($this->form, $result, $language));
        }
    }

    private function getLanguage($request)
    {
        $fullUrl = $request->header('referer');
        $path = parse_url($fullUrl)['path'];

        $url = Url::where('url', $path)->where('website_id', $this->form->website_id)->first();
        $detail = $url->model;
        return Language::find($detail->language_id);
    }
}
