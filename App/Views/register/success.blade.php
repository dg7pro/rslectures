@extends('layouts.boot')

@section('content')

    <div class="container mt-5">

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <h3 class="text-success mt-5">Account Created Successfully</h3>
        <p>Please check your email for activation link</p>

    </div>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>

    @include('layouts.footer2')

@endsection