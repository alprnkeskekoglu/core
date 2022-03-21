<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Repositories\Interfaces\WebsiteRepositoryInterface;

class WebsiteRepository implements WebsiteRepositoryInterface
{
    /**
     * @param Website $model
     */
    public function __construct(
        protected Website $model
    ) { }

    /**
     * @param array $parsedUrl
     * @return Website|null
     */
    public function getWebsiteByUrl(array $parsedUrl): ?Website
    {
        $domainArray = [$parsedUrl['host'], 'www.' . $parsedUrl['host']];

        return $this->model->whereIn('domain', $domainArray)->firstOrFail();
    }
}