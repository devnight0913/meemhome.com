@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
@php echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>'; @endphp
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    {{-- <url>
        <loc>{{ route('cart') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url> --}}
    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('services') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('terms.show') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('privacy.show') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('login') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('sign-up') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('forgot-password') }}</loc>
        <lastmod>2022-04-30T06:35:38+00:00</lastmod>
        <changefreq>Always</changefreq>
        <priority>1</priority>
    </url>
</urlset>