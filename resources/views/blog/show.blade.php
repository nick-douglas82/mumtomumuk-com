@extends('layouts.app')

@section('content')

@include('partials.page-header-sub', ['title' => 'Places to go'])


<main class="place">

    <section class="grid-x grid-margin-x">

        <header class="cell medium-6 place__information">
            <h1 class="place__title">{{ $place->title }}</h1>

            <h3 class="place__address has-icon icon--marker">{{ $place->address }}</h3>

            <a href="tel:{{ $place->phone }}" class="place__phone has-icon icon--phone">{{ $place->phone }}</a>

            @include('partials.item-ratings', ['data' => $place])

            <div class="place__action-buttons">
                <Favourite :data="{{ $place }}" endpoint="places" favtype="Place" cssclasses="btn btn--primary has-icon"></Favourite>
                <a href="{{ $place->website }}" class="btn btn--primary btn--visit" target="_blank">Visit Website</a>
            </div>
        </header>

        <div class="cell medium-6 large-5 large-offset-1 place__gallery">
            <div class="gallery__wrap">
                <i></i>
                <img src="https://placehold.co/468x256" alt="" class="gallery__image">
            </div>
        </div>

    </section>

    <section class="grid-x grid-margin-x">
        <div class="cell medium-8 place__content">
            <div class="tabs">

                <input type="radio" name="tabset" id="tab1" aria-controls="details" checked>
                <label for="tab1">Details</label>

                <input type="radio" name="tabset" id="tab2" aria-controls="reviews">
                <label for="tab2">Reviews</label>

                <div class="tab-panels">
                    <section id="details" class="tab-panel">
                        <p>{{ $place->body }}</p>

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
                            <p>Please log in to write a review.</p>
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

        </div>

        <aside class="cell medium-4">
        </aside>
    </section>
</main>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBc684y62E-arXiW9C7ypvZEbAqfI5pZFw"></script>
@endsection
