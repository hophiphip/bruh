<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bruh</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="app">
        <navbar-user-mode :is-client="false"></navbar-user-mode>

        <sign-bar sign-in-url="new" sign-up-url="new"></sign-bar>

        <search-form></search-form>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
