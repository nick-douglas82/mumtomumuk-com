<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="user-profile-wrap">
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

    @yield('content')

    <!-- Scripts -->
    @yield('scripts')
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
