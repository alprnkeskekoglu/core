<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\FormRequest;
use Dawnstar\Models\Form;

class FormController extends PanelController
{
    public function index()
    {
        $forms = Form::all();
        $breadcrumb = $this->getBreadcrumb([
            ['index', []]
        ]);

        return view('DawnstarView::pages.form.index', compact('forms', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = $this->getBreadcrumb([
            ['index', []],
            ['create', []]
        ]);

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

        if ($form->wasRecentlyCreated) {
            return redirect()->route('form.index')->with('success_message', 'Form başarıyla oluşturulmuştur.');
        }

        return redirect()->route('form.create')->withErrors(['error_message' => 'Bu isme sahip form mevcut!'])->withInput();
    }

    public function edit(int $id)
    {
        $form = Form::find($id);

        if (is_null($form)) {
            return redirect()->route('form.index')->withErrors("Verilen id'ye ($id) ait form bulunamadı!")->withInput();
        }


        $breadcrumb = $this->getBreadcrumb([
            ['index', []],
            ['edit', ['id' => $id]]
        ]);

        return view('DawnstarView::pages.form.edit', compact('form', 'breadcrumb'));
    }

    public function update(FormRequest $request, $id)
    {
        $form = Form::find($id);

        if (is_null($form)) {
            return redirect()->route('form.index')->withErrors("Verilen id'ye ($id) ait form bulunamadı!")->withInput();
        }

        $data = $request->except('_token');

        $data['recaptcha_site_key'] = $data['recaptcha_status'] == 1 ? $data['recaptcha_site_key'] : null;
        $data['recaptcha_secret_key'] = $data['recaptcha_status'] == 1 ? $data['recaptcha_secret_key'] : null;

        $request->validated();

        $data['receivers'] = explode(',', $data['receivers']);

        //$key = \Str::slug($data['name']);
        $form = $form->update($data);

        return redirect()->route('form.index')->with('success_message', 'Form başarıyla güncellenmiştir.');
    }

    public function delete($id)
    {
        $form = Form::find($id);

        if (is_null($form)) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $form->delete();

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }

    private function getBreadcrumb(array $parameters)
    {
        $breadcrumb = [];

        foreach ($parameters as $param) {
            $breadcrumb[] = [
                'name' => __('DawnstarLang::form.' . $param[0] . '_title'),
                'url' => route('form.' . $param[0], $param[1])
            ];
        }

        return $breadcrumb;
    }
}
