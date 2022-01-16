@php echo '<'.'?x'.'ml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach($urls as $url)
        <url>
            <loc>{!! $url['url'] !!}</loc>
            @foreach($url["alternates"] as $alternate)
                <xhtml:link
                    rel="alternate"
                    hreflang="{!! $alternate['hreflang'] !!}"
                    href="{!! $alternate['url'] !!}"/>
            @endforeach
            <changefreq>{!! $url["changefreq"] !!}</changefreq>
            <priority>{!! $url["priority"] !!}</priority>
        </url>
    @endforeach
</urlset>
