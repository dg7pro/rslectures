@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="content">
            <div class="row mt-5">
                <div class="col-md-7 offset-md-1">

                    @include('layouts.partials.flash')

                    <div class="card card-default card-lg mb-5 my-form" style="background-color: #e5bbae">
                        <div class="card-header card-header-border-bottom justify-content-center bg-secondary text-white mb-3 px-5">
                            <h3>Register/Signup</h3>
                            <span class="mb-3 badge badge-dark">Quick</span>
                        </div>
                        <div class="card-body px-5">
                            <form action="{{'/register/create'}}" method="POST" >

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="firstname">Firstname:
                                            <img src="/images/ring.svg" id="spinner-fn" hidden>
                                            <span id="msg-fn" class="mt-1 ml-2"> </span>
                                        </label>
                                        <input type="text" class="form-control" id="firstname" name="first_name" aria-describedby="fnHelp" placeholder="First name"
                                               value="{{ isset($arr['first_name']) ? $arr['first_name'] : '' }}">
                                        <small id="fnHelp" class="form-text text-muted">Firstname</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lastname">Lastname:
                                            <img src="/images/ring.svg" id="spinner-ln" hidden>
                                            <span id="msg-ln" class="mt-1 ml-2"> </span>
                                        </label>
                                        <input type="text" class="form-control" id="lastname" name="last_name" aria-describedby="lnHelp" placeholder="Lastname"
                                               value="{{ isset($arr['last_name']) ? $arr['last_name'] : '' }}">
                                        <small id="lnHelp" class="form-text text-muted">Title/Surname</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile:
                                        <img src="/images/ring.svg" id="spinner-3" hidden>
                                        <span id="msg-3" class="mt-1 ml-2"> </span>
                                    </label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" aria-describedby="mobileHelp" placeholder="Enter mobile"
                                           value="{{ isset($arr['mobile']) ? $arr['mobile'] : '' }}">
                                    <small id="mobileHelp" class="form-text text-muted">OTP will be sent on the number.</small>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address:
                                        <img src="/images/ring.svg" id="spinner-em" hidden>
                                        <span id="msg-em" class="mt-1 ml-2"> </span>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email"
                                           value="{{ isset($arr['email']) ? $arr['email'] : '' }}">
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password:
                                        <img src="/images/ring.svg" id="spinner-pw" hidden>
                                        <span id="msg-pw" class="mt-1 ml-2"> </span>
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="Password">
                                    <small id="passwordHelp" class="form-text text-muted">Password must be min 8 characters alpha-numeric</small>
                                </div>

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="i_agree"
                                           onchange="document.getElementById('btn-signup').disabled = !this.checked;"
                                            {{-- {{isset($arr['i_agree']) ? 'checked':''}}--}}>
                                    <label class="form-check-label" for="exampleCheck1">I Agree, check me out</label>
                                </div>

                                <button type="submit" class="btn btn-primary mb-5 center" id="btn-signup" disabled>Submit</button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('layouts.footer2')

@endsection

@section('script')

    <script>

        $(document).ready(function(){


            // ==================================
            // Name validation
            // Validating user input name
            // ==================================
            $('#firstname').blur(function () {
                var fn = $(this).val();
                $('#msg-fn').attr('hidden',true);
                $('#spinner-fn').attr('hidden',false);
                $.ajax({
                    url:"/Ajax/check-firstname",
                    method:'POST',
                    data:{fn:fn},
                    dataType:"json",
                    success:function (data) {
                        console.log(data);
                        if(data.n == 1){
                            $('#btn-join').attr('disabled',false);
                        }else{
                            $('#btn-join').attr('disabled',true);
                        }
                        setTimeout(function(){
                            $('#spinner-fn').attr('hidden',true);
                            $('#msg-fn').html(data.ht).attr('hidden',false);
                        }, 500);
                    }
                });
            });

            // ==================================
            // Name validation
            // Validating user input name
            // ==================================
            $('#lastname').blur(function () {
                var ln = $(this).val();
                $('#msg-ln').attr('hidden',true);
                $('#spinner-ln').attr('hidden',false);
                $.ajax({
                    url:"/Ajax/check-lastname",
                    method:'POST',
                    data:{ln:ln},
                    dataType:"json",
                    success:function (data) {
                        console.log(data);
                        if(data.n == 1){
                            $('#btn-join').attr('disabled',false);
                        }else{
                            $('#btn-join').attr('disabled',true);
                        }
                        setTimeout(function(){
                            $('#spinner-ln').attr('hidden',true);
                            $('#msg-ln').html(data.ht).attr('hidden',false);
                        }, 500);
                    }
                });
            });

            // ==================================
            // Mobile validation
            // Validating user input mobile
            // ==================================
            $('#mobile').blur(function () {
                var mobile = $(this).val();
                $('#msg-3').attr('hidden',true);
                $('#spinner-3').attr('hidden',false);
                $.ajax({
                    url:"/Ajax/check-mobile",
                    method:'POST',
                    data:{mb:mobile},
                    dataType:"json",
                    success:function (data) {
                        console.log(data);
                        if(data.n == 1){
                            $('#btn-join').attr('disabled',false);
                        }else{
                            $('#btn-join').attr('disabled',true);
                        }
                        setTimeout(function(){
                            $('#spinner-3').attr('hidden',true);
                            $('#msg-3').html(data.ht).attr('hidden',false);
                        }, 500);
                    }
                });
            });

            // ==================================
            // Email validation
            // Validating user input email
            // ==================================
            $('#email').blur(function () {
                var email = $(this).val();
                $('#msg-em').attr('hidden',true);
                $('#spinner-em').attr('hidden',false);
                $.ajax({
                    url:"/Ajax/check-email",
                    method:'POST',
                    data:{em:email},
                    dataType:"json",
                    success:function (data) {
                        console.log(data);
                        if(data.n == 1){
                            //$('#btn-signup').attr('disabled',false);

                        }else{
                            //$('#btn-signup').attr('disabled',true);

                        }
                        setTimeout(function(){
                            $('#spinner-em').attr('hidden',true);
                            $('#msg-em').html(data.ht).attr('hidden',false);
                        }, 500);
                    }
                });
            });

            // ==================================
            // Password validation
            // Validating user input email
            // ==================================
            $('#password').blur(function () {
                var pw = $(this).val();
                $('#msg-pw').attr('hidden',true);
                $('#spinner-pw').attr('hidden',false);
                $.ajax({
                    url:"/Ajax/check-password",
                    method:'POST',
                    data:{pw:pw},
                    dataType:"json",
                    success:function (data) {
                        console.log(data);
                        if(data.n == 1){
                            //$('#btn-signup').attr('disabled',false);

                        }else{
                            //$('#btn-signup').attr('disabled',true);

                        }
                        setTimeout(function(){
                            $('#spinner-pw').attr('hidden',true);
                            $('#msg-pw').html(data.ht).attr('hidden',false);
                        }, 500);
                    }
                });
            });

        });
    </script>

@endsection