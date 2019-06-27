<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="user-profile-wrap {{ $htmlclass }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script>
        window.App = {!! json_encode([
            'user'     => (Auth::check() ?  Auth::user() : ''),
            'signedIn' => Auth::check(),
            'site'     => Request::segment(1)
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <main class="user-area">

            <aside id="user-sidebar" class="user-area__sidebar">

                <header class="sidebar__header">
                    <a href="#" id="sidebar-toggle" class="sidebar__toggle">
                        <span></span>
                    </a>
                </header>

                @yield('sidebar')

            </aside>

            <section class="user-area__container">
                <a href="/{{ Request::segment(1) }}" class="back__text">
                    <span class="chevron left"></span>
                    Back to Milton Keynes
                </a>

                <header class="user-area__header">
                    @yield('title')

                    @if (Auth::check())
                        <div class="header__user">
                            <span class="user__name">{{ Auth::user()->name }}</span>
                            {{-- <span class="chevron bottom"></span> --}}
                        </div>
                    @endif
                </header>

                <section class="user-area__content-wrap">

                    @yield('content-header')

                    <div id="user-area-content" class="user-area__content">

                        @yield('content')

                    </div>

                </section>
            </section>
        </main>
    </div>

    <!-- Scripts -->
    @yield('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    @if (App::environment('live'))
        <script>
        // <![CDATA[
        (function(mt) {
            var mtscript = document.createElement('script');
            mtscript.type = 'text/javascript';
            mtscript.async = true;
            mtscript.src = ('https:' == document.location.protocol ? 'https://' : 'http://') +
                            'analytics.monkeytracker.cz/resource/' +
                            '3f532df1e4d80501d010de00c8f17685' +
                            '/monkeytracker.min.js';
            var s=document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mtscript, s);
            })(window.MonkeyTracker = window.MonkeyTracker || {});
        // ]]>
        </script>
    @endif
</body>
</html>
