@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $afterschoolclub])
    @include('meta.facebook', ['item' => $afterschoolclub])
    @include('meta.twitter', ['item' => $afterschoolclub])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => '4+ Activities'])

<main class="place">

    <section class="grid-x grid-margin-x">

        <header class="cell medium-6 place__information">

            <h1 class="place__title">{{ $afterschoolclub->title }}</h1>

            @if ($afterschoolclub->event_times)
                <h3 class="place__address has-icon icon--calendar">{{ $afterschoolclub->event_times }}</h3>
            @endif

            @if ($afterschoolclub->address)
                <h3 class="place__address has-icon icon--marker">{{ $afterschoolclub->address }}</h3>
            @endif

            @if ($afterschoolclub->phone)
                <a href="tel:{{ $afterschoolclub->phone }}" class="place__phone has-icon icon--phone">{{ $afterschoolclub->phone }}</a>
            @endif

            <div class="place__action-buttons">
                <Save :issaved="{{ $afterschoolclub->isFavorited }}"
                      favtype="Listing"
                      slug="{{ $afterschoolclub->slug }}"
                      title="{{ $afterschoolclub->title }}"
                      endpoint="after-school-clubs"
                      cssclasses="btn btn--primary has-icon">
                </Save>
                <a href="{{ $afterschoolclub->website }}" class="btn btn--primary btn--visit" target="_blank">Visit Website</a>
            </div>

            @include('partials.item-ratings', ['data' => $afterschoolclub])

        </header>


        <div class="cell medium-6 large-5 large-offset-1 place__gallery">
            <Gallery :images="{{ $afterschoolclub->getMedia('gallery') }}"></Gallery>
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
                        <p>{!! $afterschoolclub->body !!}</p>

                        @include('partials.social-share')

                        <Googlemap :longitude="{{ $afterschoolclub->longitude }}" :latitude="{{ $afterschoolclub->latitude }}"></Googlemap>

                    </section>

                    <section id="reviews" class="tab-panel">

                        @foreach ($afterschoolclub->reviews as $review)
                            @include('partials.review')
                        @endforeach
                        @if (Auth::user())
                            <Review slug="{{ $afterschoolclub->slug }}"></Review>
                        @else
                            @include('partials.review-login')
                        @endif
                    </section>
                </div>
            </div>

            @if (count($afterschoolclub->suggestions) > 0)
                <div class="cross-sell">
                    <h2 class="cross-sell__heading">You may also enjoy…</h2>

                    <ul class="cross-sell__list grid-x grid-margin-x">
                        @foreach ($afterschoolclub->suggestions as $suggestion)
                            <li class="cross-sell__item cell medium-6 large-3">
                                <a href="{{ $suggestion->afterschoolclub->url(Request::segment(1)) }}">
                                    <img src="https://placehold.co/175x124">
                                    <h3 class="cross-sell__title">{{ $suggestion->afterschoolclub->title }}</h3>
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
