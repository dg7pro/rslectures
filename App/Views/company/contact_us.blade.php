@extends('layouts.boot')

@section('custom-css')
    <style>
        .contact-image {
            height:170px;
            width:100%;
            background-size:cover;
        }
    </style>

@endsection

@section('content')



    <div class="container mt-5">
        <div class="row">
            <div class="col-sm text-center">
                <h1 class="mb-5">Contact Us</h1>
            </div>
        </div>

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <form method="post" action="{{'/company/submit-contact'}}">
                    <div class="form-group">
                        <input type="text" name="c_name" class="form-control" id="exampleInputName" placeholder="Your Full Name..." required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="c_email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Your Email Address..." required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="exampleFormControlSelect" name="c_type" required>
                            <option value="" selected>Select Category</option>
                            <option value="New Query">New Query</option>
                            <option value="Book Publishing">Book Publishing</option>
                            <option value="Grievance">Grievance</option>
                            <option value="Feedback">Feedback</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="c_subject" class="form-control" id="exampleInputSubject" placeholder="Subject of query" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="c_message" aria-label="With textarea" style="height: 160px"
                                  placeholder="Write in brief your query, mentioning your contact number..." required></textarea>
                    </div>
                    <button type="submit" name="query" value="submit" class="btn btn-warning btn-lg btn-block">Submit</button>
                </form>
            </div>
            <div  class="col-md-6">
                <h5>Need assistance? <small class="text-muted"> Please feel free to contact us for any query or support. We are always eager to hear from you. </small></h5>
                <h5>Email: <small class="text-muted">rspubhouse@gmail.com</small></h5>
                <h5>Contact: <small class="text-muted">+91 9453177545 || +91 9453351473</small></h5>

                <div class="text-left mt-4">
                    <img class="img-fluid contact-image rounded" alt="Google Map" src="/images/varanasi-1.png" >
                </div>
            </div>

        </div>

        <br><br>
        <br><br>
        <br><br>
    </div>


    @include('layouts.footer2')

@endsection