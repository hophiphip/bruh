<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title>Bruh</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
<div id="app">
    <nav class="navbar navbar-findcond">

        <div class="container">
            <div class="navbar-header">

                <!-- TODO: route/mix is BAD in prod -->
                <!-- For later: https://stackoverflow.com/questions/29912997/laravel-routes-behind-reverse-proxy -->

                <a class="navbar-brand" href="{{ route('index') }}">Home page</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active">
                        <a href="{{ route('new') }}">Observe offers</a>
                    </li>
                </ul>
            </div>

        </div>

    </nav>
    @yield('content')
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
