@extends('layouts.home')

@section('content')

    <header class="landing__header">
        @include('partials.site-logo')
        <h1 class="landing-header__title">Welcome to Mum to Mum</h1>
        <h2 class="landing-header__title--sub">Local Life Directories created by parents in the community</h2>
    </header>

    <div class="grid-x grid-margin-x landing">
        <div class="cell">
            <p class="landing__text">Starting in Milton Keynes we are helping families by creating 'Local Life Directories' to collate all the inside knowledge about your home town. Our website is here to help you find local days out, baby groups, activities, events, and business services, you’ll find all this on our area websites - and lots more besides.</p>
        </div>
        @foreach ($sites as $site)
        @if ($site->isActive())
                <a href="{{ url($site->slug) }}" class="cell large-4 location is-active">
                    <img src="{{ $site->image() }}">
                    <div class="location__title">{{ $site->name }}</div>
                </a>
            @else
                <span href="{{ url($site->slug) }}" class="cell large-4 location not-active">
                    <img src="{{ $site->image() }}">
                    <div class="location__title">{{ $site->name }} - Coming soon</div>
                </span>
            @endif
        @endforeach
    </div>

    {{--  <div class="grid-x grid-margin-x landing attractions">
        <div class="cell">
            <h2>Top attractions in...</h2>
        </div>
        <div class="cell small-3">
            <img src="https://placehold.co/544x380">
            <div class="location__title">Milton Keynes</div>
        </div>
        <div class="cell small-3">
            <img src="https://placehold.co/544x380">
            <div class="location__title">Milton Keynes</div>
        </div>
        <div class="cell small-3">
            <img src="https://placehold.co/544x380">
            <div class="location__title">Milton Keynes</div>
        </div>
        <div class="cell small-3">
            <img src="https://placehold.co/544x380">
            <div class="location__title">Milton Keynes</div>
        </div>
    </div>  --}}

@endsection
