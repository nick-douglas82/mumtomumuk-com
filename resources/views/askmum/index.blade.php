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
        <h1 class="page-header__title">AskMum</h1>
    </div>
</header>
<main class="posts">

    <section class="grid-x">

        <div class="cell large-8 blog__listing">

            <div class="grid-x grid-margin-x askmum">
                @foreach ($groups as $key => $group)
                    <div class="cell large-6">
                        <div class="askmum__title">{{ $key }}</div>
                        @foreach ($group as $question)
                            <a href="{{ url(Request::segment(1) . '/askmum/' . $question['slug']) }}" class="askmum__question">
                                {{ $question['question'] }}
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </div>

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
