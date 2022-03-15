<?php

namespace Dawnstar\Core\Services;

use Dawnstar\Core\Foundation\Dawnstar;
use Dawnstar\Core\Models\CategoryTranslation;
use Dawnstar\Core\Models\ContainerTranslation;
use Dawnstar\Core\Models\PageTranslation;
use Dawnstar\Core\Models\Url;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Repositories\Interfaces\StructureRepositoryInterface;
use Dawnstar\Core\Repositories\Interfaces\UrlRepositoryInterface;
use Dawnstar\Core\Repositories\Interfaces\WebsiteRepositoryInterface;
use Dawnstar\Tracker\Foundation\Tracker;
use Illuminate\Http\Request;

class DawnstarService
{
    const HOST = 'host';

    public function __construct(
        protected Request                      $request,
        protected Dawnstar                     $dawnstar,
        protected ParseUrlService              $parseUrlService,
        protected WebsiteRepositoryInterface   $websiteRepository,
        protected StructureRepositoryInterface $structureRepository,
        protected UrlRepositoryInterface       $urlRepository,
        protected Tracker                      $tracker
    )
    {
    }

    public function init()
    {
        $parsedUrl = $this->parseUrlService->getParsedUrl();

        $website = $this->websiteRepository->getWebsiteByUrl($parsedUrl);

        $this->dawnstar->setWebsite($website);

        $path = $this->getPath($parsedUrl, $website);

        $url = $this->urlRepository->getUrlByPathAndWebsite($path, $website->id);

        $this->abortIfUrlNotFound($url);

        $translation = $url->model;
        $parent = $translation->parent;

        $this->dawnstar->setDawnstarSettings([
            'url' => $url,
            'parent' => $parent,
            'translation' => $translation,
            'language' => $translation->language,
        ]);

        $this->notFoundIfDraftOrNotPreview($translation, $parent);

        $structure = $parent->structure;
        $this->dawnstar->setDawnstarSettings(['container' => $structure->container]);

        $function = $this->getControllerAndMethod($website->id, $structure->key, $translation);

        $this->tracker->init();

        return $function;
    }

    /**
     * @param array $parsedUrl
     * @param Website $website
     * @return mixed
     */
    protected function getPath(array $parsedUrl, Website $website)
    {
        if (!isset($parsedUrl['path'])) {
            $homePage = $this->structureRepository->getHomePageByWebsite($website);
            $homePageDetail = $homePage->container->translations()->where('language_id', $website->defaultLanguage()->id)->first();

            if (is_null($homePageDetail)) {
                abort(404);
            }

            if ($homePageDetail->url->url != '/') {
                return redirect()->to($homePageDetail->url->url);
            } else {
                $parsedUrl['path'] = '/';
            }
        }

        return $parsedUrl['path'];
    }

    /**
     * @param int $websiteId
     * @param string $structureKey
     * @param ContainerTranslation $translation
     * @return mixed|null
     */
    protected function getControllerAndMethod(int $websiteId, string $structureKey, ContainerTranslation $translation)
    {
        $function = null;

        $controllerClass = 'App\Http\Controllers\Website' . $websiteId . '\\' . ucfirst($structureKey) . 'Controller';
        $controller = new $controllerClass();

        if (is_a($translation, ContainerTranslation::class)) {

            $function = $controller->container($this->dawnstar);

        } elseif (is_a($translation, PageTranslation::class)) {

            $function = $controller->page($this->dawnstar);

        } elseif (is_a($translation, CategoryTranslation::class)) {

            $function = $controller->category($this->dawnstar);
        }

        if (is_null($function)) {
            abort(404);
        }

        return $function;
    }

    protected function notFoundIfDraftOrNotPreview(ContainerTranslation $translation, $parent)
    {
        if ($translation->status === 0 || $parent->status === 0 || ($parent->status == 2 && request('preview') != 1)) {
            abort(404);
        }
    }

    /**
     * @param Url|null $url
     * @return void
     */
    protected function abortIfUrlNotFound(Url|null $url)
    {
        if (is_null($url) || is_null($url->model)) {
            abort(404);
        }
    }
}
