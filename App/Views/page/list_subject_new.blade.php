@extends('layouts.boot')

@section('content')

    <div class="container">

        <h3 class="text-success mt-5">{{$course['name']}}</h3>
        <p>Select the subject you want to study...</p>


        <div class="row mt-2">
            <div class="col-md-6">
                <table class="table table-bordered table-stripped mb-5">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">All Subjects</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td><a href="{{'/page/list-content-new?sid='.$subject['id'] }}">{{$subject['name']}}</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')


@endsection

