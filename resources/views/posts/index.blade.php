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

<header class="page-header">
    <div class="page-header--subpage">
        <h1 class="page-header__title">Blog</h1>
    </div>
</header>
<main class="posts">

    <section class="grid-x">

        <div class="cell large-8 blog__listing">
            <h2 class="posts__title">Posts</h2>
            <Posts :tags="{{ $blogTags }}"></Posts>

            @if (isset($adverts['leaderboard'][0]) && !empty($adverts['leaderboard'][0]))
                @include('adverts.leaderboard', ['adslot' => $adverts['leaderboard'][0]['adsense_id']])
            @endif
        </div>

        <aside class="cell medium-4">
            @if (isset($adverts['mpu'][0]) && !empty($adverts['mpu'][0]))
                @include('adverts.mpu_0', ['adslot' => $adverts['mpu'][0]['adsense_id'], 'last' => false])
            @endif

            @if (isset($adverts['mpu'][1]) && !empty($adverts['mpu'][1]))
                @include('adverts.mpu_1', ['adslot' => $adverts['mpu'][1]['adsense_id'], 'last' => true])
            @endif
        </aside>

    </section>

</main>
@endsection
