@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $rebeccareview])
    @include('meta.facebook', ['item' => $rebeccareview])
    @include('meta.twitter', ['item' => $rebeccareview])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => 'Review'])

<section class="grid-x grid-margin-x">

    <header class="cell blog__information">
        <h1 class="blog__title">{{ $rebeccareview->title }}</h1>
        <address class="blog__address has-icon"><i class="icon icon--marker"></i>{{ $rebeccareview->address }}</address>
        <div class="blog__rating">
            @include('partials.review-ratings', ['rating' => $rebeccareview->overall_rating])
        </div>

        @if ($rebeccareview->target_age)
            <div class="blog__target-age">
                <strong>Target age:</strong> {{ $rebeccareview->target_age }}
            </div>
        @endif
    </header>

</section>

<section class="grid-x grid-margin-x">
    <div class="cell medium-8 post__content">
        <div class="blog__specs">
            <time datetime="{{ $rebeccareview->created_at->format('Y-m-d') }}" class="has-icon">
                <i class="icon icon--calendar"></i>
                {{ $rebeccareview->reviewDate() }}
            </time>

            <div class="blog__by has-icon">
                <i class="icon icon--user"></i>
                Posted by {{ $rebeccareview->user->name }}
            </div>
        </div>
    </div>

    <div class="cell medium-8 blog__content">
        <img src="{{ $rebeccareview->getFirstMediaUrl('default', 'post') }}" alt="">
        {!! $rebeccareview->body !!}

        @if (!empty($rebeccareview->content))
            @foreach (unserialize($rebeccareview->content) as $content)
                {!! $content !!}
            @endforeach
        @endif

        @if (!empty($rebeccareview->reviewRatings()))
            <h3>Our Ratings</h3>
            <div class="blog__reviews">
                @foreach ($rebeccareview->reviewRatings() as $rating)
                    <div class="blog__review">
                        <div class="review__title">{{ $rating['name'] }}:</div>
                        @include('partials.review-ratings', ['rating' => $rating['rating']])
                    </div>
                @endforeach
            </div>
        @endif

        @if ($rebeccareview->body_footer)
            {!! $rebeccareview->body_footer !!}
        @endif

        @include('partials.social-share')

        @include('partials.comments', ['post' => $rebeccareview])

        @include('adverts.partials.leaderboard')

    </div>

    <aside class="cell medium-4">
        @include('adverts.partials.mpu')
    </aside>
</section>

@endsection
