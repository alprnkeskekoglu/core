<?php

namespace Dawnstar\Core\Services;


use Illuminate\Support\Facades\Storage;
use Dawnstar\Core\Mail\FormMail;
use Dawnstar\Core\Models\Admin;
use Dawnstar\Core\Models\Form;
use Dawnstar\Core\Models\FormResult;
use Mail;
use Dawnstar\Core\Models\FormResultMedia;
use Dawnstar\Core\Notifications\FormNotification;
use Dawnstar\MediaManager\Foundation\MediaUpload;
use Dawnstar\MediaManager\Models\Folder;

class FormService
{
    public Form $form;
    public string $storeUrl;
    public bool $recaptchaStatus = false;
    public ?string $recaptchaKey;

    public function __construct(protected string $key)
    {
        $this->form = $this->getForm();
    }

    public function init()
    {
        if (is_null($this->form)) {
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

    public function store()
    {
        $requestData = request()->except('_token', 'g-recaptcha-response');

        if (request()->file()) {
            foreach (request()->file() as $key => $files) {
                $requestData[$key] = $medias = [];
                if(is_array($files)) {
                    foreach ($files as $file) {
                        $media = $this->mediaUpload($file);
                        $medias[] = $media->id;
                        $requestData[$key][] = $media->url;
                    }
                } else {
                    $media = $this->mediaUpload($files);
                    $medias[] = $media->id;
                    $requestData[$key][] = $media->url;
                }
            }
        }

        $data = [
            'email' => $requestData['email'] ?? null,
            'data' => $requestData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        $message = $this->form->messages()->create($data);
        if(isset($medias)) {
            $message->medias()->syncWithoutDetaching($medias);
        }

        try {
            $this->sendEmail($message);
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }

        return back()->with('success', custom('form.'.$this->form->id.'.success_message', 'Form başarıyla gönderildi.'));
    }

    public function sendEmail(FormResult $result)
    {
        $formClass = 'App\Mail\Form';
        if (class_exists($formClass)) {
            Mail::to($this->form->receiver_emails)->send(new $formClass($this->form, $result));
        } else {
            Mail::to($this->form->receiver_emails)->send(new FormMail($this->form, $result));
        }
    }

    private function mediaUpload($file)
    {
        $folder = Folder::firstOrCreate(['name' => $this->key, 'private' => 1]);
        $mediaUpload = new MediaUpload('private', $folder->id);
        return $mediaUpload->fromComputer($file);
    }

    private function getForm(): ?Form
    {
        return Form::where('key', $this->key)
            ->where('website_id', dawnstar()->website->id)
            ->active()
            ->first();
    }
}
