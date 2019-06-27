<div class="blog__comments">
    <h2 class="comments__title">User comments</h2>

    @if ($post->allow_comments)

        @foreach ($comments as $comment)
            <div class="comment">
                <header class="comment__header">
                    <img src="{{ $comment->user->avatar() }}" class="comment__avatar">
                    <div class="comment__user">
                        <div class="comment__name">{{ $comment->user->name }}</div>
                        <time class="comment__date" datetime="{{ $comment->created_at }}">Reviewed {{ $comment->created_at->diffForHumans() }}</time>
                    </div>
                </header>
                <div class="comment__contents">
                    {{ $comment->body }}
                </div>
            </div>
        @endforeach

        @if (Auth::check())
            <Comment slug="{{ $post->slug }}"></Comment>
        @else
            @include('partials.comment-login')
        @endif

    @else
        <p>Comments are current closed.</p>
    @endif
</div>
