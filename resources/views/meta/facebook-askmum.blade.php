<meta property="og:title" content="{{ ( isset($seo->opengraph_title) ) ? $seo->opengraph_title : config('app.name') }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ ( isset($seo->canonical) && $seo->canonical != "" ) ? $seo->canonical : url()->full() }}" />
<meta property="og:image" content="{{ url('images/mums_sharing_logo_fb.jpg') }}" />