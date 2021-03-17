@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <div class="mt-3">
            @if($new_user_flag)
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">What next?</h4>
                    <ul>
                       {{-- <li><i class="fas fa-angle-right"></i> Congratulations! You have successfully created and activated your account, What next?</li>--}}
                        <li><i class="fas fa-angle-right"></i> From the below list of courses given, find the course you want to study </li>
                        <li><i class="fas fa-angle-right"></i> Click on the <strong><u>Purchase</u></strong> button to pay the fees</li>
                        <li><i class="fas fa-angle-right"></i> You will be redirected to <strong><u>Paytm Page</u></strong> India's largest and secure Payment Gateway</li>

                    </ul>
                    <hr>
                    <p class="mb-0">Continue Learning - from RSLectures.com</p>
                </div>
            @endif
        </div>



        <div class="pricing-header px-3 py-3 pt-md-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 text-info">eNotes Available</h1>
            <p class="">Please subscribe to the courses you are studying in. Our study material is built with utmost care so that students
                can obtain maximum marks out off it. It covers every topic of all the subjects.
                Click on the info icon <span class="text-primary"><i class="fas fa-info-circle"></i></span>
                to know more.
                </p>
        </div>


        <div class="row text-center mb-5">
            @foreach($groups as $group)
                {{--@if(!in_array($group['id'],$subscribed))--}}
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm" style="background-color: {{$group['color']}}">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal text-dark">
                                    <a href="#" onclick="return showDetails({{$group['id']}})" style="text-decoration: none; color: #343a40!important;"> {{$group['name']}} </a>
                                    <a title="know more" href="#" onclick="return showDetails({{$group['id']}})" style="text-decoration: none; color: #343a40!important;" ><i class="fas fa-info-circle"></i>  </a>
                                   {{-- <i class="fas fa-external-link-square-alt"></i>--}}
                                </h4>
                            </div>
                            <div class="card-body">

                                <h2 class="card-title pricing-card-title">
                                    @if($group['discount_rate']==0)
                                        <small class="text-muted"><i class="fas fa-rupee-sign"></i></small> {{$group['price']}}
                                        <small class="text-muted">/ {{$group['duration']}}</small>
                                    @else
                                        <small class="text-muted"><i class="fas fa-rupee-sign"></i> <s>{{$group['price']}}</s></small>

                                        <br><i class="fas fa-rupee-sign"></i> {{$group['discount_price']}} <small class="text-muted">/ {{$group['duration']}}</small>
                                        {{-- <small class="text-muted">/ {{$group['duration']}}</small>--}}


                                    @endif
                                </h2>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>All subjects included</li>
                                    <li>Study as you want</li>
                                    <li>Model Question Papers</li>
                                    <li>24x7 Support</li>
                                </ul>
                                {{--Open Auth check--}}
                                @if(!$authUser)

                                    <a href="{{'/login/index'}}" role="button" class="btn btn-lg btn-block btn-dark">
                                        @if($group['discount_rate']!=0) <span class="badge badge-pill badge-danger">{{$group['discount_rate'].'% off'}} </span> @endif Purchase</a>

                                @else

                                    @if(in_array($group['id'],$subscribed))
                                        {{--<button type="submit" class="btn btn-lg btn-block btn-dark disabled">Subscribe</button>--}}
                                        <a class="btn btn-lg btn-block btn-dark" href="{{'/page/load?gid='.$group['id']}}" role="button">
                                            @if($group['discount_rate']!=0) <span class="badge badge-pill badge-danger">{{$group['discount_rate'].'% off'}} </span> @endif Study now</a>
                                    @else
                                        @if(!$group['open'])
                                            <button onclick="showComingSoon()" type="button" class="btn btn-lg btn-block btn-dark">
                                                @if($group['discount_rate']!=0) <span class="badge badge-pill badge-danger">{{$group['discount_rate'].'% off'}} </span> @endif Coming Soon</button>
                                        @else
                                            @if($group['deactive'])
                                                <button class="btn btn-lg btn-block btn-dark disabled" disabled>
                                                    @if($group['discount_rate']!=0) <span class="badge badge-pill badge-danger">{{$group['discount_rate'].'% off'}} </span> @endif Purchase</button>
                                            @else
                                                <form action="{{'/payment/redirect-payment'}}" method="POST">

                                                    <input type="text" id="ORDER_ID" maxlength="20" size="20"
                                                           name="ORDER_ID" autocomplete="off"
                                                           value="{{"ORDS" . mt_rand() . $authUser->id}}" hidden>
                                                    <input type="text" id="CUST_ID" maxlength="20" size="20"
                                                           name="CUST_ID" autocomplete="off"
                                                           value="{{$authUser->code}}" hidden>
                                                    <input type="text" id="INDUSTRY_TYPE_ID" maxlength="20" size="20"
                                                           name="INDUSTRY_TYPE_ID" autocomplete="off"
                                                           value="Retail" hidden>
                                                    <input type="text" id="CHANNEL_ID" maxlength="20" size="20"
                                                           name="CHANNEL_ID" autocomplete="off"
                                                           value="WEB" hidden>
                                                    <!-- Course/Group related -->
                                                    <input type="text" id="COURSE_ID"
                                                           name="COURSE_ID" autocomplete="off"
                                                           value="{{$group['id']}}" hidden >
                                                    <input type="text" id="COURSE"
                                                           name="COURSE" autocomplete="off"
                                                           value="{{$group['name']}}" hidden >
                                                    <input type="text" id="TXN_AMOUNT"
                                                           name="TXN_AMOUNT" autocomplete="off"
                                                           value="{{$group['discount_rate']==0? $group['price'] :$group['discount_price']}}" hidden >
                                                    <button type="submit" class="btn btn-lg btn-block btn-dark">
                                                        @if($group['discount_rate']!=0) <span class="badge badge-pill badge-danger">{{$group['discount_rate'].'% off'}} </span> @endif Purchase</button>
                                                </form>
                                            @endif
                                        @endif
                                    @endif

                                @endif
                                {{--End Auth check--}}
                            </div>
                        </div>
                    </div>
                {{--@endif--}}
            @endforeach
        </div>

        <!-- Update Group Modal -->
        <div class="modal fade" id="modal-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Coming From New Session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <img src="{{'/images/coming_soon.jpg'}}" alt="Coming Soon" width="100%">
                            <h4 class="text-center text-warning">Coming from next session</h4>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- List Modal -->
        <div class="modal fade" id="modal-course-info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Various subjects and topics covered</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="records_content">


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- @include('layouts.partials.footer')--}}
            {{--<footer class="pt-4 my-md-5 pt-md-5 border-top">
                <div class="row">
                    <div class="col-12 col-md">
                        <img class="mb-2" src="../../assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
                        <small class="d-block mb-3 text-muted">&copy; 2017-2018</small>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Features</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Cool stuff</a></li>
                            <li><a class="text-muted" href="#">Random feature</a></li>
                            <li><a class="text-muted" href="#">Team feature</a></li>
                            <li><a class="text-muted" href="#">Stuff for developers</a></li>
                            <li><a class="text-muted" href="#">Another one</a></li>
                            <li><a class="text-muted" href="#">Last time</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Resources</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Resource</a></li>
                            <li><a class="text-muted" href="#">Resource name</a></li>
                            <li><a class="text-muted" href="#">Another resource</a></li>
                            <li><a class="text-muted" href="#">Final resource</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>About</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Team</a></li>
                            <li><a class="text-muted" href="#">Locations</a></li>
                            <li><a class="text-muted" href="#">Privacy</a></li>
                            <li><a class="text-muted" href="#">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </footer>--}}




    </div>

     @include('layouts.footer2')



@endsection

@section('script')
    <script>
        function showComingSoon(){
            console.log('Hello');
            $('#modal-group').modal("show");
            return false;
        }

        function showDetails(id){
            console.log(id);
            $('#group_id').val(id);
            $.post("/adjax/fetchCourseDetails",{groupId:id},function (data, status) {

                console.log(data);
                $('#records_content').html(data);

            });
            $('#modal-course-info').modal("show");
            return false;
        }

    </script>


@endsection
