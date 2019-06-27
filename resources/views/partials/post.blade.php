<div class="post">
    <a href="{{ $post->url(Request::segment(1)) }}">
        <div class="post__image-wrap">
            @if ($post->category()->exists())

            <div class="post__tag post__tag--blog">
                <span>{{ $post->category->name }}</span>
            </div>

            @endif

            <img src="{{ $post->getFirstMediaUrl('default', 'listing') }}" class="post__image">
        </div>
        <div class="post__content-wrap">
            <h2 class="post__title">{{ $post->title }}</h2>
            <div class="post__content">{!! Str::words($post->snippet, 12) !!}</div>
        </div>
    </a>
</div>
