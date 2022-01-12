<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Form;
use Dawnstar\Core\Foundation\Form as FormService;
use Dawnstar\Core\Models\FormMessage;

class FormMessageController extends BaseController
{
    public function index(Form $form)
    {
        canUser("form.index", false);

        $messages = $form->messages()->orderByDesc('created_at')->paginate(15);

        return view('Core::modules.form_message.index', compact('form', 'messages'));
    }

    public function store(string $key)
    {
        $form = new FormService($key);
        return $form->store();
    }

    public function show(Form $form, FormMessage $message)
    {
        canUser("form.index", false);

        $message->update(['read' => 1]);
        return view('Core::modules.form_message.show', compact('form', 'message'))->render();
    }

    public function destroy(Form $form, FormMessage $message)
    {
        canUser("form.destroy", false);

        $message->delete();
        return redirect()->route('dawnstar.forms.messages.index', $form)->with(['success' => __('Core::form_message.success.destroy')]);
    }
}
