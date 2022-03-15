<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Models\Url;
use Dawnstar\Core\Repositories\Interfaces\UrlRepositoryInterface;

class UrlRepository implements UrlRepositoryInterface
{
    /**
     * @param Url $model
     */
    public function __construct(protected Url $model) {}

    /**
     * @param string $path
     * @param int $websiteId
     * @return Url|null
     */
    public function getUrlByPathAndWebsite(string $path, int $websiteId): ?Url
    {
        return $this->model->where('url', $path)->where('website_id', $websiteId)->first();
    }
}