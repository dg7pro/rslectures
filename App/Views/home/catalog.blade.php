@extends('layouts.boot')

@section('content')

    <div class="container">

        <div class="mt-2">
            @include('layouts.partials.flash')
        </div>

        <div>
            <h2 class="text-info mt-4">Courses Catalog</h2>
            <p><i>Important points to be noted:</i></p>

{{--            <ul>--}}
{{--                <li><i class="fa fa-angle-right" aria-hidden="true"></i> All study materials are 7 days no question asked money back guarantee (Download links disabled for 7 days)</li>--}}
{{--                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Study materials are delivered in PDF, Word Docx, PPT--}}
{{--                formats etc which can be either read online or can be easily downloaded.--}}
{{--                </li>--}}
{{--                <li><i class="fa fa-angle-right" aria-hidden="true"></i> All study materials are updated on regular basis so that it is exactly according to the syllabus of chosen university</li>--}}
{{--                <li><i class="fa fa-angle-right" aria-hidden="true"></i> No need to buy separate expensive books of each subjects individually (All subjects covered)</li>--}}
{{--                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Contents are prepared by expert Gurus of each subjects  </li>--}}
{{--                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Each lesson is designed to be studied in 1-2 hrs  </li>--}}
{{--                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Designed to obtain good marks  </li>--}}
{{--            </ul>--}}

            <ul>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Students are required to attend live online classes in batches on fixed scheduled time (mostly evening)</li>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Study materials are delivered in PDF, Word Docx, PPT
                    formats etc. where ever necessary which can be either read online or can be easily downloaded.
                </li>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Contents are prepared by expert Gurus of each subjects  </li>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Syllabus of the course is very upto date and current in the market</li>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Books and other external online sources of study materials are also advised for the benefit of the student</li>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Classes are conducted through zoom and highly educated and experienced teachers are allotted to each batch </li>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i> Designed to obtain good marks and maximum understanding  </li>
            </ul>

        </div>

        <div class="mt-4 mb-4">
            <a class="btn btn-success" href="{{'/subscribe/index'}}" role="button">Purchase</a>
        </div>

        <div class="row mt-5 mb-3">
            <div class="col-lg-12">
{{--                <div class="card card-default">--}}
{{--                    <div class="card-header card-header-border-bottom">--}}
{{--                        <h2>--}}
{{--                            Available Study Materials--}}
{{--                        </h2>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <p class="mb-5">Here is the list of all the courses available on this portal</p>--}}

                        <div>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Sno.</th>
                                    <th scope="col">Study Material</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($eNotes as $eNote)
                                    <tr>
                                        <th scope="row">{{$eNote['sno']}}</th>
                                        <td>
                                            {{$eNote['name']}}
                                            @if($eNote['open'])
                                                <span class="small text-success mark"><em>{{'(Open)'}}</em></span>
                                            @else
                                                <span class="small text-success mark"><em>{{'(Open)'}}</em></span>
                                            @endif

                                        </td>
                                        <td>{{$eNote['price']}}</td>
                                        <td>
                                            {{--<button type="button" onclick="return showDetails({{$eNote['id']}})" class="mb-1 btn btn-sm btn-info">Topics covered</button>--}}
                                            <a class="mb-1 btn btn-sm btn-info" href="{{'/course/details?id='.$eNote['id']}}" role="button">Course Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
{{--                    </div>--}}
{{--                </div>--}}
            </div>

        </div>

        <div class="mb-5">
            <a class="btn btn-success" href="{{'/subscribe/index'}}" role="button">Purchase</a>
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


    </div>

    @include('layouts.footer2')



@endsection


@section('script')
    <script>
        // function showComingSoon(){
        //     console.log('Hello');
        //     $('#modal-group').modal("show");
        //     return false;
        // }

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

