@if (isset($adverts['leaderboard'][0]) && !empty($adverts['leaderboard'][0]))
    @include('adverts.leaderboard', ['adslot' => $adverts['leaderboard'][0]['adsense_id']])
@else
    @include('adverts.leaderboard', ['adslot' => '6614825414'])
@endif