<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title>{{ $title }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('styles')
</head>

<body>
    @yield('content')
</body>
</html>
