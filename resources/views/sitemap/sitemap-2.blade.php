@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
@php echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>'; @endphp
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach ($services as $service)
        <url>
            <loc>{{ $service->url }}</loc>
            <lastmod>{{ $service->date_modified }}</lastmod>
            <changefreq>Always</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
</urlset>