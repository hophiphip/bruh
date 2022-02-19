@extends('templates.main', ['title' => 'Getting Started'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/getting-started.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    @include('shared.header-logo')

    <div class="title-contents">
        <h1>Getting Started</h1>
    </div>

    <div class="centered">
        <div class="content">

            <div class="separator-line on-breakpoint"></div>

            <div class="centered-tile">
                <p>Create a new insurer account.</p>

                <a href="{{ \App\Providers\RouteServiceProvider::SIGN_UP }}">
                    <button class="submit-button">Create new account</button>
                </a>
            </div>

            <div class="separator-line"></div>

            <div class="centered-tile">
                <p>Sign in with existing account.</p>

                <a href="{{ \App\Providers\RouteServiceProvider::LOGIN }}">
                    <button class="submit-button">Sign In</button>
                </a>
            </div>
        </div>
    </div>
@endsection
