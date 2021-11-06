<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\FormRequest;
use Dawnstar\Models\Form;

class FormController extends BaseController
{
    public function index()
    {
        $forms = Form::withCount(['messages' => function($q) {
            $q->where('read', 0);
        }])->get();
        return view('Dawnstar::modules.form.index', compact('forms'));
    }

    public function create()
    {
        return view('Dawnstar::modules.form.create');
    }

    public function store(FormRequest $request)
    {
        $data = $request->all();

        $form = Form::create($data);

        return redirect()->route('dawnstar.forms.index')->with(['success' => __('Dawnstar::form.success.store')]);
    }


    public function edit(Form $form)
    {
        return view('Dawnstar::modules.form.edit', compact('form'));
    }

    public function update(Form $form, FormRequest $request)
    {
        $data = $request->all();

        $form->update($data);

        return redirect()->route('dawnstar.forms.index')->with(['success' => __('Dawnstar::form.success.update')]);
    }

    public function destroy(Form $form)
    {
        $form->delete();

        return redirect()->route('dawnstar.forms.index')->with(['success' => __('Dawnstar::form.success.destroy')]);
    }
}
