<?php

namespace Dawnstar\Http\Controllers;

use App\Http\Controllers\Controller;
use Analytics;
use Dawnstar\Http\Requests\FormRequest;
use Dawnstar\Models\Form;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();

        return view('DawnstarView::pages.form.index', compact('forms'));
    }

    public function create()
    {
        return view('DawnstarView::pages.form.create');
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

        if($form->wasRecentlyCreated) {
            return redirect()->route('form.index')->with('success_message', 'Form başarıyla oluşturulmuştur.');
        }

        return redirect()->route('form.create')->withErrors(['error_message' => 'Bu isme sahip form mevcut!'])->withInput();
    }

    public function edit(int $id)
    {
        $form = Form::find($id);

        if(is_null($form)) {
            return redirect()->route('form.index')->withErrors("Verilen id'ye ($id) ait form bulunamadı!")->withInput();
        }


        return view('DawnstarView::pages.form.edit', compact('form'));
    }

    public function update(FormRequest $request, $id)
    {
        $form = Form::find($id);

        if(is_null($form)) {
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

        if(is_null($form)) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $form->delete();

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }
}
