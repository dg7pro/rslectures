@extends('layouts.boot')

@section('custom_css')

@endsection

@section('content')

    <div class="container">

        <!-- Lesson Contents for students-->
        <div class="mt-5">
            <h2 class="text-primary">{{$content['title']}}</h2>
            {!! $content['matter']  !!}
        </div>

    </div>

@endsection
