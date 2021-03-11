@extends('layouts.boot')

@section('custom_css')

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


@endsection

@section('content')

    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">RS Lectures</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/list-group'}}">Courses</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/list-content-txt?sid='.$content['subject_id']}}">Editors List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$content['title']}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- First Row  -->
        <div class="row mt-3 mb-5">
            <div class="col-lg-12">
                <h2>
                    {{$content['title']}}<a href="{{'/lesson/index?cid='.$content['id']}}" target="_blank" class="ml-3"><i class="fas fa-external-link-alt"></i></a>
                </h2>

                <p class="mb-5">Administrator can only change matter of this content </p>

                @include('layouts.partials.flash')

                <div>
                    <form method="post" action="/admin/save-content">
                        <textarea id="mytextarea" style="height:50em" name="matter">{{$content['matter']}}</textarea>
                        <input type="hidden" name="content_id" value="{{$content['id']}}">
                        <button type="submit" name="update_content" class="btn btn-lg btn-dark mt-4">Update Content</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')

    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'mytextarea' );


    </script>

    {{--    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
    {{--    <script src="https://cdn.tiny.cloud/1/shrm9xd072ygg6dba6kl4rixb7ya8jw5elx0miwbmibli7mi/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
    {{--<script>
        tinymce.init({
            selector: '#mytextarea',
            menubar: 'file edit insert view format table tools help',
            branding: false
        });
    </script>
--}}




@endsection

