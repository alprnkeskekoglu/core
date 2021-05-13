<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Foundation\FormKit;
use Dawnstar\Http\Requests\WebFormRequest;
use Dawnstar\Models\Form;
use Dawnstar\Models\FormResult;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class FormResultController extends BaseController
{
    public function index(int $formId)
    {
        $form = Form::findOrFail($formId);

        $results = $form->results()->paginate(20);

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::form.index_title'),
                'url' => route('dawnstar.forms.index')
            ],
            [
                'name' => __('DawnstarLang::form.result_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.form_results.index', compact('form', 'results', 'breadcrumb'));
    }

    public function store(Form $form, WebFormRequest $request)
    {
        $formKit = new FormKit($form);
        return $formKit->store($request);
    }

    public function updateReadStatus(Request $request)
    {
        $formResult = FormResult::find($request->get('id'));

        if($formResult) {
            $formResult->update(['read' => 1]);
        }
    }
}
