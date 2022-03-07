<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    @yield('title')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @livewireStyles

    @yield('styles')
    @yield('scripts')
</head>

<body>
    @yield('content')

    @livewireScripts
</body>
</html>
