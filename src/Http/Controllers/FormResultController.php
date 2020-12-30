<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Form;
use Dawnstar\Models\FormResult;
use Illuminate\Http\Request;

class FormResultController extends PanelController
{
    public function index(int $formId)
    {
        $form = Form::find($formId);

        if (is_null($form)) {
            return redirect()->route('form.index')->withErrors("Verilen id'ye ($formId) ait form bulunamadı!")->withInput();
        }

        //TODO: Add paginate
        $results = $form->results;

        $breadcrumb = $this->getBreadcrumb([
            ['index', 'index'],
            ['result', 'result.index', ['formId' => $form->id]]
        ]);

        return view('DawnstarView::pages.form_results.index', compact('form', 'results', 'breadcrumb'));
    }

    public function updateReadStatus(Request $request)
    {
        $id = $request->get('id');

        $formResult = FormResult::find($id);

        if($formResult) {
            $formResult->update(['read' => 1]);
        }
    }


    private function getBreadcrumb(array $parameters)
    {
        $breadcrumb = [];

        foreach ($parameters as $param) {
            $breadcrumb[] = [
                'name' => __('DawnstarLang::form.' . $param[0] . '_title'),
                'url' => route('form.' . $param[1] ?? '', $param[2] ?? [])
            ];
        }

        return $breadcrumb;
    }
}
