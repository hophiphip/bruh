@section('title')
    <title>Admin panel</title>
@endsection

@section('styles')
    <link href="/css/header.css" rel="stylesheet" type="text/css">
    <link href="/css/control-panel.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/local/alpine-local.min.js" defer ></script>
@endsection

<div>
    @include('shared.header-logo')

    @forelse($users as $user)
        <div x-data="{ isVerified: {{ $user->isVerified() ? 1 : 0 }} === 1 }" class="user">
            <h4>{{ $user->email }}</h4>
            <h5 x-text="isVerified ? 'Status: is verified' : 'Status: not verified'"></h5>
            <button x-on:click="isVerified = !isVerified" wire:click="toggleVerified({{ $user->id }})">Toggle verified</button>
        </div>
    @empty
        <h1>No users</h1>
    @endforelse
</div>
