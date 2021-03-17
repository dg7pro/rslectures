@extends('layouts.boot')

@section('custom_css')

@endsection

@section('content')

    <div class="container">

        <!-- Lesson Contents for students-->
        <div class="mt-5" id="study-material">
            <h2 class="text-primary">{{$content['title']}}</h2>
            {!! $content['matter']  !!}
        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            //Disable part of page
            $("#study-material").on("contextmenu",function(e){
                return false;
            });

            //Disable part of page
            $('#study-material').bind('cut copy paste', function (e) {
                e.preventDefault();
            });
        });
    </script>
@endsection
