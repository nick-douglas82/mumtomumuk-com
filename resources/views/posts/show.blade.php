@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $post])
    @include('meta.facebook', ['item' => $post])
    @include('meta.twitter', ['item' => $post])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => 'Blog'])

<section class="grid-x grid-margin-x">

    <header class="cell blog__information">
        <h1 class="blog__title">{{ $post->title }}</h1>
    </header>

</section>

<section class="grid-x grid-margin-x">
    <div class="cell medium-8 post__content">
        <div class="blog__specs">
            <time datetime="{{ $post->created_at->format('Y-m-d') }}" class="has-icon">
                <i class="icon icon--calendar"></i>
                {{ $post->postDate() }}
            </time>

            <div class="blog__by has-icon">
                <i class="icon icon--user"></i>
                Posted by {{ $post->user->name }}
            </div>
        </div>
    </div>
    <div class="cell medium-8 blog__content">

        <img src="{{ $post->getFirstMediaUrl('default', 'post') }}" alt="">
        {!! $post->body !!}

        <div class="flexi-content">
            @if (!empty($post->content))
                @foreach (unserialize($post->content) as $content)
                    {!! $content !!}
                @endforeach
            @endif
        </div>
        @if ($post->body_footer)
            {!! $post->body_footer !!}
        @endif

        @include('partials.social-share')

        @include('partials.comments', ['post' => $post])

        @include('adverts.partials.leaderboard')

    </div>

    <aside class="cell medium-4">
        @include('adverts.partials.mpu')
    </aside>
</section>

@endsection
