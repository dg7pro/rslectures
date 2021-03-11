@extends('layouts.boot')

@section('custom_css')
    <style>
        .icon-web{
            /*color: #00B1CD;*/
            /*color: #0071c7;*/
            color: #7d18d5;
        }
        .icon-pdf{
            /*color: #00B1CD;*/
            color: #c70038;
        }
    </style>
@endsection

@section('content')

    <div class="container mb-5">

        <h3 class="text-success mt-5">{{$subject['name']}}</h3>
        {{--<p>Select the lesson you want to study...</p>--}}

        <div class="row mt-2">
            <div class="col-md-6">
                <form action="">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select subject to load chapters</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        

        <div class="row mt-2">
            <div class="col-md-6">

                <table class="table table-bordered table-stripped">
                    <thead class="tbl-header">
                    <tr>
                        <th scope="col" colspan="3">All Chapters</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($contents)>0)
                        @foreach($contents as $unit)
                            @if(count($unit['lessons']))
                                <tr><td colspan="3">{{'Unit: '.$unit['no']}}</td></tr>
                                @foreach($unit['lessons'] as $row)
                                    <tr>
                                        <td>{{$row['sno']}}</td>
                                        <td>
                                            @if($row['type']=='editor')
                                                <a href="{{'/lesson/index?cid='.$row['id']}}" target="_blank">{{$row['title']}}</a></td>
                                            @else
                                                <a href="{{'/lesson/file?pdf='.$row['name']}}" target="_blank">{{$row['title']}}</a></td>
                                            @endif

                                        <td>
                                            @if($row['type']=='editor')
                                                <span><i class="fa fa-chrome icon-web"  aria-hidden="true"></i></span>
                                            @else
                                                <span><i class="fa fa-file-pdf icon-pdf" aria-hidden="true"></i></span>
                                            @endif
                                        </td>
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