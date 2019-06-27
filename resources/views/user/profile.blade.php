@extends('layouts.user')

@section('content')
<div id="app">

    <div class="user__container">
        @include("user.sidebar")


        <section class="user__content has-activity">

            <Profile
                firstname="{{ Auth::user()->firstName() }}"
                lastname="{{ Auth::user()->lastName() }}"
                email="{{ Auth::user()->email }}"
                usingsocial="{{ Auth::user()->usingSocialAccount() }}"
                provider="{{ Auth::user()->provider }}">
            </Profile>

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
