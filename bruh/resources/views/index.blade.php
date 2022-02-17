@extends('templates.main', ['title' => 'Bruh'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    @include('shared.header')

    <main class="main">
        <h1 class="welcome">Some text</h1>

        <form class="search" action="{{ \App\Providers\RouteServiceProvider::OFFERS }}">
            @csrf

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
@endsection


