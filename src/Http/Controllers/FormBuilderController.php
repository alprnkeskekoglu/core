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

        $formBuilderTypes = ['input', 'date', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'media', 'category', 'metas'];

        return view('DawnstarView::pages.form_builders.edit', compact('formBuilder', 'formBuilderTypes'));
    }

    public function showModal(Request $request)
    {
        $formBuilder = FormBuilder::find($request->get('id'));
        $key = $request->get('key');
        $name = $request->get('name');

        $data = $formBuilder->data[$key];

        if($key == 'metas') {
            $element = $data;
            return view('DawnstarView::form_builder.modals.metas' , compact('element'))->render();
        }

        $foundKey = array_search($name, array_column($data, 'name'));
        $element = $data[$foundKey];

        $whiteList = [
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'date', 'category', 'media'
        ];

        if(in_array($element['type'], $whiteList)) {

            $view = $element['type'];
            if($view == 'ckeditor') $view = 'textarea';

            return view('DawnstarView::form_builder.modals.' . $view, compact('element', 'formBuilder', 'key'))->render();
        }

        abort(404);
    }

    public function showNewModal(Request $request)
    {
        $formBuilder = FormBuilder::find($request->get('id'));
        $inputType = $request->get('inputType');


        if($inputType == 'metas') {
            $element = $data;
            return view('DawnstarView::form_builder.modals.metas' , compact('element'))->render();
        }

        $whiteList = [
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'date', 'category', 'media'
        ];

        if(in_array($inputType, $whiteList)) {

            $view = $inputType;
            if($view == 'ckeditor') $view = 'textarea';
            $element = ['type' => $inputType];
            $isNew = true;
            return view('DawnstarView::form_builder.modals.' . $view, compact('element', 'formBuilder', 'isNew'))->render();
        }

        abort(404);
    }

    public function saveElement(Request $request)
    {
        $data = $request->except('_token', 'formBuilder', 'key');
        $formBuilder = FormBuilder::find($request->get('formBuilder'));
        $key = $request->get('key');
        $formBuilderData = $formBuilder->data;

        $element = $this->getElementByName($data['name'], $formBuilderData[$key]);
        if($element) {
            $formBuilderData[$key][$element[0]] = $data;
        } else {
            $formBuilderData[$key][] = $data;
        }

        $formBuilder->update(['data' => $formBuilderData]);

        return back();
    }

    public function saveOrder(Request $request)
    {
        $order = $request->get('data');
        $formBuilder = FormBuilder::find($request->get('id'));
        $data = $formBuilder->data;

        $newData = [];

        foreach ($order as $key => $orderArr) {
            foreach ($orderArr as $id => $ord) {
                $newData[$key][$id] = $this->getElementByName($ord, $data[$key])[1];
            }
        }

        $formBuilder->update(['data' => $newData]);
    }

    private function getElementByName($key, $data)
    {
        foreach ($data as $k => $d) {
            if($d['name'] == $key) {
                return [$k, $d];
            }
        }
    }
}
