@if (!is_null(Request::segment(1)))
    <a href="{{ url(Request::segment(1)) }}" class="site-logo">
        <img src="/images/logo.jpg">
    </a>
@else
    <a href="{{ url('/') }}" class="site-logo">
        <img src="/images/logo.jpg">
    </a>
@endif
