@extends('layouts.app')

@section('metadata')
    @include('meta.meta', ['item' => $page])
    @include('meta.facebook', ['item' => $page])
    @include('meta.twitter', ['item' => $page])
@endsection

@section('billboard')
    @include('adverts.partials.billboard')
@endsection

@section('content')

@include('partials.page-header')

@include('partials.hero')

<main class="grid-x">

    <div class="main cell medium-8">

        @include('partials.card-review')

        @include('partials.card-feature-events')

        @include('partials.card-popular-activities')

        @include('partials.card-popular-services')

        @include('adverts.partials.leaderboard')

    </div>

    <aside class="sidebar cell medium-4">

        <div class="pullout pullout--sidebar pullout--primary">
            Over the past 5 years we have raised over <strong>£5,414</strong> for local charities
        </div>

        <div class="pullout pullout--sidebar pullout--secondary pullout--newsletter">
            Sign up to our newsletters
            @include('forms.signups.mailchimp')
        </div>

        @include('adverts.partials.mpu')

    </aside>

</main>

@endsection
