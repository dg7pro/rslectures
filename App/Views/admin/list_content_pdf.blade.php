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
                            <button onclick="showNewFileContentForm()" type="button" class="mb-1 ml-3 btn btn-sm btn-primary">Create content +</button>
                           {{-- <a href="{{'/admin/change-order?sid='.$subject['id']}}" type="button" class="mb-1 ml-3 btn btn-sm btn-primary">Change Order</a>--}}
                        </h2>
                    </div>
                    <div class="card-body">
                        {{--                        <p class="mb-5">These users need approval before their profile gets live.</p>--}}
                        <p class="mb-5">Add edit and manage PDF Contents of the subject: <b>{{$subject['name']}}</b></p>

                        <div id="records_content">


                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Create content Modal -->
        <div class="modal fade" id="modal-new-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New content</h5>
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
                                </select>
                            </div>

                            <div class="form-subject">
                                <label for="new-subject-name" class="col-form-label">Title of content:</label>
                                <input type="text" class="form-control" id="new-content-title" placeholder="Type new content title here...">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="createNewFileContent()">Create content</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update content Modal -->
        <div class="modal fade" id="modal-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">content Information</h5>
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
                                </select>
                            </div>

                            <div class="form-subject">
                                <label for="content-title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="content-title">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateFileContentInfo()">Update content</button>
                        <input type="hidden" name="" id="content-id">

                    </div>
                </div>
            </div>
        </div>


        <!-- Attach file Modal -->
        <div class="modal fade" id="modal-attach-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attach file to content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-subject">
                                <label for="subject-units" class="col-form-label">Select file:</label>
                                <select class="form-control" id="select-file">

                                </select>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="attachContentRequest()">Attach file</button>
                        <input type="hidden" name="" id="content-id">

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
                url: "/AjaxFileContent/fetchFileContentRecordsWithUnit",
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
        // Fetch Record
        //=================
        function getFileContentInfo(id){
            console.log(id);
            $.post("/AjaxFileContent/fetchSingleFileContentRecord",{contentId:id},function (data, status) {

                console.log(data);
                console.log('working');
                var content = JSON.parse(data);
                $('#content-title').val(content.title);
                $('#content-id').val(content.id);
                $('#content-unit').val(content.unit);


            });
            $('#modal-content').modal("show");
        }

        //=================
        // Update Record
        //=================
        function updateFileContentInfo(){

            var title = $('#content-title').val();
            var unit = $('#content-unit').val();
            var id = $('#content-id').val();

            $.post("/AjaxFileContent/updateSingleFileContentRecord",{
                title:title,
                id:id,
                unit:unit

            },function (data, status) {
                console.log(data);
                $('#modal-content').modal("hide");
                readRecords();
            });
        }

        //=================
        //  Publish  Content
        //=================
        function publishContent(id){

            $.post("/AjaxFileContent/publishFileContentRecord",{
                id:id

            },function (data, status) {
                console.log(data);
                readRecords();
            });
        }

        //=================
        //  Un-Publish  Content
        //=================
        function unPublishContent(id){

            $.post("/AjaxFileContent/unpublishFileContentRecord",{
                id:id

            },function (data, status) {
                console.log(data);
                readRecords();
            });
        }

        //=================
        // Attach File Form
        //=================
        function attachFile(cid){
            console.log(cid);
            $.post("/AjaxFileContent/fetchUnattachedFilesRecord",{contentId:cid},function (data, status) {

                console.log(data);
                console.log(status);
                console.log('working');
                var content = JSON.parse(data);

                var len = content.length;

                $("#select-file").empty();
                for( var i = 0; i<len; i++){
                    var id = content[i]['id'];
                    var name = content[i]['name'];

                    $("#select-file").append("<option value='"+id+"'>"+name+"</option>");

                }
                $('#content-id').val(cid);


                console.log(cid);
                console.log(len);


            });
            $('#modal-attach-file').modal("show");
        }

        //=====================
        // Attach Content
        //=====================
        function attachContentRequest(){

            var file_id = $('#select-file').val();
            var content_id = $('#content-id').val();


            console.log(file_id);
            console.log(content_id);

            $.post("/AjaxFileContent/attachContentToFile",{
                file_id:file_id,
                content_id:content_id

            },function (data, status) {
                console.log(data);
                $('#modal-attach-file').modal("hide");
                readRecords();
            });
        }

        //=============================
        // Just Alert Published Content
        //=============================
        function alertPublishedContent(){
            window.alert('Either this content is published or there is no file attached, first un-publish to delete');
        }

        //=================
        // Detach Content
        //=================
        function detachContentRequest(fid){

            console.log(fid);

            var result = window.confirm('Are you sure?');
            if (result === false) {
                // e.preventDefault();
                console.log('He cancelled');
            }else {
                console.log('He is sure');

                $.post("/AjaxFileContent/detachContentFromFile",{
                    file_id:fid

                },function (data, status) {
                    console.log(data);
                    readRecords();
                });

            }

        }

        //==============
        // Show Form
        //==============
        function showNewFileContentForm(){

            /* To show blank title field from last entry*/
            document.getElementById("new-content-title").value=null;

            $('#modal-new-content').modal("show");
        }

        //==============
        // Create Record
        //==============
        function createNewFileContent(){

            var sid = $('#new-content-sid').val();
            var unit = $('#new-content-unit').val();
            var title = $('#new-content-title').val();

            $.post("/AjaxFileContent/insertNewFileContentRecord",{
                sid:sid,
                unit:unit,
                title:title

            },function (data, status) {
                console.log(data);
                $('#modal-new-content').modal("hide");
                readRecords();
            });
        }

        //=================
        // Delete Record
        //=================
        function deleteFileContentInfo(id){

            var result = window.confirm('Are you sure?');
            if (result === false) {
                // e.preventDefault();
                console.log('He cancelled');
            }else {
                console.log('He is sure');
                $.post("/AjaxFileContent/deleteFileContentRecord",{
                    id:id

                },function (data, status) {
                    console.log(data);
                    readRecords();
                    var response = $.parseJSON(data);
                    if(response.status === false){
                        alert(response.message);
                    }
                });
            }
        }
    </script>
@endsection

