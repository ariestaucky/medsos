<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- This makes the current user's id available in javascript -->
    @if(!auth()->guest())
        <script>
            window.userId = {!! auth()->user()->id !!}
        </script>
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Medsos') }}</title>

    <!-- Favico -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="MedSos">
    <meta name="application-name" content="MedSos">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- FB SDK -->
    <script>
        //Load the JavaScript SDK asynchronously
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

</head>
<body>
    <div id="app">
        @include('inc.navbar')
        <!-- @if(Request::is('home'))
            <marquee behavior="scroll" direction="left"><p class="font-weight-light text-muted narrow-hr"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Notice</strong>: Block and Report isn't functional yet!</p></marquee>
        @endif -->
        <main class="py-4 contain">    
            @yield('content')
        </main>
    </div>
    @if(Request::is('/') OR Request::is('ToS') OR Request::is('Privacy') OR Request::is('contact-us') OR Request::is('cookie') OR Request::is('about'))
        @include('inc.footer')
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>

    @if(Request::is('profile/*'))
    <script src="{{ asset('js/galery.js') }}" defer></script>
    @endif
</body>
</html>
