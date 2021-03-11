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

        <h3 class="text-success mt-5">{{$course['name']}}</h3>
        {{--<p>Select the lesson you want to study...</p>--}}

        <div class="row mt-2">
            <div class="col-md-6">
                <form action="">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select subject to load chapters:</label>
                        <select class="form-control" id="selectSubject" name="chap"
                                onchange="getLessonsList()">
                            @foreach($subjects as $row)
                                <option value="{{$row['id']}}" data-title="{{$row['name']}}">{{$row['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-md-6">
                <div id="records_content">



                </div>

{{--                <table class="table table-bordered table-stripped">--}}
{{--                    <thead class="tbl-header">--}}
{{--                    <tr>--}}
{{--                        <th scope="col" colspan="3">All Chapters</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @if(count($contents)>0)--}}
{{--                        @foreach($contents as $unit)--}}
{{--                            @if(count($unit['lessons']))--}}
{{--                                <tr><td colspan="3">{{'Unit: '.$unit['no']}}</td></tr>--}}
{{--                                @foreach($unit['lessons'] as $row)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{$row['sno']}}</td>--}}
{{--                                        <td>--}}
{{--                                            @if($row['type']=='editor')--}}
{{--                                                <a href="{{'/lesson/index?cid='.$row['id']}}" target="_blank">{{$row['title']}}</a></td>--}}
{{--                                        @else--}}
{{--                                            <a href="{{'/lesson/file?pdf='.$row['name']}}" target="_blank">{{$row['title']}}</a></td>--}}
{{--                                        @endif--}}

{{--                                        <td>--}}
{{--                                            @if($row['type']=='editor')--}}
{{--                                                <span><i class="fa fa-chrome icon-web"  aria-hidden="true"></i></span>--}}
{{--                                            @else--}}
{{--                                                <span><i class="fa fa-file-pdf icon-pdf" aria-hidden="true"></i></span>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    @endif--}}

{{--                    </tbody>--}}
{{--                </table>--}}

            </div>

        </div>
    </div>

@endsection


@section('script')
    <script>

        $(document).ready(function(){
            var sid = {{$first['id']}};
            var nm = "{{$first['name']}}";
            readLessons(sid, nm);
        });

        //=================
        // Read Record
        //=================
        function readLessons(sid, title) {
            //console.log('Hello!');
            var readlesson = "readlesson";
            $.ajax({
                url: "/Ajax/fetchPublishedLessonRecords",
                type: "POST",
                data: {
                    readlesson:readlesson,
                    sid:sid,
                    title:title
                },
                success: function(data){
                    //console.log(data);
                    $('#records_content').html(data);
                }
            })
        }

        /*function getLessonsList(id,title){
            console.log(id);
            readLessons(id,title);
        }*/

        function getLessonsList(){
            var e = document.getElementById("selectSubject");
            //var my = e.value;
            var id = e.options[e.selectedIndex].value;
            var title = e.options[e.selectedIndex].getAttribute('data-title')
            console.log(id);
            console.log(title);
            readLessons(id,title);
        }
    </script>
@endsection

