@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <div class="pricing-header px-3 py-3 pt-md-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 text-info">Courses Available</h1>
            <p class="">Both the Online and Offline (On-campus) modes are available for the training. Click on the course block
                to get detailed information about the course.
            </p>
        </div>


        <div class="row text-center mb-5">
            @foreach($groups as $group)
                {{--@if(!in_array($group['id'],$subscribed))--}}
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm" style="background-color: {{$group['color']}}">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal text-dark">
                                 {{$group['name']}}
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
                                <li>Online classes</li>
                                <li>Expert lecturers</li>
                                <li>Monthly instalments</li>
                                <li>Doubt sessions</li>
                                <li>e-Notes</li>
                            </ul>

                            <a class="btn btn-lg btn-block btn-dark" href="{{'/course/details?id='.$group['id']}}" role="button">Course Details</a>

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
