@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="row mt-5 mb-5 px-2">
            <div class="col-lg-6 ">

                @include('layouts.partials.flash')

                <h3 class="text-primary mb-5">Edit Profile</h3>


                <form action="{{'#'}}" method="POST">
                    <h5>Email Address:</h5>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Account email" value="{{$user->email}}" aria-label="Account email" aria-describedby="button-addon2" disabled>
                        <div class="input-group-append">
                            @if(!$user->ev)
                                <button class="btn btn-primary" type="submit" id="button-addon2">Verify</button>
                            @else
                                <button class="btn btn-success disabled" id="button-addon2" disabled>Verified</button>
                            @endif

                        </div>
                    </div>

                </form>


                <form action="{{'#'}}" method="POST" class="mt-5">
                    <h5>Mobile No:</h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="User's Mobile" value="{{'+91 '.$user->mobile}}" aria-label="User's Mobile" aria-describedby="button-addon2" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Verify</button>
                        </div>
                    </div>

                </form>


                <form action="{{'/account/change-password'}}" method="POST" class="mt-5">
                    <h5>Change Password:</h5>

                    <div class="input-group mb-3">
                        <input type="password" name="current_password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Current Password">
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="New Password">
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Confirm Password">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>


                </form>

            </div>
        </div>

    </div>

    @include('layouts.footer2')

@endsection