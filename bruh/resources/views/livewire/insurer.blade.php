@section('title')
    <title>Insurer</title>
@endsection

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/insurer.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/local/alpine-local.min.js" defer></script>
@endsection

@section('content')
    @include('shared.header-logo')

    <div>
        <div class="user-info">
            @if($insurer->firstOrFail()->user()->firstOrFail()->isVerified())

                <svg x-on:click="alert(1)" class="mail-logo" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <title>Check offer requests</title>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>

                <svg class="verified-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <title>Verified account</title>
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            @endif

            <h3 class="user-company tooltip">
                <abbr title="{{ $email }}">
                    {{ $insurer->company_name }}
                </abbr>
            </h3>

            <a href="{{ \App\Providers\RouteServiceProvider::LOGOUT }}">
                <button class="logout-button">
                    <p>Logout</p>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </a>
        </div>

        <main class="offers-list">
            @forelse ($offers as $offer)
                <article class="offer">
                    <div class="case-line">
                        <h4>Case: </h4><h4 class="case-name">{{ $offer->caseName() }}</h4>
                    </div>

                    <h5>{{ $offer->description }}</h5>

                    <div class="offer-requests">
                        @forelse($offer->requests()->get() as $request)
                            <div class="request-info">

                                <h4 class="request-email">
                                    Email:
                                    <abbr title="Copy to clipboard">
                                        {{ $request->email }}
                                    </abbr>
                                </h4>

                                <h5>Country: {{ $request->location()["country"] ?? "Not set" }}</h5>
                            </div>
                        @empty
                            <h1>No requests!</h1>
                        @endforelse
                    </div>

                    <br/>
                </article>
            @empty
                <div class="no-offers">
                    <h1>Looks like you've got no offers</h1>
                    <p>Start by creating a new offer</p>
                </div>
            @endforelse
        </main>
    </div>

@endsection
