@extends('layouts.user')

@section('content')
<div id="app">

    <div class="user__container">
        @include("user.sidebar")

        <section class="user__content has-activity">

            <div class="user__content-wrap">
                <header class="user__header">
                    <div class="title">My Reviews</div>
                </header>

                <main class="content events overflow">
                    @if (!is_null($events) && $events->count() > 0)
                        @include("user.partials.events.reviews")
                    @else
                        <div class="feed__empty">
                            <p>You haven&apos;t written any reviews yet...</p>
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
