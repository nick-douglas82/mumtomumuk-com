<article class="review__item {{ ($review->source === 'facebook' ? 'is-facebook' : '') }}">
    <header class="review__header">
        <img src="{{ $review->user->avatar() }}" class="review__avatar">

        <div class="review__details">
            @if ($review->user)
                <div class="review__name">{{ $review->user->name }}</div>
            @endif
            <div class="review__date">Reviewed
                <time datetime="{{ $review->created_at->format('Y-m-d') }}">{{ $review->created_at->format('d F') }}</time>{{ ($review->source === 'facebook' ? ', from Facebook' : '.') }}</div>
        </div>
    </header>
    <section class="review__content">
        {!! $review->body !!}
    </section>
</article>