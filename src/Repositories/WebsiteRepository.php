<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\WebsiteInterface;
use Dawnstar\Core\Models\Website;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class WebsiteRepository
 * @package Dawnstar\Core\Repositories
 */
class WebsiteRepository implements WebsiteInterface
{

    /**
     * @param int $id
     * @return Website
     */
    public function getById(int $id): Website
    {
        return Website::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Website::all();
    }

    /**
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection
    {
        return Website::where('status', 1)->get();
    }

    /**
     * @return Website
     */
    public function store(): Website
    {
        $data = request()->only(['status', 'default', 'url_language_code', 'name', 'domain']);
        $languages = request()->get('languages');
        $defaultLanguage = request()->get('default_language');

        $website = Website::create($data);

        if ($data['default'] == 1) {
            Website::where('default', 1)->where('id', '<>', $website->id)->update(['default' => 0]);
        }

        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLanguage, ['default' => 1]);

        if (session('dawmstar.website') == null) {
            $this->setSession($website);
        }

        return $website;
    }

    /**
     * @param Website $website
     * @return Website
     */
    public function update(Website $website): Website
    {
        $data = request()->only(['status', 'default', 'url_language_code', 'name', 'domain']);
        $languages = request()->get('languages');
        $defaultLanguage = request()->get('default_language');

        $website->update($data);
        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLanguage, ['default' => 1]);

        if ($data['default'] == 1) {
            Website::where('default', 1)->where('id', '<>', $website->id)->update(['default' => 0]);
        }

        if ($website->id === session('dawnstar.website.id')) {
            $this->setSession($website);
        }

        return $website;
    }

    /**
     * @param Website $website
     */
    public function destroy(Website $website): void
    {
        $website->delete();
    }

    /**
     * @param Website $website
     */
    public function setSession(Website $website): void
    {
        $languages = $website->languages;
        $language = $website->defaultLanguage();

        session([
            'dawnstar' => [
                'website' => $website,
                'languages' => $languages,
                'language' => $language,
            ]
        ]);
    }
}
