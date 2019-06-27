@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $babytoddlergroup])
    @include('meta.facebook', ['item' => $babytoddlergroup])
    @include('meta.twitter', ['item' => $babytoddlergroup])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => 'Baby and toddler groups'])

<main class="place">

    <section class="grid-x grid-margin-x">

        <header class="cell medium-6 place__information">
            <h1 class="place__title">{{ $babytoddlergroup->title }}</h1>

            @if ($babytoddlergroup->event_times)
                <h3 class="place__address has-icon icon--calendar">{{ $babytoddlergroup->event_times }}</h3>
            @endif

            @if ($babytoddlergroup->address)
                <h3 class="place__address has-icon icon--marker">{{ $babytoddlergroup->address }}</h3>
            @endif

            @if ($babytoddlergroup->phone)
                <a href="tel:{{ $babytoddlergroup->phone }}" class="place__phone has-icon icon--phone">{{ $babytoddlergroup->phone }}</a>
            @endif

            @include('partials.item-ratings', ['data' => $babytoddlergroup])

            <div class="place__action-buttons">

                <Save :issaved="{{ $babytoddlergroup->isFavorited }}"
                      favtype="Listing"
                      slug="{{ $babytoddlergroup->slug }}"
                      title="{{ $babytoddlergroup->title }}"
                      endpoint="baby-toddler-groups"
                      cssclasses="btn btn--primary has-icon">
                </Save>

                <a href="{{ $babytoddlergroup->website }}" class="btn btn--primary btn--visit" target="_blank">Visit Website</a>
            </div>
        </header>

        <div class="cell medium-6 large-5 large-offset-1 place__gallery">
            <Gallery :images="{{ $babytoddlergroup->getMedia('gallery') }}"></Gallery>
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
                        <p>{!! $babytoddlergroup->body !!}</p>

                        @include('partials.social-share')

                        <Googlemap :longitude="{{ $babytoddlergroup->longitude }}" :latitude="{{ $babytoddlergroup->latitude }}"></Googlemap>

                    </section>

                    <section id="reviews" class="tab-panel">

                        @foreach ($babytoddlergroup->reviews as $review)
                            @include('partials.review')
                        @endforeach
                        @if (Auth::user())
                            <Review slug="{{ $babytoddlergroup->slug }}"></Review>
                        @else
                            @include('partials.review-login')
                        @endif
                    </section>
                </div>
            </div>

            @if (count($babytoddlergroup->suggestions) > 0)
                <div class="cross-sell">
                    <h2 class="cross-sell__heading">You may also enjoy…</h2>

                    <ul class="cross-sell__list grid-x grid-margin-x">
                        @foreach ($babytoddlergroup->suggestions as $suggestion)
                            <li class="cross-sell__item cell medium-6 large-3">
                                <a href="{{ $suggestion->babytoddlergroup->url(Request::segment(1)) }}">
                                    <img src="https://placehold.co/175x124">
                                    <h3 class="cross-sell__title">{{ $suggestion->babytoddlergroup->title }}</h3>
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
