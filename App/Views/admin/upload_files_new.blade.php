@extends('layouts.boot')


@section('custom_css')

    <link rel="stylesheet" type="text/css" href="{{'/css/uploadifive.css'}}">

    <style type="text/css">
        body {
            /*font: 13px Arial, Helvetica, Sans-serif;*/
        }
        .uploadifive-button {
            float: left;
            margin-right: 10px;
        }
        #queue {
            border: 1px solid #E5E5E5;
            height: 177px;
            overflow: auto;
            margin-bottom: 10px;
            padding: 0 3px 3px;
            width: 300px;
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
                        <li class="breadcrumb-item active" aria-current="page">Upload PDF Files</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- First Row  -->
        <div class="row mt-3">
            <div class="col-lg-12">

                @include('layouts.partials.flash')

                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>
                            Upload PDF

                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">You can Upload Multiple at once.</p>


                        {{--<form method='post' action="{{'/admin/handle-upload'}}" enctype='multipart/form-data'>

                            <div class="form-group">
                                <label for="file">Select files to upload</label>
                                <input type="file" class="form-control-file" name="file[]" id="file" multiple>
                            </div>

                            <div class="form-group mt-5">
                                <input type='submit' name='submit' value='Upload' class="btn btn-primary">
                            </div>
                        </form>--}}

                        <form>
                            <div id="queue"></div>
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a>
                        </form>




                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection

@section('script')

    {{--<script src="{{'/js/jquery.min.js'}}" type="text/javascript"></script>--}}
    <script src="{{'/js/jquery.uploadifive.js'}}" type="text/javascript"></script>

    <script type="text/javascript">
        {!! $timestamp = time() !!}

        $(function() {
            $('#file_upload').uploadifive({
                'auto'             : false,
                'checkScript'      : '/admin/check-exists',
                'fileType'         : 'image/pdf',
                'formData'         : {
                                        'timestamp' : '{{ $timestamp }}',
                                        'token'     : '{{ md5('unique_salt' . $timestamp) }}'
                                    },
                'queueID'          : 'queue',
                'uploadScript'     : '/admin/uploadifive',
                'onUploadComplete' : function(file, data) { console.log(data); }
            });
        });
    </script>

@endsection

