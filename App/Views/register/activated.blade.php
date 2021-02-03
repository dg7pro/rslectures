@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="content">
            <div class="row mt-5">
                <div class="col-md-7 offset-md-1">

                    @include('layouts.partials.flash')

                    <div class="card card-default card-lg mb-5 my-form" style="background-color: #e5bbae">
                        <div class="card-header card-header-border-bottom justify-content-center bg-success text-white mb-3 px-5">
                            <h3>Account Activated</h3>
                            <span class="mb-3 badge badge-dark">Welcome</span>
                        </div>
                        <div class="card-body px-5">
                           {{-- <p>Please login to continue:
                                <a class="btn btn-success" href="{{'/Login/index'}}">Login Now</a>
                            </p>--}}
                            <p>Click here to continue:
                                <a class="btn btn-success" href="{{'/subscribe/index'}}">Next Step</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('layouts.footer2')

@endsection

@section('script')



@endsection