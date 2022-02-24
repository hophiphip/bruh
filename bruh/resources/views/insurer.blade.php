@extends('templates.main', ['title' => 'Bruh'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">

    <style>
        body {
            margin: 0;
        }

        .content {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    @include('shared.header-logo')

    <div class="content">
        <h1>Logged in as {{ $email }} - {{ $insurer->company_name }}</h1>


        <a href="{{ \App\Providers\RouteServiceProvider::LOGOUT }}">
            <button>
                Logout
            </button>
        </a>
    </div>
@endsection
