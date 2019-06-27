@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $place])
    @include('meta.facebook', ['item' => $place])
    @include('meta.twitter', ['item' => $place])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => 'Places to go'])

<main class="place">

    <section class="grid-x grid-margin-x">

        <header class="cell medium-6 place__information">
            <h1 class="place__title">{{ $place->title }}</h1>

            @if ($place->address)
                <h3 class="place__address has-icon icon--marker">{{ $place->address }}</h3>
            @endif

            @if ($place->phone)
            <a href="tel:{{ $place->phone }}" class="place__phone has-icon icon--phone">{{ $place->phone }}</a>
            @endif

            @include('partials.item-ratings', ['data' => $place])

            <div class="place__action-buttons">
                <Save :issaved="{{ $place->isFavorited }}"
                      favtype="Place"
                      slug="{{ $place->slug }}"
                      title="{{ $place->title }}"
                      endpoint="places"
                      cssclasses="btn btn--primary has-icon">
                </Save>
                <a href="{{ $place->website }}" class="btn btn--primary btn--visit" target="_blank">Visit Website</a>
            </div>
        </header>

        <div class="cell medium-6 large-5 large-offset-1 place__gallery">
            <Gallery :images="{{ $place->getMedia('gallery') }}"></Gallery>
        </div>

    </section>

    <section class="grid-x grid-margin-x">
        <div class="cell medium-8 place__content">
            <div class="tabs">

                <input type="radio" name="tabset" id="detail" aria-controls="details" checked>
                <label for="detail">Details</label>

                <input type="radio" name="tabset" id="review" aria-controls="reviews">
                <label for="review">Reviews</label>

                <div class="tab-panels">
                    <section id="details" class="tab-panel">
                        <p>{!! $place->body !!}</p>

                        @include('partials.social-share')

                        <Googlemap :longitude="{{ $place->longitude }}" :latitude="{{ $place->latitude }}"></Googlemap>

                    </section>

                    <section id="reviews" class="tab-panel">

                        @foreach ($place->reviews as $review)
                            @include('partials.review')
                        @endforeach

                        @if (Auth::user())
                            <Review slug="{{ $place->slug }}"></Review>
                        @else
                            @include('partials.review-login')
                        @endif

                    </section>
                </div>
            </div>

            @if (count($place->suggestions) > 0)
                <div class="cross-sell">
                    <h2 class="cross-sell__heading">You may also enjoy…</h2>

                    <ul class="cross-sell__list grid-x grid-margin-x">
                        @foreach ($place->suggestions as $suggestion)
                            <li class="cross-sell__item cell medium-6 large-3">
                                <a href="{{ $suggestion->place->url(Request::segment(1)) }}">
                                    <img src="https://placehold.co/175x124">
                                    <h3 class="cross-sell__title">{{ $suggestion->place->title }}</h3>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @include('adverts.partials.leaderboard')

        </div>

        <aside class="cell medium-4">
            @include('adverts.partials.mpu')
        </aside>
    </section>
</main>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBc684y62E-arXiW9C7ypvZEbAqfI5pZFw"></script>
@endsection
