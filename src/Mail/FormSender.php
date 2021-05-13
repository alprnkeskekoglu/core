<?php

namespace Dawnstar\Mail;

use Dawnstar\Models\Form;
use Dawnstar\Models\FormResult;
use Dawnstar\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSender extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(Form $form, FormResult $result, Language $language)
    {
        $this->form = $form;
        $this->result = $result;
        $this->language = $language;

        $this->subject = custom($form->key . '.subject', $form->name, $language->id);
        if (file_exists(resource_path("views/vendor/mail/form.blade.php"))) {
            $this->view = 'vendor.mail.form';
        } else {
            $this->view = 'DawnstarWebView::mail.form';
        }
    }

    public function build()
    {
        return $this
            ->subject($this->subject)
            ->from($this->form->sender)
            ->view($this->view, ['form' => $this->form, 'result' => $this->result, 'language' => $this->language]);
    }
}
