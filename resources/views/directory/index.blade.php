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
        <h1 class="page-header__title">Directory</h1>
    </div>
</header>

{{-- <Search type="listing" endpoint="directory"></Search> --}}
<Directorysearch></Directorysearch>

@if (isset($adverts['leaderboard'][0]) && !empty($adverts['leaderboard'][0]))
    @include('adverts.leaderboard', ['adslot' => $adverts['leaderboard'][0]['adsense_id']])
@endif

@endsection
