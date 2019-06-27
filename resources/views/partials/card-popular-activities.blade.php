<section class="cards popular-activites">
    <h2 class="cards__title">Popular Activities</h2>

    <div class="cards__wrap grid-x grid-margin-x">

        @foreach($activities as $activity)
            <div class="card cell medium-4">
                <a href="{{ $activity->url(Request::segment(1), 'places-to-go') }}">
                    <img src="{{ asset($activity->getFirstMediaUrl('default', 'category_image')) }}" class="card__image">
                    <h3 class="card__title">{{ $activity->name }}</h3>
                </a>
            </div>
        @endforeach

    </div>

</section>
