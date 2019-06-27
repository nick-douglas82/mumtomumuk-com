<nav class="user-nav">
    <ul class="user-nav__list o-list-bare">

        <li class="user-nav__item">
            <a href="{{ url('milton-keynes/planner') }}/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="user-nav__link btn btn--planner has-icon">
                <i class="icon icon--calendar-filled"></i>
                Planner
            </a>
        </li>

        @if (Auth::check())
            <Login></Login>
            @else
            <Signinbutton></Signinbutton>
        @endif

    </ul>
</nav>
