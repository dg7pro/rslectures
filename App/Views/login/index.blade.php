@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="content">
         <div class="row mt-5">
            <div class="col-xl-5 col-lg-6 col-md-9 offset-md-1">

                @include('layouts.partials.flash')

                <div class="card card-default mb-5 my-form" style="background-color: #e5bbae">
                    <div class="card-header card-header-border-bottom justify-content-center bg-secondary text-white mb-3 px-5">
                        <h3>Account Login</h3>
                        <span class="mb-3 badge badge-dark">Quick</span>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{'/Login/authenticate'}}" method="POST">

                            {{--<input type="hidden" name="csrf_token" value="{{$csrf_token}}">--}}

                            <div class="form-row">
                                <div class="form-group col-md-12 mb-4">
                                    <input type="email" class="form-control input-lg" id="uid" name="uid" placeholder="Email"
                                           value="{{ isset($uid) ? $uid : '' }}" required>
                                </div>

                                <div class="form-group col-md-12 mb-4">
                                    <input type="password" class="form-control input-lg" id="password" name="password" placeholder="Your Password..." required>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex my-2 justify-content-between">
                                        <div class="d-inline-block mr-3">
                                            <label class="control control-checkbox checkbox-primary">
                                                <span class="text-muted font-size-16">Remember Me</span>
                                                <input type="checkbox" id="remember-me" name="remember_me"/>
                                                <div class="control-indicator"></div>
                                            </label>
                                        </div>
                                        <p><a class="text-primary" href="{{'/Password/forgot'}}">Forgot Your Password?</a></p>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-info btn-lg btn-block mb-3" name="login-submit" type="submit">{{'Log in'}}</button>
                            <p>Don't have an account yet ?
                                <a href="{{'/register/index'}}">Sign Up</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        </div>

    </div>

    @include('layouts.footer2')

@endsection