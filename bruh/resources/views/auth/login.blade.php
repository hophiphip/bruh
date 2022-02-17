@extends('templates.main', ['title' => 'Login'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/login.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    @include('shared.header-logo')

    <div class="content">
        <div class="center-card">
            @if(!session()->has('success'))
            <h1>Login</h1>

            <form action="{{ \App\Providers\RouteServiceProvider::LOGIN }}" method="post">
                @csrf

                <div class="space">
                    <input type="email" name="email" id="email" class="input" placeholder="Email Address">

                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <button class="submit-button">Login with Email</button>
            </form>
            @else
                <p class="message">Please follow the link sent to your email to continue logging in.</p>
            @endif
        </div>
    </div>
@endsection
