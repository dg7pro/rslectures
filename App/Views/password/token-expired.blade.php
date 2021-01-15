@extends('layouts.boot')

@section('content')

    <div class="container">

        <h3 class="text-success mt-5">Request New Password Reset</h3>
        <p>Password reset link invalid or expired, please <a href="{{'/password/forgot'}}">click here</a> to request another one.</p>

    </div>

@endsection