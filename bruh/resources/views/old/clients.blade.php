@extends('old.templates.index')

@section('content')
    <clients-page clients-url="/clients"
                  insurers-url="/insurers"
                  sign-in-url="/clients/sign-in"
                  sign-up-url="/clients/sign-up">
    </clients-page>
@endsection
