<?php

namespace Dawnstar\Http\Controllers;
use Dawnstar\Models\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class FormBuilderController extends BaseController
{
    public function index()
    {
        $formBuilders = FormBuilder::all();

        return view('DawnstarView::pages.form_builders.index', compact('formBuilders'));
    }

    public function edit(int $id, string $type)
    {
        $formBuilder = FormBuilder::where('container_id', $id)
            ->where('type', $type)
            ->first();

        $formBuilderTypes = ['input', 'date', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'media', 'category', 'meta'];

        return view('DawnstarView::pages.form_builders.edit', compact('formBuilder', 'formBuilderTypes'));
    }

    public function showModal(Request $request)
    {
        $formBuilder = FormBuilder::find($request->get('id'));
        $key = $request->get('key');
        $name = $request->get('name');

        $data = $formBuilder->data[$key];

        $foundKey = array_search($name, array_column($data, 'name'));

        $element = $data[$foundKey];

        switch ($element['type']) {
            case 'radio':
                $view = view('DawnstarView::form_builder.modals.radio', compact('element'))->render();
                break;
            default:
                $view = view('DawnstarView::form_builder.modals.default', compact('element'))->render();
        }


        return $view;
    }
}
