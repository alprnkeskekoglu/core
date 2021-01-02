<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\FormRequest;
use Dawnstar\Models\Form;

class FormController extends PanelController
{
    public function index()
    {
        $forms = Form::all();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::form.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.form.index', compact('forms', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::form.index_title'),
                'url' => route('dawnstar.form.index')
            ],
            [
                'name' => __('DawnstarLang::form.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.form.create', compact('breadcrumb'));
    }

    public function store(FormRequest $request)
    {
        $data = $request->except('_token');

        $request->validated();

        $data['receivers'] = explode(',', $data['receivers']);

        $key = \Str::slug($data['name']);
        $form = Form::firstOrCreate(
            ['key' => $key],
            $data
        );

        // Admin Action
        addAction($form, 'store');

        return redirect()->route('dawnstar.form.index')->with('success_message', __('DawnstarLang::form.response_message.store'));
    }

    public function edit(int $id)
    {
        $form = Form::find($id);

        if (is_null($form)) {
            return redirect()->route('dawnstar.form.index')->withErrors(__('DawnstarLang::form.response_message.id_error', ['id' => $id]))->withInput();
        }

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::form.index_title'),
                'url' => route('dawnstar.form.index')
            ],
            [
                'name' => __('DawnstarLang::form.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.form.edit', compact('form', 'breadcrumb'));
    }

    public function update(FormRequest $request, $id)
    {
        $form = Form::find($id);

        if (is_null($form)) {
            return redirect()->route('dawnstar.form.index')->withErrors(__('DawnstarLang::form.response_message.id_error', ['id' => $id]))->withInput();
        }

        $data = $request->except('_token');

        $data['recaptcha_site_key'] = $data['recaptcha_status'] == 1 ? $data['recaptcha_site_key'] : null;
        $data['recaptcha_secret_key'] = $data['recaptcha_status'] == 1 ? $data['recaptcha_secret_key'] : null;

        $request->validated();

        $data['receivers'] = explode(',', $data['receivers']);

        $form->update($data);

        // Admin Action
        addAction($form, 'update');

        return redirect()->route('dawnstar.form.index')->with('success_message', __('DawnstarLang::form.response_message.update'));
    }

    public function delete($id)
    {
        $form = Form::find($id);

        if (is_null($form)) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $form->delete();

        // Admin Action
        addAction($form, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }
}
