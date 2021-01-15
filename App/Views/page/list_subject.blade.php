@extends('layouts.boot')

@section('content')

    <div class="container">

        <h3 class="text-success mt-5">{{$course['name']}}</h3>
        <p>Select the subject you want to study...</p>


        <div class="row mt-2">
            <div class="col-md-6">

               {{-- <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        Which Subject do you want to study?
                    </a>
                    @foreach($subjects as $subject)
                        <a href="{{'/page/list-content?sid='.$subject['id']}}}" class="list-group-item list-group-item-action">{{$subject['name']}}</a>
                    @endforeach
                </div>--}}

                <table class="table table-bordered table-stripped mb-5">
                    <thead class="thead-light">
                    <tr>

                        <th scope="col">Subjects</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                    <tr>

{{--                        <td><a href="{{'/page/list-content?sid='.$subject['id'] }}">{{$subject['name']}}</a></td>--}}
                        <td><a href="#" onclick="getLessonsList({{$subject['id']}},'{{$subject['name']}}')">{{$subject['name']}}</a></td>

                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <div id="records_content">



                </div>
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
            console.log('Hello!');
            var readlesson = "readlesson";
            $.ajax({
                url: "/Ajax/fetchLessonRecords",
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

        function getLessonsList(id,title){
            console.log(id);
            readLessons(id,title);
        }
    </script>
@endsection

