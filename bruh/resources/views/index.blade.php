<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title>Bruh</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
</head>

<body>
    @include('shared.header')

    <main class="main">
        <h1 class="welcome">Some text</h1>

        <form class="search" action="/offers">
            <input type="text" placeholder="Search.." name="q">

            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </form>

        <div class="stats-container">
            <div class="stats">
                <div class="stat">
                    <div class="title">Registered insurers</div>
                    <p class="counter">{{ $insurers_count }}</p>
                </div>

                <div class="stat">
                    <div class="title">Published offers</div>
                    <p class="counter">{{ $offers_count }}</p>
                </div>

                <div class="stat">
                    <div class="title">Requests count</div>
                    <p class="counter">42</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
