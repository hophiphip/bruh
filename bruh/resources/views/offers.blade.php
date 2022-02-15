<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title>Bruh</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/offers.css" rel="stylesheet" type="text/css">
</head>

<body>
    @include('shared.header')

    <div id="search-container">
        <form class="search" action="/offers">
            <input type="text" placeholder="Search.." name="q" value="{{ request('q') }}">

            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </form>
    </div>

    <div id="stats-container">
        <p>Found</p><h1> {{ $offers->count() }} </h1><p>offers</p>
    </div>

    <main>
        @forelse ($offers as $offer)
            <article class="offer">
                <h4>Case: {{ $offer->getCaseName() }}</h4>
                <p>Company: {{ $offer->getCompanyName() }}</p>
                <h5>{{ $offer->description }}</h5>
                <br/>
            </article>
        @empty
            <div class="no-offers">
                <h1>Oops!</h1>
                <p>Looks like there is no offers for you!</p>
            </div>
        @endforelse
    </main>

</body>
</html>
