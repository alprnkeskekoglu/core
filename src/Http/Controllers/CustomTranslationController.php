<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\CustomTranslationRequest;
use Dawnstar\Models\CustomTranslation;
use Dawnstar\Models\Website;
use Dawnstar\Models\Language;
use Illuminate\Http\Request;

class CustomTranslationController extends BaseController
{
    public function index()
    {
        canUser("custom_translation.index", false);

        $customTranslations = $this->getCustomTranslations();
        return view('Dawnstar::modules.custom_translation.index', compact('customTranslations'));
    }

    public function search(Request $request)
    {
        canUser("custom_translation.index", false);

        $customTranslations = $this->getCustomTranslations($request->get('search'));
        return view('Dawnstar::modules.custom_translation.ajax', compact('customTranslations'))->render();
    }

    public function update()
    {
        canUser("custom_translation.edit", false);

        $customTranslation = CustomTranslation::find(request('id'));
        if($customTranslation) {
            $customTranslation->update(['value' => request('value')]);
            return response()->json(['success' => __('Dawnstar::custom_translation.success.update')]);
        }
        return response()->json(['error' => __('Dawnstar::custom_translation.error.not_found')], 404);
    }

    public function destroy()
    {
        canUser("custom_translation.destroy", false);

        $customTranslation = CustomTranslation::where('key', request('key'))->delete();
        return response()->json(['success' => __('Dawnstar::custom_translation.success.destroy')]);
    }

    private function getCustomTranslations(string $search = null)
    {
        canUser("custom_translation.index", false);

        $customTranslations = CustomTranslation::query();

        if($search) {
            $customTranslations = $customTranslations->where(function ($q) use ($search) {
                $q->where('key', 'like', '%' . $search . '%')
                    ->orWhere('value', 'like', '%' . $search . '%');
            });
        }

        $customTranslations = $customTranslations->get()->groupBy('key');

        $return = [];
        foreach ($customTranslations as $key => $content) {
            $default = $content->where('language_id', session('innoio.language.id'))->first();

            $return[$key]['default_value'] = $default ? $default->value : $content->first()->value;

            foreach ($content as $cont) {
                $return[$key]['languages'][$cont->language_id] = [
                    'id' => $cont->id,
                    'language_name' => $cont->language->native_name,
                    'language_code' => $cont->language->code,
                    'value' => $cont->value
                ];
            }
        }

        return $return;
    }
}
