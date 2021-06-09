<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Country;
use Dawnstar\Models\FormBuilder;
use Illuminate\Http\Request;

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

        $formBuilderTypes = ['input', 'date', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'media', 'category'];

        return view('DawnstarView::pages.form_builders.edit', compact('formBuilder', 'formBuilderTypes'));
    }

    public function showModal(Request $request)
    {
        $formBuilder = FormBuilder::find($request->get('id'));
        $key = $request->get('key');
        $name = $request->get('name');

        if ($key == 'metas') {
            $element = $formBuilder->data[$key] ?? [['type' => 'title'], ['type' => 'description']];
            return view('DawnstarView::form_builder.modals.metas', compact('element', 'formBuilder', 'key'))->render();
        }

        $data = $formBuilder->data[$key];
        $element = $this->getElementByName($name, $data)[1];

        $whiteList = [
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'date', 'category', 'media'
        ];

        if (in_array($element['type'], $whiteList)) {

            $view = $element['type'];
            if ($view == 'ckeditor') $view = 'textarea';

            if(in_array($element['type'], ['radio', 'checkbox', 'select']) && !isset($element['options'])) {
                $element['options'] = [[]];
            }

            return view('DawnstarView::form_builder.modals.' . $view, compact('element', 'formBuilder', 'key'))->render();
        }

        abort(404);
    }

    public function showNewModal(Request $request)
    {
        $formBuilder = FormBuilder::find($request->get('id'));
        $inputType = $request->get('inputType');

        if ($inputType == 'metas') {
            $element = [
                [
                    'type' => 'title',
                ],
                [
                    'type' => 'description',
                ],
            ];
            return view('DawnstarView::form_builder.modals.metas', compact('element'))->render();
        }

        $whiteList = [
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'date', 'category', 'media'
        ];

        if (in_array($inputType, $whiteList)) {

            $view = $inputType;
            if ($view == 'ckeditor') $view = 'textarea';
            $element = ['type' => $inputType];

            if(in_array($inputType, ['radio', 'checkbox', 'select'])) {
                $element['options'] = [[]];
            }


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

        if($key == 'metas') {
            $formBuilderData['metas'] = $data['metas'];
            $formBuilder->update(['data' => $formBuilderData]);

            return back();
        }

        $oldKey = $key == 'general' ? 'languages' : 'general';
        $element = $this->getElementByName($data['name'], $formBuilderData[$oldKey]);
        if ($element) {
            unset($formBuilderData[$oldKey][$element[0]]);
        }

        if(!isset($formBuilderData[$key])) {
            $formBuilderData[$key] = [];
        }


        if($data['type'] == 'select') {
            if($data['option_type'] != 'custom') {
                unset($data['options']);
            }
            if($data['option_type'] != 'model') {
                unset($data['model_option']);
            }
            if($data['option_type'] != 'city') {
                unset($data['city_option']);
            }
        }

        $element = $this->getElementByName($data['name'], $formBuilderData[$key]);
        if ($element) {
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

    public function deleteElement(Request $request)
    {
        $formBuilder = FormBuilder::find($request->get('id'));
        $key = $request->get('key');
        $name = $request->get('name');

        $formBuilderData = $formBuilder->data;
        $element = $this->getElementByName($name, $formBuilderData[$key]);
        if ($element) {
            unset($formBuilderData[$key][$element[0]]);
        }

        $formBuilder->update(['data' => $formBuilderData]);
    }

    public function getCountries()
    {
        return Country::all()->pluck('name_' . session('dawnstar.language.code'), 'id');
    }



    private function getElementByName($key, $data)
    {
        foreach ($data as $k => $d) {
            if ($d['name'] == $key) {
                return [$k, $d];
            }
        }
    }
}
