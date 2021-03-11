@extends('layouts.boot')

@section('content')

    <div class="container mb-5">

        <h2 class="text-info mt-5">Dashboard</h2>

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <div class="row mb-5">
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action">User name: <span class="text-success mark"><em>
                                {{$authUser->first_name.' '.$authUser->last_name}}</em></span></a>
                    <a class="list-group-item list-group-item-action">Mobile: <span class="text-success mark"><em>
                                {{$authUser->mobile}}</em></span></a>
                    <a class="list-group-item list-group-item-action">Email address: <span class="text-success mark"><em>
                                {{$authUser->email}}</em></span></a>
                    <a class="list-group-item list-group-item-action">Permanent userId: <span class="text-success mark"><em>{{$authUser->code}}</em></span></a>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mt-3">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action text-success">Your Orders List:</a>
                    @if(count($myOrders)>0)
                        @foreach($myOrders as $row)
                            <a class="list-group-item list-group-item-action"><b>{{$row->order_id}}</b>{{' '.$row->course}}</a>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        <h3 class="text-info">Your eNotes: </h3>
        <div class="row mb-5">
            @foreach($courses2 as $course)
            <div class="col-sm-12 col-md-4 mt-3">
                <div class="card">
                    <div class="card-body">
                        <span class="card-text"><i>{{'Course Lecture for:'}}</i></span>
                        <h5 class="card-title mt-2 text-info">{{$course->name}}</h5>

                        <a href="{{'/page/load?gid='.$course->id}}" class="btn btn-info">Continue Learning</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <br><br>
        <br><br>
        <br><br>


        {{-- Change the function in Controller to groupsNew()--}}
        {{--<div class="row">
            @foreach($courses2 as $course)
                <div class="col-sm-6 mt-3">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active">
                            {{$course['call']}}
                        </a>
                        @foreach($course['subjects'] as $row)
                            <a href="#" class="list-group-item list-group-item-action">{{$row['name']}}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>--}}


    </div>

    @include('layouts.footer2')

@endsection