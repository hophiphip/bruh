@extends('templates.main', ['title' => 'Sign Up'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/sign-up.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    @include('shared.header-logo')

    <div class="content">
        <div class="center-card">
            @if(!session()->has('success'))
                <h1>Create account</h1>

                <form class="sign-form" action="{{ \App\Providers\RouteServiceProvider::SIGN_UP }}" method="post">
                    @csrf

                    <div class="space">
                        <input type="text" name="first_name" id="first_name" class="input" placeholder="First Name" value="{{ old('first_name') }}">
                    </div>
                    @error('first_name')
                    <p class="error">{{ $message }}</p>
                    @enderror

                    <div class="space">
                        <input type="text" name="last_name" id="last_name" class="input" placeholder="Last Name" value="{{ old('last_name') }}">
                    </div>
                    @error('last_name')
                    <p class="error">{{ $message }}</p>
                    @enderror

                    <div class="space">
                        <input type="text" name="company_name" id="company_name" class="input" placeholder="Company Name" value="{{ old('company_name') }}">
                    </div>
                    @error('company_name')
                    <p class="error">{{ $message }}</p>
                    @enderror

                    <div class="space">
                        <input type="email" name="email" id="email" class="input" placeholder="Email Address" value="{{ old('email') }}">
                    </div>
                    @error('email')
                    <p class="error">{{ $message }}</p>
                    @enderror

                    <button class="submit-button">Create account</button>
                </form>
            @else
                <p class="message">Please follow the link sent to your email to verify your account.</p>
            @endif
        </div>
    </div>
@endsection
