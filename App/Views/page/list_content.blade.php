@extends('layouts.boot')

@section('content')

    <div class="container">

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
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Lessons</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contents as $content)
                        <tr>
                            <td><a href="{{'/lesson/index?cid='.$content['id'] }}">{{$content['title']}}</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>

        </div>
    </div>

@endsection