@extends('layouts.app')

@section('metadata')
    @include('meta.meta-askmum', ['item' => $askmum])
    @include('meta.facebook-askmum', ['item' => $askmum])
    @include('meta.twitter-askmum', ['item' => $askmum])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => 'AskMum'])

<main class="posts">

    <section class="grid-x">

        <div class="cell large-8 blog__listing">

            <div class="grid-x grid-margin-x askmum">
                <div class="cell">
                    <div class="askmum-question">
                        <div class="askmum-question__title">Question:</div>
                        {!! $askmum->question !!}
                    </div>

                    <div class="askmum-answer">
                        <div class="askmum-question__title">Answer:</div>
                        {!! $askmum->answer !!}
                    </div>
                </div>
            </div>

            @include('adverts.partials.leaderboard')

        </div>

        <aside class="cell medium-4">
            @include('adverts.partials.mpu')
        </aside>

    </section>

</main>
@endsection
