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

            @if (count($postsCollection) > 0)

                <h2 class="posts__title">Recent Posts</h2>

                <div class="grid-x grid-margin-x">

                    @foreach ($postsCollection as $post)
                        <div class="cell medium-6">
                            @include('partials.post', ["post" => $post])
                        </div>
                    @endforeach

                    @if ($postsCount > 4)
                        <div class="cell">
                            <a href="{{ url(Request::segment(1) . '/blog/posts/') }}" class="btn btn--posts is-full">
                                More Posts
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="no-posts">
                    There are currently no posts. Please check back later.
                </div>
            @endif

            @if (count($reviewsCollection) > 0)

                <h2 class="posts__title with-border">Rebecca Reviews</h2>

                <div class="grid-x grid-margin-x">

                    @foreach ($reviewsCollection as $review)
                        <div class="cell medium-6">
                            @include('partials.post', ["post" => $review])
                        </div>
                    @endforeach


                    @if ($reviewsCount > 4)
                        <div class="cell">
                            <a href="{{ url(Request::segment(1) . '/blog/rebecca-reviews/') }}" class="btn btn--posts is-full">
                                More Reviews
                            </a>
                        </div>
                    @endif
                </div>
            @endif

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
