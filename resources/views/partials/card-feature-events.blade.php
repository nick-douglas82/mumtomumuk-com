<section class="cards">
    <h2 class="cards__title">Featured Events</h2>

    <div class="cards__wrap grid-x grid-margin-x">

        @foreach($events as $event)

            <div class="card cell medium-4">
                <a href="{{ $event->url(Request::segment(1)) }}">
                    <img src="{{ asset($event->getFirstMediaUrl('default', 'homepage')) }}" class="card__image">
                    <h3 class="card__title">{{ $event->title }}</h3>
                    <time datetime="{{ $event->event_at->format('Y-m-d') }}" class="card__datetime">
                        <i class="icon icon--time"></i>
                        {{ $event->event_at->format('D, d M Y') }}
                    </time>
                </a>

                <Save :issaved="{{ $event->isFavorited }}"
                      favtype="Event"
                      slug="{{ $event->slug }}"
                      title="{{ $event->title }}"
                      endpoint="event"
                      cssclasses="btn btn--primary is-full has-icon">
                </Save>
            </div>

        @endforeach

    </div>

</section>
