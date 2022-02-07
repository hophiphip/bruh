@extends('templates.index')

@section('content')
    <div class="container">
        <div class="card">

            <div class="card-header">
                Offers <small>({{ $offers->count() }})</small>
            </div>

            <div class="card-body">

                <form action="{{ url('offers') }}" method="get">
                    <div class="form-group">
                        <input
                            type="text"
                            name="q"
                            class="form-control"
                            placeholder="Search..."
                            value="{{ request('q') }}"
                        />
                    </div>
                </form>

                <br/>

                <!-- TODO: Need card of whatever/ and mb. do not submit form page each time but do REST request and update via JS in Vue -->
                @forelse ($offers as $offer)
                    <article class="mb-3">
                        <h4>Case: {{ $offer->getCaseName() }}</h4>
                        <p class="m-0">Company: {{ $offer->getCompanyName() }}</p>
                        <h5 class="m-0">{{ $offer->description }}</h5>
                        <br/>
                    </article>
                @empty
                    <p>No offers found</p>
                @endforelse
            </div>

        </div>
    </div>
@endsection
