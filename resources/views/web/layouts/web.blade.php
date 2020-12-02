<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-28079315-10"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-28079315-10');
    </script>



    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#607d8b" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(!strpos(Request::url(), 'tuto') !== false || strpos(Request::url(), 'conference') !== false)
    <title>{{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Styles -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" async>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700" async>
    <link rel="stylesheet" href="{{ mix('css/web/vendor/all.css') }}">
    <script defer src="{{ mix('js/web/vendor/all.js') }}"></script>
    <link href="{{ mix('css/web/app.css') }}" rel="stylesheet">
    @yield('css')
    @yield('seo')
</head>

<body>
    <div id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script>
        const publicPath = "{!! url('/') !!}"
    </script>
    <script src="{{ mix('js/web/app.js') }}"></script>
    @yield('js')
</body>

</html>