<nav class="site-nav grid-x">
    <ul class="site-nav__list o-list-bare cell">
        <li class="site-nav__item {{ (Request::segment(2) == 'baby-toddler-groups' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/baby-toddler-groups') }}" class="site-nav__link">Baby &amp; toddler groups</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == '4-plus-activites' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/4-plus-activites') }}" class="site-nav__link">4+ Activites</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == 'events' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/events') }}" class="site-nav__link">Events</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == 'places-to-go' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/places-to-go') }}" class="site-nav__link">Places to go</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == 'directory' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/directory') }}" class="site-nav__link">Directory</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == 'blog' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/blog') }}" class="site-nav__link">Blog</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == 'holiday-ideas' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/holiday-ideas') }}" class="site-nav__link">Holiday Ideas</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == 'askmum' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/askmum') }}" class="site-nav__link">Ask mum</a>
        </li>
        <li class="site-nav__item {{ (Request::segment(2) == 'about-us' ? 'is-active' : null) }}">
            <a href="{{ url(Request::segment(1) . '/about-us') }}" class="site-nav__link">About</a>
        </li>
    </ul>
</nav>
