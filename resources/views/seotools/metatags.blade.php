<title>@yield('title', $metaTitle)</title>
<meta name="keywords" content="@yield('keywords', $keywords)">
<meta name="description" content="@yield('description', $metaDescription)">
<meta property="fb:app_id" content="{{ config('app.fb_app_id') }}" />
<meta type="metaTags" name="application-name" content="{{ config('app.name') }}" />
<meta type="metaTags" name="mobile-web-app-capable" content="yes" />
