@extends('layouts.boot')

@section('content')

    <div class="container mb-5">

        {{--<div class="row mt-5">
            <div class="col-md-6">

                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        Click on Lesson to open content
                    </a>
                    @foreach($contents as $content)
                        <a href="{{'/lesson/index?cid='.$content['id']}}" class="list-group-item list-group-item-action">{{ $content['title'] }}</a>
                    @endforeach
                </div>

            </div>

        </div>
--}}

        <h3 class="text-success mt-5">{{$subject['name']}}</h3>
        <p>Select the lesson you want to study...</p>


        <div class="row mt-2">
            <div class="col-md-6">

                <table class="table table-bordered table-stripped">
                    <thead style="background-color: #dd4444">
                    <tr>
                        <th scope="col" colspan="2">All Lessons</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($contents)>0)
                        @foreach($contents as $unit)
                            @if(count($unit['lessons']))
                                <tr><td colspan="2">{{'Unit: '.$unit['no']}}</td></tr>
                                @foreach($unit['lessons'] as $row)
                                    <tr>
                                        <td>{{$row['sno']}}</td>
                                        <td><a href="{{'/lesson/display?pdf='.$row['name']}}">{{$row['title']}}</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    </tbody>
                </table>

            </div>

        </div>
    </div>

@endsection