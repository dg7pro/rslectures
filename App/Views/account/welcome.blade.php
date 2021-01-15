@extends('layouts.boot')

@section('content')

    <div class="container mb-5">

        <h1 class="mt-5">Dashboard</h1>

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <div class="row">
            @foreach($courses2 as $course)
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$course->name}}</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{'/page/list-subject?gid='.$course->id}}" class="btn btn-primary">Continue Learning</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

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

@endsection