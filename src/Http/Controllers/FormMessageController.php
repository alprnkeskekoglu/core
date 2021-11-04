<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Form;
use Dawnstar\Models\FormMessage;

class FormMessageController extends BaseController
{
    public function index(Form $form)
    {
        $messages = $form->messages()->orderByDesc('created_at')->paginate(12);

        return view('Dawnstar::modules.form_message.index', compact('form', 'messages'));
    }

    public function show(Form $form, FormMessage $message)
    {
        $message->update(['read' => 1]);
        return view('Dawnstar::modules.form_message.show', compact('form', 'message'))->render();
    }


    public function destroy(Form $form, FormMessage $message)
    {
        $message->delete();
        return redirect()->route('dawnstar.forms.messages.index', $form)->with(['success' => __('Dawnstar::form_message.success.destroy')]);
    }
}
