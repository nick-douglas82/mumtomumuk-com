@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $event])
    @include('meta.facebook', ['item' => $event])
    @include('meta.twitter', ['item' => $event])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => 'Events'])

<main class="place">

    <section class="grid-x grid-margin-x">

        <header class="cell medium-6 place__information">
            <h1 class="place__title">{{ $event->title }}</h1>

            <h3 class="place__address has-icon icon--calendar">{{ $event->eventDate($event->event_at, $event->event_end) }}</h3>

            <h3 class="place__address has-icon icon--marker">{{ $event->address }}</h3>

            @if ($event->phone)
                <a href="tel:{{ $event->phone }}" class="place__phone has-icon icon--phone">{{ $event->phone }}</a>
            @endif

            <div class="place__action-buttons">
                <Save :issaved="{{ $event->isFavorited }}"
                      favtype="Event"
                      slug="{{ $event->slug }}"
                      title="{{ $event->title }}"
                      endpoint="event"
                      cssclasses="btn btn--primary has-icon">
                </Save>
                <a href="{{ $event->website }}" class="btn btn--primary btn--visit" target="_blank">Visit Website</a>
            </div>
        </header>

        <div class="cell medium-6 large-5 large-offset-1 place__gallery">
            <Gallery :images="{{ $event->getMedia('gallery') }}"></Gallery>
        </div>

    </section>

    <section class="grid-x grid-margin-x">
        <div class="cell medium-8 place__content">
            <div class="tabs">

                <div class="tab-panels">
                    <section id="details" class="tab-visible">
                        <h2 class="tab__title">Details</h2>

                        <p>{!! $event->body !!}</p>

                        @include('partials.social-share')

                        <Googlemap :longitude="{{ $event->longitude }}" :latitude="{{ $event->latitude }}"></Googlemap>

                    </section>
                </div>
            </div>

            @if (count($event->suggestions) > 0)
                <div class="cross-sell">
                    <h2 class="cross-sell__heading">You may also enjoy…</h2>

                    <ul class="cross-sell__list grid-x grid-margin-x">
                        @foreach ($event->suggestions as $suggestion)
                            <li class="cross-sell__item cell medium-6 large-3">
                                <a href="{{ $suggestion->event->url(Request::segment(1)) }}">
                                    <img src="https://placehold.co/175x124">
                                    <h3 class="cross-sell__title">{{ $suggestion->event->title }}</h3>
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
