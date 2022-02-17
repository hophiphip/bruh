@component('mail::message')
    To finish logging in please follow the link below
    @component('mail::button', ['url' => $url])
        Click to Login
    @endcomponent
@endcomponent
