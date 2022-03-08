@section('title')
    <title>Insurer</title>
@endsection

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/insurer.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/local/alpine-local.min.js" defer ></script>
@endsection

@section('content')
    @include('shared.header-logo')

    <div class="content">
        <div class="user-info">
            @if($insurer->firstOrFail()->user()->firstOrFail()->isVerified())
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

        <!-- Workaround reason: Blade templates can't really pass bool values tp HTML -->
        <main x-data="{ showOfferForm: {{ old('cases') ? 1 : 0 }} === 1 }" class="offers-list">

            <button class="toggle-offer-form" x-on:click="showOfferForm = !showOfferForm" x-text="showOfferForm ? 'Cancel' : 'Publish a new offer'"></button>

            <!-- Form for submitting a new offer -->
            <form action="{{ \App\Providers\RouteServiceProvider::INSURER }}" method="POST" x-show="showOfferForm" class="new-offer-form">
                @csrf

                <label for="cases">Select offer case</label>
                <select id="cases" name="cases" class="offer-case-select">
                    @foreach(\App\Models\Offer::CASES as $key => $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>

                @error('cases')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="description">Provide offer description</label>
                <textarea id="description" name="description" placeholder="Offer description.."></textarea>

                @error('description')
                    <p class="error">{{ $message }}</p>
                @enderror

                <button type="submit" class="submit-button">Submit a new offer</button>
            </form>

            <!-- Insurer offer list -->
            @forelse ($offers as $offer)
                <article class="offer" x-data="{ showRequests: false }">
                    <div class="case-line">
                        <h4>Case: </h4><h4 class="case-name">{{ $offer->caseName() }}</h4>
                    </div>

                    <h5>{{ $offer->description }}</h5>

                    <div class="request-toggle-container">
                        <svg x-show="showRequests" x-on:click="showRequests = !showRequests" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <title>Hide requests</title>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>

                        <svg x-show="!showRequests" x-on:click="showRequests = !showRequests" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <title>Show requests</title>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div x-show="showRequests" class="offer-requests">
                        @forelse($offer->requests()->get() as $request)
                            <div class="request-info">

                                <div x-data="{ isCopied: false }" class="request-email-container">
                                    <p class="request-email">
                                        Email:
                                        <abbr x-data="{ email: '{{ $request->email }}' }"
                                              x-on:click="navigator.clipboard.writeText(email); isCopied = true;"
                                              @click.outside="isCopied = false;"
                                              title="Copy to clipboard">
                                            {{ $request->email }}
                                        </abbr>
                                    </p>

                                    <svg x-show="isCopied" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>

                                <h5>Country: {{ $request->location()["country"] ?? "Not set" }}</h5>
                            </div>
                        @empty
                            <h1>No requests!</h1>
                        @endforelse
                    </div>

                    <br/>
                </article>
            @empty
                <div x-show="!showOfferForm" class="no-offers">
                    <h1>Looks like you've got no offers</h1>
                    <p>Start by creating a new offer</p>
                </div>
            @endforelse
        </main>
    </div>

@endsection
