@extends('layouts.user')

@section('content')
<div id="app">

    <div class="user__container">
        @include("user.sidebar")

        <section class="user__content has-activity">

            <div class="user__content-wrap">
                <header class="user__header">
                    <div class="title">My Baby &amp; Toddler Groups</div>
                </header>

                <main class="content events overflow">
                    @if ($events->count() > 0)
                        @include("user.partials.events.baby-toddler")
                    @else
                        <div class="feed__empty">
                            <p>There are no baby &amp; toddler groups saved yet...</p>
                            <p>Visit the <a href="{{ url(Request::segment(1)) }}/baby-toddler-groups">baby &amp; toddler groups section</a> to see if anything takes your fancy!</p>
                        </div>
                    @endif
                </main>

            </div>

            <div class="user__activity-feed activity-feed">
                <header class="activity-feed__header">
                    <div class="title">My Activity Feed</div>
                </header>

                @include("user.partials.activity.feed")

            </div>
        </section>
    </div>

</div>
@endsection
