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
                        <h2>
                            {{$subject['name']}}
                            <button onclick="showNewContentForm()" type="button" class="mb-1 ml-3 btn btn-sm btn-primary">Create Content +</button>
                        </h2>
                    </div>
                    <div class="card-body">
{{--                        <p class="mb-5">These users need approval before their profile gets live.</p>--}}
                        <p class="mb-5">Add edit and manage lessons of this subject (Only Administrator).</p>

                        <div id="records_content">


                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Create Content Modal -->
        <div class="modal fade" id="modal-new-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" id="new-content-sid" value="{{$subject['id']}}">

                            <div class="form-subject">
                                <label for="subject-units" class="col-form-label">Select Unit:</label>
                                <select class="form-control" id="new-content-unit">
                                    <option value="" selected>Select</option>
                                    @for($i=1;$i<=$subject['units'];$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                        <option value=0>None</option>
                                </select>
                            </div>

                            <div class="form-subject">
                                <label for="new-subject-name" class="col-form-label">Title of Content:</label>
                                <input type="text" class="form-control" id="new-content-title" placeholder="Type new content title here...">
                            </div>

                            <div class="form-subject">
                                <label for="new-content-matter" class="col-form-label">Matter:</label>
                                <textarea class="form-control" id="new-content-matter" disabled>Admin can edit content only after creating it</textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="createNewContent()">Create Content</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update Content Modal -->
        <div class="modal fade" id="modal-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Content Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-subject">
                                <label for="subject-units" class="col-form-label">Change Unit:</label>
                                <select class="form-control" id="content-unit">
                                    @for($i=1;$i<=$subject['units'];$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                        <option value=0>None</option>
                                </select>
                            </div>

                            <div class="form-subject">
                                <label for="content-title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="content-title">
                            </div>
                           {{-- <div class="form-subject">
                                <label for="content-matter" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="content-matter"></textarea>
                            </div>--}}

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateContentInfo()">Update Content</button>
                        <input type="hidden" name="" id="content-id">

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')

    {{-- <script>
         function getContentInfo(){

             var gn = $(this).attr("data-subject")
             console.log(gn);
             $('#recipient-name').html(gn);
             $('#modal-subject').modal("show");
         }
     </script>
 --}}


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
                url: "/ajaxEditorContent/fetchEditorContentRecordsWithUnit",
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

        function getContentInfo(id){
            console.log(id);
            $.post("/ajaxEditorContent/fetchSingleContentRecord",{contentId:id},function (data, status) {

                console.log(data);
                console.log('working');
                var content = JSON.parse(data);
                $('#content-title').val(content.title);
                $('#content-matter').val(content.matter);
                $('#content-id').val(content.id);
                $('#content-unit').val(content.unit);


            });
            $('#modal-content').modal("show");
        }

        function updateContentInfo(){

            var title = $('#content-title').val();
            var unit = $('#content-unit').val();
            var id = $('#content-id').val();

            $.post("/ajaxEditorContent/updateSingleContentRecord",{
                title:title,
                id:id,
                unit:unit

            },function (data, status) {
                console.log(data);
                $('#modal-content').modal("hide");
                readRecords();
            });
        }

        function showNewContentForm(){

            document.getElementById("new-content-title").value=null;

            $('#modal-new-content').modal("show");
        }

        function createNewContent(){

            var sid = $('#new-content-sid').val();
            var unit = $('#new-content-unit').val();
            var title = $('#new-content-title').val();
            var matter = $('#new-content-matter').val();

            $.post("/ajaxEditorContent/insertNewContentRecord",{
                sid:sid,
                unit:unit,
                title:title,
                matter:matter

            },function (data, status) {
                console.log(data);
                $('#modal-new-content').modal("hide");
                readRecords();
            });
        }

        function deleteContentInfo(id){

            var result = window.confirm('Are you sure?');
            if (result === false) {
                // e.preventDefault();
                console.log('He cancelled');
            }else {
                console.log('He is sure');
                $.post("/ajaxEditorContent/deleteContentRecord",{
                    id:id

                },function (data, status) {
                    console.log(data);
                    readRecords();
                });
            }
        }

    </script>
@endsection

