@extends('layouts.boot')

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
                            <a href="{{'/admin/change-group-order'}}" class="mb-1 ml-3 btn btn-sm btn-dark">Change Order</a>
                            <button onclick="showDiscountForm()" type="button" class="mb-1 ml-3 btn btn-sm btn-success">Apply Discount</button>
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

        <!-- Apply Discount Modal -->
        <div class="modal fade" id="modal-new-discount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Apply Discount</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-group">
                                <label for="new-discount-percent">Discount Percentage:</label>

                                <select class="form-control" id="new-discount-percent">
                                    {{--<option value="">Select</option>--}}
                                    @for($i=1;$i<=100;$i++)

                                        <option value="{{$i}}">{{$i}}</option>

                                    @endfor
                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="removeDiscount()">Remove Discount</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="applyDiscount()">Apply Discount</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Group Modal -->
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
                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="new-group-price" class="col-form-label">Price:</label>
                                    <input type="text" class="form-control" id="new-group-price">
                                </div>
                                <div class="col">
                                    <label for="new-group-duration" class="col-form-label">Duration:</label>
                                    <select class="form-control" id="new-group-duration">
                                        <option value="">Select</option>
                                        <option value="quarter">Quarter</option>
                                        <option value="sem">Sem</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="new-group-installment" class="col-form-label">Installment:</label>
                                    <input type="text" class="form-control" id="new-group-installment">
                                </div>
                                <div class="col">
                                    <label for="new-group-timings" class="col-form-label">Timings:</label>
                                    <select class="form-control" id="new-group-timings">
                                        <option value="">Select</option>
                                        @for($i=1; $i<=36; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-group-color">Select Color:</label>
                                <select class="form-control" id="new-group-color">
                                    <option value="">Select</option>
                                    <option value="orange">Orange</option>
                                    <option value="lightcoral">LightCoral</option>
                                    <option value="lightsalmon">LightSalmon</option>
                                    <option value="" disabled>***</option>
                                    <option value="lightseagreen">LightSeaGreen</option>
                                    <option value="lightsteelblue">LightSteelBlue</option>
                                    <option value="Thistle">Thistle</option>
                                    <option value="" disabled>***</option>
                                    <option value="SandyBrown">SandyBrown</option>
                                    <option value="Wheat">Wheat</option>
                                    <option value="PaleGoldenRod">PaleGoldenRod</option>
                                    <option value="" disabled>***</option>
                                    <option value="Khaki">Khaki</option>
                                    <option value="LavenderBlush">LavenderBlush</option>
                                    <option value="LightGoldenRodYellow">LightGoldenRodYellow</option>
                                </select>
                            </div>

                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="new-group-hidden">Hidden:</label>
                                    <select class="form-control" id="new-group-hidden">
                                        <option value="">Select</option>
                                        <option value=0 selected>No (By Default)</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="new-group-open">Registration Open:</label>
                                    <select class="form-control" id="new-group-open" disabled>
                                        <option value="">Select</option>
                                        <option value=0>Closed</option>
                                        <option value=1 selected>Open (By Default)</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="new-group-deactive">Deactive:</label>
                                    <select class="form-control" id="new-group-deactive" disabled>
                                        <option value="">Select</option>
                                        <option value=0 selected>No</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>

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
                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="group-price" class="col-form-label">Price:</label>
                                    <input type="text" class="form-control" id="group-price">
                                </div>
                                <div class="col">
                                    <label for="group-duration" class="col-form-label">Duration:</label>
                                    <select class="form-control" id="group-duration">
                                        <option value="">Select</option>
                                        <option value="quarter">Quarter</option>
                                        <option value="sem">Sem</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="group-installment" class="col-form-label">Installment:</label>
                                    <input type="text" class="form-control" id="group-installment">
                                </div>
                                <div class="col">
                                    <label for="group-timings" class="col-form-label">Timings:</label>
                                    <select class="form-control" id="group-timings">
                                        <option value="">Select</option>
                                        @for($i=1; $i<=36; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor

                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="group-color">Select Color:</label>
                                <select class="form-control" id="group-color">
                                    <option value="">Select</option>
                                    <option value="orange">Orange</option>
                                    <option value="lightcoral">LightCoral</option>
                                    <option value="lightsalmon">LightSalmon</option>
                                    <option value="" disabled>***</option>
                                    <option value="lightseagreen">LightSeaGreen</option>
                                    <option value="lightsteelblue">LightSteelBlue</option>
                                    <option value="Thistle">Thistle</option>
                                    <option value="" disabled>***</option>
                                    <option value="SandyBrown">SandyBrown</option>
                                    <option value="Wheat">Wheat</option>
                                    <option value="PaleGoldenRod">PaleGoldenRod</option>
                                    <option value="" disabled>***</option>
                                    <option value="Khaki">Khaki</option>
                                    <option value="LavenderBlush">LavenderBlush</option>
                                    <option value="LightGoldenRodYellow">LightGoldenRodYellow</option>

                                </select>
                            </div>

                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="group-hidden">Hidden:</label>
                                    <select class="form-control" id="group-hidden">
                                        <option value="">Select</option>
                                        <option value=0 selected>No (By Default)</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="group-open">Registration Open:</label>
                                    <select class="form-control" id="group-open" disabled>
                                        <option value="">Select</option>
                                        <option value=0 selected>Closed (By Default)</option>
                                        <option value=1>Open</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="group-deactive">Deactive:</label>
                                    <select class="form-control" id="group-deactive" disabled>
                                        <option value="">Select</option>
                                        <option value=0>No (By Default)</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>

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
                $('#group-duration').val(group.duration);
                $('#group-installment').val(group.installment);
                $('#group-timings').val(group.timings);
                $('#group-color').val(group.color);
                $('#group-hidden').val(group.hidden);
                $('#group-open').val(group.open);
                $('#group-deactive').val(group.deactive);
                $('#group-id').val(group.id);

            });
            $('#modal-group').modal("show");
        }

        function updateGroupInfo(){

            var name = $('#group-name').val();
            var descr = $('#group-descr').val();
            var price = $('#group-price').val();
            var duration = $('#group-duration').val();
            var installment = $('#group-installment').val();
            var timings = $('#group-timings').val();
            var color = $('#group-color').val();
            var hidden = $('#group-hidden').val();
            var open = $('#group-open').val();
            var deactive = $('#group-deactive').val();
            var id = $('#group-id').val();
            $.post("/adjax/updateSingleGroupRecord",{
                name:name,
                descr:descr,
                price:price,
                duration:duration,
                installment:installment,
                timings:timings,
                color:color,
                hidden:hidden,
                open:open,
                deactive:deactive,
                id:id

            },function (data, status) {
                console.log(data);
                $('#modal-group').modal("hide");
                readRecords();
            });
        }

        function showDiscountForm(){
            $('#modal-new-discount').modal("show");
        }

        function applyDiscount(){

            var discount = $('#new-discount-percent').val();
            console.log(discount);

            $.post("/adjax/applyDiscount",{
                discount:discount

            },function (data, status) {
                console.log(data);
                $('#modal-new-discount').modal("hide");
                readRecords();
            });
        }

        function removeDiscount(){

            //console.log(discount);

            $.post("/adjax/removeDiscount",{

            },function (data, status) {
                console.log(data);
                $('#modal-new-discount').modal("hide");
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
            var duration = $('#new-group-duration').val();
            var installment = $('#new-group-installment').val();
            var timings = $('#new-group-timings').val();
            var color = $('#new-group-color').val();
            var hidden = $('#new-group-hidden').val();
            var open = $('#new-group-open').val();
            var deactive = $('#new-group-deactive').val();

            $.post("/adjax/insertNewGroupRecord",{
                name:name,
                descr:descr,
                price:price,
                duration:duration,
                installment:installment,
                timings:timings,
                color:color,
                hidden:hidden,
                open:open,
                deactive:deactive

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
                    var response = $.parseJSON(data);
                    if(response.status === false){
                        alert(response.message);
                    }
                });
            }

        }
    </script>
@endsection

