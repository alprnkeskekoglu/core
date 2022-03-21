<?php

namespace Dawnstar\Core\Repositories\Interfaces;

use Dawnstar\Core\Models\Url;
use Dawnstar\Core\Models\Website;

interface UrlRepositoryInterface
{
    /**
     * @param string $path
     * @param int $websiteId
     * @return Website|null
     */
    public function getUrlByPathAndWebsite(string $path, int $websiteId): ?Url;
}