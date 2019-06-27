@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $page])
    @include('meta.facebook', ['item' => $page])
    @include('meta.twitter', ['item' => $page])
@endsection

@section('billboard')
    @if (isset($adverts['billboard'][0]) && !empty($adverts['billboard'][0]))
        @include('adverts.billboard', ['adslot' => $adverts['billboard'][0]['adsense_id']])
    @endif
@endsection

@section('content')

{{--  @include('partials.page-header')  --}}

<header class="page-header">
    <div class="page-header--subpage page-header--listing">
        <h1 class="page-header__title">Places to go</h1>
    </div>
</header>

<Placesearch></Placesearch>

@if (isset($adverts['leaderboard'][0]) && !empty($adverts['leaderboard'][0]))
    @include('adverts.leaderboard', ['adslot' => $adverts['leaderboard'][0]['adsense_id']])
@endif

@endsection
