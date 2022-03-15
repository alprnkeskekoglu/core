<?php

namespace Dawnstar\Core\Services;

use Illuminate\Http\Request;

class ParseUrlService
{
    const HOST = 'host';

    public function __construct(protected Request $request)
    {
    }

    /**
     * @return array
     */
    public function getParsedUrl(): array
    {
        $parsedUrl = parse_url($this->request->fullUrl());
        $parsedUrl[self::HOST] = str_replace('www.', '', $parsedUrl[self::HOST]);

        return $parsedUrl;
    }
}
