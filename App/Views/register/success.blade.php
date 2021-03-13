@extends('layouts.boot')

@section('content')

    <div class="container mt-5">

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <h3 class="text-success mt-5">Account Created Successfully</h3>
        <p>Please check your email for activation link</p>


        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Important!</h4>
            <ul>
                <li><i class="fas fa-angle-right"></i> Account Activation link has been send to your registered email address</li>
                <li><i class="fas fa-angle-right"></i> Click on <strong><u>Activate my Account</u></strong> button to activate your account </li>
                <li><i class="fas fa-angle-right"></i> Sometimes email goes into <strong><u>Promotions</u></strong> or <strong><u>Spam</u></strong> folder, please double check your email </li>
            </ul>
            <hr>
            <p class="mb-0">Happy Learning - from RSLectures.com</p>
        </div>

    </div>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>

    @include('layouts.footer2')

@endsection