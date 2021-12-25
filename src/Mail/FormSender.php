<?php

namespace Dawnstar\Core\Mail;

use Dawnstar\Core\Models\Form;
use Dawnstar\Core\Models\FormMessage;
use Dawnstar\Core\Models\Language;
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
            $this->view = 'CoreWeb::mail.form';
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
