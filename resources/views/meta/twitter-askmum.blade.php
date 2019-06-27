<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="{{ ( isset($seo->canonical) && $seo->canonical != "" ) ? $seo->canonical : url()->full() }}">
<meta name="twitter:title" content="{{ ( isset($seo->twitter_title) ) ? $seo->twitter_title : config('app.name') }}">
<meta name="twitter:description" content="{!! ( isset($seo->twitter_description) ) ? $seo->twitter_description : '' !!}">
<meta name="twitter:image" content="{{ url('images/mums_sharing_logo_twitter.jpg') }}" />
