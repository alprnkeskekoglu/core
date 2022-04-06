<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\Url;
use Illuminate\Http\Request;

class UrlController extends BaseController
{
    public function getUrl(Request $request)
    {
        $languageId = $request->get('language_id');
        $name = $request->get('name');
        $isNew = $request->get('is_new');
        $containerSlug = $request->get('container_slug');

        $slug = slugify($name);

        $language = Language::find($languageId);
        $website = session('dawnstar.website');

        $urlText = ($website->url_language_code == 1 ? "/{$language->code}/" : '/') . $containerSlug . '/' . $slug;

        $url = Url::where('website_id', $website->id)->where('url', $urlText)->first();

        if ($url) {
            if ($slug == $url->model->slug && $isNew != 1) {
                return $slug;
            }
            return $this->getNewSlug($website, $language->code, $slug, 1);
        }
        return $slug;
    }

    private function getNewSlug($website, $languageCode, $slug, $counter)
    {
        $urlText = ($website->url_language_code == 1 ? "/{$languageCode}/" : '/') . $slug . '-' . $counter;

        $urlExist = Url::where('url', $urlText)->exists();

        if ($urlExist) {
            return $this->getNewSlug($website, $languageCode, $slug, ++$counter);
        }
        return $slug . '-' . $counter;
    }
}
