<header class="header">
    <a class="logo" href="/">
        <div>bruh!</div>
    </a>

    <div class="padding"></div>

    @if(! Illuminate\Support\Facades\Auth::check())
        <a class="for-log-in" href="{{ \App\Providers\RouteServiceProvider::LOGIN }}">
            <button>Log In</button>
        </a>
    @endif

    <a class="for-insurers" href="{{ \App\Providers\RouteServiceProvider::INSURER }}">
        <button>For insurers</button>
    </a>
</header>
