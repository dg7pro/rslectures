@extends('layouts.boot')

@section('content')

    <div class="container">

        <h1 class="mt-5">{{$content['title']}}</h1>
        {!! $content['matter']  !!}

    </div>

@endsection