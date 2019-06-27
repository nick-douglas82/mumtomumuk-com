@extends('layouts.user')

@section('content')
<div id="app">

    <div class="user__container">
        @include("user.sidebar")

        <section class="user__content has-activity">

            <div class="user__content-wrap">
                <header class="user__header">
                    <div class="title">My 4+ Activites</div>
                </header>

                <main class="content events overflow">
                    @if (!is_null($events) && $events->count() > 0)
                        @include("user.partials.events.after-school")
                    @else
                        <div class="feed__empty">
                            <p>There are no 4+ activites saved yet...</p>
                            <p>Visit the <a href="{{ url(Request::segment(1)) }}/4-plus-activites">4+ activites section</a> to see if anything takes your fancy!</p>
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
