@component('mail::message')
    To complete sign up please follow the link below
    @component('mail::button', ['url' => $url])
        Sign up
    @endcomponent
@endcomponent
