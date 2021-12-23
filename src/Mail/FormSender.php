<?php

namespace Dawnstar\Mail;

use Dawnstar\Models\Form;
use Dawnstar\Models\FormMessage;
use Dawnstar\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSender extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(Form $form, FormMessage $message)
    {
        $this->form = $form;
        $this->message = $message;

        $this->subject = custom('form.' . $form->id . '.subject', $form->name);
        if (file_exists(resource_path("views/vendor/mail/form.blade.php"))) {
            $this->view = 'vendor.mail.form';
        } else {
            $this->view = 'DawnstarWeb::mail.form';
        }
    }

    public function build()
    {
        return $this
            ->subject($this->subject)
            ->from($this->form->sender_email)
            ->view($this->view, ['form' => $this->form, 'messages' => $this->message->data]);
    }
}
