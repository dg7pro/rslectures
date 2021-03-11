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
                        <li class="breadcrumb-item active" aria-current="page">{{$group['name']}}</li>
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
                            Subjects of {{$group['name']}}
                            <button onclick="showNewSubjectForm()" type="button" class="mb-1 ml-3 btn btn-sm btn-primary">Add Subject +</button>
                        </h2>
                    </div>
                    <div class="card-body">
                        {{--<p class="mb-5">These users need approval before their profile gets live.</p>--}}
                        <p class="mb-5">Only admin can add, edit and manage contents of subjects.</p>

                        <div id="records_content">


                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Create Subject Modal -->
        <div class="modal fade" id="modal-new-subject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Subject Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" id="new-subject-gid" value="{{$group['id']}}">
                            <div class="form-subject">
                                <label for="subject-units" class="col-form-label">Max Units:</label>
                                <select class="form-control" id="new-subject-units">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                            <div class="form-subject">
                                <label for="new-subject-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="new-subject-name">
                            </div>
                            <div class="form-subject">
                                <label for="new-subject-descr" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="new-subject-descr"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="createNewSubject()">Create Subject</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update Subject Modal -->
        <div class="modal fade" id="modal-subject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Subject Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-subject">
                                <label for="subject-units" class="col-form-label">Max Units:</label>
                                <select class="form-control" id="subject-units">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                            <div class="form-subject">
                                <label for="subject-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="subject-name">
                            </div>
                            <div class="form-subject">
                                <label for="subject-descr" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="subject-descr"></textarea>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateSubjectInfo()">Update Subject</button>
                        <input type="hidden" name="" id="subject-id">

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
                url: "/adjax/fetchSubjectRecords",
                type: "POST",
                data: {
                    groupId:{{$group['id']}},
                    readrecord:readrecord
                },
                success: function(data,status){
                    //console.log(data);
                    $('#records_content').html(data);
                }
            })
        }

        function getSubjectInfo(id){
            console.log(id);
            $('#subject_id').val(id);
            $.post("/adjax/fetchSingleSubjectRecord",{subjectId:id},function (data, status) {

                console.log(data);
                console.log('working');
                var subject = JSON.parse(data);
                $('#subject-units').val(subject.units);
                $('#subject-name').val(subject.name);
                $('#subject-descr').val(subject.descr);
                $('#subject-id').val(subject.id);

            });
            $('#modal-subject').modal("show");
        }

        function updateSubjectInfo(){

            var units = $('#subject-units').val();
            var name = $('#subject-name').val();
            var descr = $('#subject-descr').val();
            var id = $('#subject-id').val();
            $.post("/adjax/updateSingleSubjectRecord",{
                units:units,
                name:name,
                descr:descr,
                id:id

            },function (data, status) {
                console.log(data);
                $('#modal-subject').modal("hide");
                readRecords();
            });
        }

        function showNewSubjectForm(){
            $('#modal-new-subject').modal("show");
        }

        function createNewSubject(){

            var gid = $('#new-subject-gid').val();
            var units = $('#new-subject-units').val();
            var name = $('#new-subject-name').val();
            var descr = $('#new-subject-descr').val();

            $.post("/adjax/insertNewSubjectRecord",{
                gid:gid,
                units:units,
                name:name,
                descr:descr

            },function (data, status) {
                console.log(data);
                $('#modal-new-subject').modal("hide");
                readRecords();
            });
        }

        function deleteSubjectInfo(id){

            var result = window.confirm('Are you sure?');
            if (result === false) {
                // e.preventDefault();
                console.log('He cancelled');
            }else {
                console.log('He is sure');
                $.post("/adjax/deleteSubjectRecord",{
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

