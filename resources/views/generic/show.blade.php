@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $page])
    @include('meta.facebook', ['item' => $page])
    @include('meta.twitter', ['item' => $page])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => $page->title])

<main class="posts">

    <section class="grid-x">

        <div class="cell large-8 blog__listing">

            <div class="grid-x grid-margin-x generic">
                <div class="cell">
                    <img src="{{ $page->getFirstMediaUrl('default', 'post') }}" alt="">
                    {!! $page->body !!}
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
