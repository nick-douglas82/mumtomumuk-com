<aside class="user__nav-bar">

    @if (Auth::check())
        <div class="user">
            <img src="{{ Auth::user()->avatar() }}" class="user__avatar">
            <span class="user__name">{{ Auth::user()->firstName() }}</span>
        </div>
    @endif

    <ul class="user-sidebar__list">
        <li class="user-sidebar__item">
            <a href="{{ url('/' . Request::segment(1) . '/') }}" class="user-sidebar__link">Back to {{ ucwords(str_replace('-', ' ', Request::segment(1))) }}</a>
        </li>
        <li class="user-sidebar__item {{ (Request::segment(3) == 'events' ? 'is-active' : null) }}">
            <a href="{{ url('/' . Request::segment(1) . '/users/events/') }}" class="user-sidebar__link">My Events</a>
        </li>
        <li class="user-sidebar__item {{ (Request::segment(3) == 'places' ? 'is-active' : null) }}">
            <a href="{{ url('/' . Request::segment(1) . '/users/places/') }}" class="user-sidebar__link">My Places</a>
        </li>
        <li class="user-sidebar__item {{ (Request::segment(3) == 'services' ? 'is-active' : null) }}">
            <a href="{{ url('/' . Request::segment(1) . '/users/services/') }}" class="user-sidebar__link">My Services</a>
        </li>
        <li class="user-sidebar__item {{ (Request::segment(3) == '4-plus-activites' ? 'is-active' : null) }}">
            <a href="{{ url('/' . Request::segment(1) . '/users/4-plus-activites/') }}" class="user-sidebar__link">My 4+ Activities</a>
        </li>
        <li class="user-sidebar__item {{ (Request::segment(3) == 'baby-toddler' ? 'is-active' : null) }}">
            <a href="{{ url('/' . Request::segment(1) . '/users/baby-toddler/') }}" class="user-sidebar__link">My Baby &amp; Toddler Groups</a>
        </li>
        <li class="user-sidebar__item {{ (Request::segment(3) == 'reviews' ? 'is-active' : null) }}">
            <a href="{{ url('/' . Request::segment(1) . '/users/reviews/') }}" class="user-sidebar__link">My Reviews</a>
        </li>
        <li class="user-sidebar__item {{ (Request::segment(3) == 'profile' ? 'is-active' : null) }}">
            <a href="{{ url('/' . Request::segment(1) . '/users/profile/') }}" class="user-sidebar__link">My Profile</a>
        </li>
        <li class="user-sidebar__item">
            <a href="{{ url('logout') }}" class="user-sidebar__link">Logout</a>
        </li>
    </ul>

</aside>
