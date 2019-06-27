@if (isset($adverts['billboard'][0]) && !empty($adverts['billboard'][0]))
    @include('adverts.billboard', ['adslot' => $adverts['billboard'][0]['adsense_id']])
@else
    @include('adverts.billboard', ['adslot' => '3570268791'])
@endif