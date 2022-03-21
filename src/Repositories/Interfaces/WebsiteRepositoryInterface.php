<?php

namespace Dawnstar\Core\Repositories\Interfaces;

use Dawnstar\Core\Models\Website;

interface WebsiteRepositoryInterface
{
    /**
     * @param array $parsedUrl
     * @return Website|null
     */
    public function getWebsiteByUrl(array $parsedUrl): ?Website;
}
