<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\Website;

class Dawnstar
{
    public function __construct()
    {
        view()->share("dawnstar", $this);
    }

    public function website()
    {
        $fullUrl = request()->fullUrl();
        $parsedUrl = parse_url($fullUrl);

        $domain = $parsedUrl["host"] = str_replace("www.", "", $parsedUrl["host"]);
        $domainArray = [$domain, "www." . $domain];

        return Website::whereIn('domain', $domainArray)->first();
    }

    public function metasHtml()
    {
        $meta = new Meta();

        return $meta->getHtml();
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        if (method_exists(self::class, $name)) {
            $this->$name = $this->$name();
        }

        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }
}
