@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="row mt-5 mb-5">
            <div class="col-lg-6">

                @include('layouts.partials.flash')

                <h3 class="text-primary mb-3">Forgot Password ?</h3>
                <form action="{{'/Password/request-reset'}}" method="POST">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter your email" autofocus required>
                        <small id="emailHelp" class="form-text text-muted">Please enter your registered email address.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Reset Link</button>

                </form>

            </div>
        </div>

    </div>

@endsection