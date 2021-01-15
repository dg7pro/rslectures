@extends('layouts.boot')

@section('custom_css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

@endsection

@section('content')

    <div class="container-fluid">

    <!-- First Row  -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>
                            Bordered Table
                            <button onclick="showNewGroupForm()" type="button" class="mb-1 ml-3 btn btn-sm btn-primary">Add Group +</button>
                        </h2>
                    </div>
                    <div class="card-body">
                        {{--<p class="mb-5">These users need approval before their profile gets live.</p>

                        <div id="records_content"></div>--}}

                        <div class="table-responsive">

                            <table id="user_data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">Id</th>
                                    <th width="30%">First Name</th>
                                    <th width="30%">Last Name</th>
                                    <th width="10%">Edit</th>
                                    <th width="10%">Delete</th>
                                    <th width="10%">View</th>
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection

@section('script')
    <script type="text/javascript" language="javascript" >
        $(document).ready(function(){
            $('#add_button').click(function(){
                $('#user_form')[0].reset();
                $('.modal-title').text("Add User");
                $('#action').val("Add");
                $('#operation').val("Add");
                $('#user_uploaded_image').html('');
            });

            var dataTable = $('#user_data').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"fetch.php",
                    type:"POST"
                },
                "columnDefs":[
                    {
                        "targets":[0, 3, 4],
                        "orderable":false,
                    },
                ],

            });


@endsection

