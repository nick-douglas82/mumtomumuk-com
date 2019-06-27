@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $holidayidea])
    @include('meta.facebook', ['item' => $holidayidea])
    @include('meta.twitter', ['item' => $holidayidea])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header-sub', ['title' => 'Holiday Ideas'])

<section class="grid-x grid-margin-x">

    <header class="cell blog__information">
        <h1 class="blog__title">{{ $holidayidea->title }}</h1>
    </header>

</section>

<section class="grid-x grid-margin-x">
    <div class="cell medium-8 post__content">
        <div class="blog__specs">
            <time datetime="{{ $holidayidea->created_at->format('Y-m-d') }}" class="has-icon">
                <i class="icon icon--calendar"></i>
                {{ $holidayidea->postDate() }}
            </time>

            <div class="blog__by has-icon">
                <i class="icon icon--user"></i>
                Posted by {{ $holidayidea->user->name }}
            </div>
        </div>
    </div>

    <div class="cell medium-8 blog__content">
        <img src="{{ $holidayidea->getFirstMediaUrl('default', 'post') }}" alt="">
        {!! $holidayidea->body !!}

        @if (! empty($holidayidea->content))
            @foreach (unserialize($holidayidea->content) as $content)
                {!! $content !!}
            @endforeach
        @endif

        @include('partials.social-share')

        <div class="blog__comments">

            <h2 class="comments__title">User comments</h2>

            @if ($holidayidea->allow_comments)
                <Comments :data="{{ $holidayidea }}"></Comments>

                @if (Auth::check())
                    <Comment :data="{{ $holidayidea }}"></Comment>
                @else
                    @include('partials.comment-login')
                @endif

            @else
                <p>Comments are current closed.</p>
            @endif

        </div>

        @include('adverts.partials.leaderboard')
    </div>

    <aside class="cell medium-4">
        @include('adverts.partials.mpu')
    </aside>
</section>

@endsection
