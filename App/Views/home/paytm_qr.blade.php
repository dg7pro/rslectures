@extends('layouts.boot')

@section('content')

    <div class="container">


        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-info mt-4">Make Payment</h2>
                <p><i>You can make payment through: Paytm, G-Pay PhonePe</i></p>

                <div class="text-center">
                    <img src="/images/paytm_qr.png" class="rounded img-fluid" alt="Paytm qr code here">
                </div>
            </div>
        </div>

    </div>

    @include('layouts.footer2')



@endsection

