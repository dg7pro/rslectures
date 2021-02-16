@extends('layouts.boot')

@section('custom_css')
    <style>
        .my-coral{
            background-color: coral;
        }
    </style>
@endsection

@section('content')

    <div class="container">

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">RS Lectures</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Courses</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card mt-3 mb-3">
            <div class="card-header">
                Search User
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input type="text" id="search_box" name="search_box" class="form-control"
                           placeholder="Type your search query here...">
                </div>
                <div class="table-responsive" id="dynamic_content"></div>
            </div>
        </div>


        <div class="modal fade" id="modal-user-groups" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Associated Groups</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div id="associated_groups">

                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function (){

            load_data(1);

            function load_data(page, query=''){
                $.ajax({
                    url: "/Adjax/search-user",
                    method: "POST",
                    data:{
                        page:page,
                        query:query
                    },
                    success:function(data){
                        $('#dynamic_content').html(data);
                    }
                })
            }

            $(document).on('click', '.page-link', function(){
                var page = $(this).data('page_number');
                var query = $('#search_box').val();
                load_data(page, query);
            });

            $('#search_box').keyup(function(){
                var query = $('#search_box').val();
                load_data(1, query);
            });

        })


        function getUserCourseInfo(id){
            console.log(id);
            $.post("/adjax/fetchUserCourseRecord",{userId:id},function (data, status) {
                console.log(data);
                $('#associated_groups').html(data);
            });
            $('#modal-user-groups').modal("show");
        }


    </script>

@endsection

