<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('metadata')

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <script>
        window.App = {!! json_encode([
            'user'     => (Auth::check() ?  Auth::user() : ''),
            'signedIn' => Auth::check(),
            'site'     => Request::segment(1),
            'algolia'  => [
                'id'  => config('scout.algolia.id'),
                'key' => config('scout.algolia.key')
            ]
        ]) !!};
    </script>
</head>
<body>

    <div id="app" class="grid-container">
        @yield('billboard')

        @include('partials.header')

        @yield('content')

        @include('partials.footer')

        <Flash message="{{ session('flash') }}"></Flash>

        <Loginmodal></Loginmodal>
        <Registermodal></Registermodal>

    </div>

    <!-- Scripts -->
    @yield('scripts')
    <script src="{{ mix('js/app.js') }}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111243779-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-111243779-1');
    </script>

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
