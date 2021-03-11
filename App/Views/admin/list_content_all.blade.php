@extends('layouts.boot')

@section('content')

    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">RS Lectures</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/list-group'}}">Courses</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/list-subject?gid='.$subject['group_id']}}">Subjects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$subject['name']}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- First Row  -->
        <div class="row mt-3 mb-3">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>All Contents:

                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">Check links and shuffle sequence. This is the order in which contents will be visible.</p>
                        <form>
                        <div id="records_content">

                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            readRecords();
        });

        //=================
        // Read Record
        //=================
        function readRecords() {

            var readrecord = "readrecord";
            $.ajax({
                url: "/AjaxFileContent/listContentsForChangingOrder",
                type: "POST",
                data: {
                    subjectId:{{$subject['id']}},
                    readrecord:readrecord
                },
                success: function(data,status){
                    //console.log(data);
                    $('#records_content').html(data);
                }
            })
        }

        //=================
        // Change Order
        //=================
        function setSno($id, $sno){

            console.log($id);
            console.log($sno);

            if($id && $sno){
                $.ajax({
                    type:'POST',
                    url:'/AjaxFileContent/changeOrder',
                    data:{
                        id:$id,
                        sno:$sno
                    },
                    success:function(data,status){
                        readRecords();
                    }
                });
            }
        }
    </script>


@endsection

