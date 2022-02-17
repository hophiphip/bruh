@extends('templates.main', ['title' => 'Bruh'])

@section('styles')
    <style>
        .content {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <h1>Logged in as {{ \Illuminate\Support\Facades\Auth::user()->name }}</h1>
        <a href="{{ \App\Providers\RouteServiceProvider::LOGOUT }}">Logout</a>
    </div>
@endsection
