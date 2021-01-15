@extends('layouts.boot')

@section('custom_css')
    <style>
        .my-coral{
            background-color: coral;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid">

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


        <!-- First Row  -->
        <div class="row mt-3 mb-3">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>
                            Courses/Groups
                            <button onclick="showNewGroupForm()" type="button" class="mb-1 ml-3 btn btn-sm btn-primary">Add Group +</button>
                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">Here is the list of all the courses available on this portal</p>

                        <div id="records_content">


                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Update Group Modal -->
        <div class="modal fade" id="modal-new-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Group Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="new-group-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="new-group-name">
                            </div>
                            <div class="form-group">
                                <label for="new-group-descr" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="new-group-descr"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="new-group-price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" id="new-group-price">
                            </div>
                            <div class="form-group">
                                <label for="new-group-color">Select Color:</label>
                                <select class="form-control" id="new-group-color">
                                    <option value="">Select</option>
                                    <option value="coral">Coral</option>
                                    <option value="lightsteelblue">LightSteelBlue</option>
                                    <option value="orange">Orange</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="new-group-open">Registration Open:</label>
                                <select class="form-control" id="new-group-open">
                                    <option value="">Select</option>
                                    <option value=0 selected>Closed (By Default)</option>
                                    <option value=1>Open</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="createNewGroup()">Create Group</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update Group Modal -->
        <div class="modal fade" id="modal-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Group Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="group-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="group-name">
                            </div>
                            <div class="form-group">
                                <label for="group-descr" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="group-descr"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="group-price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" id="group-price">
                            </div>


                            <div class="form-group">
                                <label for="group-color">Select Color:</label>
                                <select class="form-control" id="group-color">
                                    <option value="">Select</option>
                                    <option value="coral">Coral</option>
                                    <option value="lightsteelblue">LightSteelBlue</option>
                                    <option value="orange">Orange</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="group-open">Registration Open:</label>
                                <select class="form-control" id="group-open">
                                    <option value="">Select</option>
                                    <option value=0 selected>Closed (By Default)</option>
                                    <option value=1>Open</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateGroupInfo()">Update Group</button>
                        <input type="hidden" name="" id="group-id">

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')

    {{-- <script>
         function getGroupInfo(){

             var gn = $(this).attr("data-group")
             console.log(gn);
             $('#recipient-name').html(gn);
             $('#modal-group').modal("show");
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
                url: "/adjax/fetchGroupRecords",
                type: "POST",
                data: {
                    readrecord:readrecord
                },
                success: function(data,status){
                    //console.log(data);
                    $('#records_content').html(data);
                }
            })
        }

        function getGroupInfo(id){
            console.log(id);
            $('#group_id').val(id);
            $.post("/adjax/fetchSingleGroupRecord",{groupId:id},function (data, status) {

                console.log(data);
                var group = JSON.parse(data);
                $('#group-name').val(group.name);
                $('#group-descr').val(group.descr);
                $('#group-price').val(group.price);
                $('#group-color').val(group.color);
                $('#group-open').val(group.open);
                $('#group-id').val(group.id);

            });
            $('#modal-group').modal("show");
        }

        function updateGroupInfo(){

            var name = $('#group-name').val();
            var descr = $('#group-descr').val();
            var price = $('#group-price').val();
            var color = $('#group-color').val();
            var open = $('#group-open').val();
            var id = $('#group-id').val();
            $.post("/adjax/updateSingleGroupRecord",{
                name:name,
                descr:descr,
                price:price,
                color:color,
                open:open,
                id:id

            },function (data, status) {
                console.log(data);
                $('#modal-group').modal("hide");
                readRecords();
            });
        }

        function showNewGroupForm(){
            $('#modal-new-group').modal("show");
        }

        function createNewGroup(){

            var name = $('#new-group-name').val();
            var descr = $('#new-group-descr').val();
            var price = $('#new-group-price').val();
            var color = $('#new-group-color').val();
            var open = $('#new-group-open').val();

            $.post("/adjax/insertNewGroupRecord",{
                name:name,
                descr:descr,
                price:price,
                color:color,
                open:open

            },function (data, status) {
                console.log(data);
                $('#modal-new-group').modal("hide");
                readRecords();
            });
        }

        function deleteGroupInfo(id){

            var result = window.confirm('Are you sure?');
            if (result === false) {
                // e.preventDefault();
                console.log('He cancelled');
            }else {
                console.log('He is sure');
                $.post("/adjax/deleteGroupRecord",{
                    id:id

                },function (data, status) {
                    console.log(data);
                    readRecords();
                });
            }

        }
    </script>
@endsection

