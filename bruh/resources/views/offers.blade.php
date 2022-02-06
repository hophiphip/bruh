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

                @forelse ($offers as $offer)
                    <article class="mb-3">
                        <h2>{{ $offer->name }}</h2>
                        <p class="m-0">{{ $offer->company }}</p>
                        <h3 class="m-0">{{ $offer->description }}</h3>
                    </article>
                @empty
                    <p>No offers found</p>
                @endforelse
            </div>

        </div>
    </div>
@endsection
