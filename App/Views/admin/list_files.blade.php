@extends('layouts.boot')

@section('content')

    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">RS Lectures</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Files</li>
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
                            Unattached Files
                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">The page shows all unatached pdf files</p>

                        <div id="records_content">


                        </div>
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
                url: "/adjax/fetchFileRecords",
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

        //=================
        // Delete Record
        //=================
        function deleteFileInfo(id){

            var result = window.confirm('Are you sure?');
            if (result === false) {
                // e.preventDefault();
                console.log('He cancelled');
            }else {
                console.log('He is sure');
                $.post("/adjax/deleteFileRecord",{
                    id:id

                },function (data, status) {
                    console.log(data);
                    readRecords();
                });
            }

        }
    </script>
@endsection

