@extends('templates.main', ['title' => 'Request insurance service'])

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/offer.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/local/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    @include('shared.header')

    @if(!session()->has('success'))
    <div class="content">
        <div class="top-note">
            <article class="offer">
                <div class="case-line">
                    <h4>Case: </h4><h4 class="case-name">{{ $offer->caseName() }}</h4>
                </div>

                <div class="company-line">
                    <p>Company: {{ $offer->companyName() }}</p>

                    <!-- TODO: Unoptimized: use JOIN with SELECT -->
                    @if($offer->insurer()->firstOrFail()->user()->firstOrFail()->isVerified())
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <title>Verified account</title>
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="not-verified" viewBox="0 0 20 20" fill="currentColor">
                            <title>This account is not verified!</title>
                            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>

                <h5>{{ $offer->description }}</h5>

                <br/>
            </article>
        </div>

        <div class="center-card">
            <h3>Request insurance service</h3>

            <form action="{{ \App\Providers\RouteServiceProvider::OFFER . '/' . $offer->id }}" method="post">
                @csrf

                <div class="space">
                    <input type="email" name="email" id="email" class="input" placeholder="Email Address"
                           value="{{ old('email') }}">

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

                        <input id="captcha-input" type="text" class="form-control" placeholder="Enter Captcha"
                               name="captcha" value="{{ "" }}">
                    </div>

                    @error('captcha')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- CAPTCHA -->

                <button type="submit" class="submit-button">Request service</button>
            </form>
        </div>
    </div>
    @else
        <div class="content">
            <div class="center-card" style="text-align: center;">
                <p class="message">Your request will be verified. Insurer will contact you via mail soon!</p>
                <a href="{{ \App\Providers\RouteServiceProvider::HOME }}">Go back</a>
            </div>
        </div>
    @endif

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
