@extends('templates.main', ['title' => 'Login'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/login.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/local/jquery-3.6.0.min.js"></script>
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
                        <input type="email" name="email" id="email" class="input" placeholder="Email Address" value="{{ old('email') }}">

                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CAPTCHA -->
                    <div class="captcha-field">
                        <div class="captcha-title">
                            <h4>Solve captcha to continue</h4>
                        </div>

                        <div class="captcha">
                            <span title="Click to refresh" id="captcha-span">{!! captcha_img() !!}</span>

                            <input id="captcha-input" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" value="{{ "" }}">
                        </div>

                        @error('captcha')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- CAPTCHA -->

                    <button type="submit" class="submit-button">Login with Email</button>
                </form>
            @else
                <p class="message">Please follow the link sent to your email to continue logging in.</p>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        $('#captcha-span').click(() => {
           $.ajax({
               type: 'GET',
               url: '{{\App\Providers\RouteServiceProvider::REFRESH_CAPTCHA}}',
               success: data => {
                   $('#captcha-span').html(data.captcha);
               },
           })
        });
    </script>
@endsection
