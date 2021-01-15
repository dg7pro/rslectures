@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="row mt-5 mb-5">
            <div class="col-lg-6">

                @include('layouts.partials.flash')

                <h3 class="text-primary mb-3">Reset Password</h3>

                <form action="{{'/password/reset-password'}}" method="POST">

                    <input type="hidden" name="token" value="{{ $token }}" />

                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" aria-describedby="passwordHelp" placeholder="New Password">
                        <small id="passwordHelp" class="form-text text-muted">Password must be min 8 characters alpha-numeric</small>
                    </div>

                    <button type="submit" name="reset-password-submit" value="Reset Password" class="btn btn-primary">Reset Password</button>

                </form>
            </div>
        </div>

    </div>

@endsection