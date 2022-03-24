@extends('templates.main', ['title' => 'Search Offers'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/offers.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    @include('shared.header')

    <div id="search-container">
        <form class="search" action="{{ \App\Providers\RouteServiceProvider::OFFERS }}">
            @csrf

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
                <div class="case-line">
                    <h4>Case: </h4><h4 class="case-name">{{ $offer->caseName() }}</h4>
                </div>

                <div class="company-line">
                    <p>Company: {{ $offer->companyName() }}</p>

                    @if($offer->insurer->user->isVerified())
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <title>Verified account</title>
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>

                <h5>{{ $offer->description }}</h5>

                <div class="request-button-container">
                    <h3 class="request-info-count">{{ $offer->requests->count() }}</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="request-info" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>

                    <a href="{{ \App\Providers\RouteServiceProvider::OFFER . '/' . $offer->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <br/>
            </article>
        @empty
            <div class="no-offers">
                <h1>Oops!</h1>
                <p>Looks like there is no offers for you!</p>
            </div>
        @endforelse
    </main>
@endsection
