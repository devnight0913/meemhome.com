<meta property="og:title" content="@yield('title', $metaTitle)" />
<meta property="og:image:alt" content="@yield('title', config('app.name'))" />
<meta property="og:description" content="@yield('description', $metaDescription)" />
<meta property="og:image" content="@yield('og_image', asset('share.png'))" />
<meta property="og:image:alt" content="@yield('title', config('app.name'))" />
<meta property="og:url" content="@yield('og_url', config('app.url'))" />
<meta property="og:type" content="@yield('og_type', 'website')" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:locale" content="{{ config('app.locale') }}" />
<meta property="og:email" content="{{ $email }}" />
