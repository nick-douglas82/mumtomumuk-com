<section class="cards popular-services">
    <h2 class="cards__title">Popular Services</h2>

    <div class="cards__wrap grid-x grid-margin-x">

        @foreach($services as $service)
                <div class="card cell medium-4">
                <a href="{{ $service->url(Request::segment(1), 'directory') }}">
                    <img src="{{ asset($service->getFirstMediaUrl('default', 'category_image')) }}" class="card__image">
                    <h3 class="card__title">{{ $service->name }}</h3>
                </a>
            </div>
        @endforeach

    </div>

</section>
