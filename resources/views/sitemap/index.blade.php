@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
@php echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>'; @endphp
<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ route('sitemap.sitemap-0') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ route('sitemap.sitemap-1') }}</loc>
    </sitemap>
    @for ($i = 1; $i <= $items->lastPage(); $i++)
        <sitemap>
            <loc>{{ route('sitemap.show', ['page' => $i]) }}</loc>
        </sitemap>
    @endfor
</sitemapindex>