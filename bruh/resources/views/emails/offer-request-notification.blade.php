@component('mail::message')
    New request for your offer has been submitted!
    @component('mail::button', ['url' => $url])
        View Request
    @endcomponent
@endcomponent
