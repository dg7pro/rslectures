@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4 text-info">Courses Available</h1>
            <p class="">Please subscribe to the courses you want to study. It's built with utmost care so that students can obtain maximum marks out off it.</p>
        </div>


        <div class="row text-center mb-5">
            @foreach($groups as $group)
                {{--@if(!in_array($group['id'],$subscribed))--}}
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm" style="background-color: {{$group['color']}}">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">{{$group['name']}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{'/Payment/redirect-payment'}}" method="POST">

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
                                           value="{{$group['price']}}" hidden >




                                    <h1 class="card-title pricing-card-title">
                                        <small class="text-muted"><i class="fas fa-rupee-sign"></i></small> {{$group['price']}}
                                        <small class="text-muted">/ year</small>
                                    </h1>
                                    <ul class="list-unstyled mt-3 mb-4">
                                        <li>All subjects included</li>
                                        <li>Study as you want</li>
                                        <li>Model Question Papers</li>
                                        <li>24x7 Support</li>
                                    </ul>
                                    {{--<button type="submit" class="btn btn-lg btn-block btn-dark">Subscribe</button>--}}
                                    @if(in_array($group['id'],$subscribed))
                                        {{--<button type="submit" class="btn btn-lg btn-block btn-dark disabled">Subscribe</button>--}}
                                        <a class="btn btn-lg btn-block btn-dark" href="{{'/page/list-subject-new?gid='.$group['id']}}" role="button">Learn Now</a>
                                    @else
                                        @if(!$group['open'])
                                            <button onclick="showComingSoon()" type="button" class="btn btn-lg btn-block btn-dark">Coming Soon</button>
                                        @else
                                            <button type="submit" class="btn btn-lg btn-block btn-dark">Subscribe</button>
                                        @endif

                                    @endif
                                </form>
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
        }

    </script>


@endsection
