@extends('layouts.boot')

@section('content')

    <div class="container-fluid">

    <!-- First Row  -->
        <div class="row mt-5">
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


                        <form method='post' action="{{'/admin/handle-upload'}}" enctype='multipart/form-data'>

                            <div class="form-group">
                                <label for="file">Select files to upload</label>
                                <input type="file" class="form-control-file" name="file[]" id="file" multiple>
                            </div>

                            <div class="form-group mt-5">
                                <input type='submit' name='submit' value='Upload' class="btn btn-primary">
                            </div>
                        </form>



                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection

@section('script')


@endsection

