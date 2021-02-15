@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">
    @foreach($urls as $url)
        <sitemap>
            <loc>{!! $url['url'] !!}</loc>
        </sitemap>
    @endforeach
</sitemapindex>
