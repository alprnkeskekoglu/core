<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Http\Requests\FormRequest;
use Dawnstar\Core\Models\Form;

class FormController extends BaseController
{
    public function index()
    {
        canUser("form.index", false);

        $forms = Form::withCount(['messages' => function($q) {
            $q->where('read', 0);
        }])->get();
        return view('Core::modules.form.index', compact('forms'));
    }

    public function create()
    {
        canUser("form.create", false);

        return view('Core::modules.form.create');
    }

    public function store(FormRequest $request)
    {
        canUser("form.create", false);

        $data = $request->all();
        $data['website_id'] = session('dawnstar.website.id');

        $form = Form::create($data);

        return redirect()->route('dawnstar.forms.index')->with(['success' => __('Core::form.success.store')]);
    }


    public function edit(Form $form)
    {
        canUser("form.edit", false);

        return view('Core::modules.form.edit', compact('form'));
    }

    public function update(Form $form, FormRequest $request)
    {
        canUser("form.edit", false);

        $data = $request->all();

        $form->update($data);

        return redirect()->route('dawnstar.forms.index')->with(['success' => __('Core::form.success.update')]);
    }

    public function destroy(Form $form)
    {
        canUser("form.destroy", false);

        $form->delete();

        return redirect()->route('dawnstar.forms.index')->with(['success' => __('Core::form.success.destroy')]);
    }
}
