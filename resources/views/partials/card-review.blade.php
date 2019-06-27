<section class="cards">

    <h2 class="cards__title">Rebecca Reviews</h2>

    <div class="cards__wrap rebecca-reviews grid-x">

    @foreach ($reviews as $review)

        <div class="card cell medium-6">
            <a href="{{ $review->url(Request::segment(1)) }}">
                <img src="{{ asset($review->getFirstMediaUrl('default', 'homepage')) }}" class="card__image">
                <h3 class="card__title">{{ $review->title }}</h3>
                <p>{!! Str::words($review->body, 9) !!}</p>
            </a>
        </div>

    @endforeach

    </div>

</section>
