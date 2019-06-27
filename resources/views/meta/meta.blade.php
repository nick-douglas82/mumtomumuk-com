@if ($item->title === "Homepage")
    <title>{{ 'Mum to Mum UK | Milton Keynes | Your complete family directory for Milton Keynes' }}</title>
@else
    <title>Mum to Mum UK | {{ (isset($seo->meta_title) && $seo->meta_title != "" ) ? $seo->meta_title : $item->title }} | Your complete family directory for Milton Keynes</title>
@endif
<meta name="description" content="{!! ( isset($seo->meta_description) ) ? $seo->meta_description : '' !!}">
<link rel="canonical" href="{{ ( isset($seo->canonical) && $seo->canonical != "" ) ? $seo->canonical : url()->full() }}">