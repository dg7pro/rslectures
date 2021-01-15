@extends('layouts.boot')

@section('title', 'RS Lectures')

@section('content')

    <div class="content">

        @include('layouts.partials.flash')

        <div class="row">

            <div class="col-lg-6">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Links and Buttons </h2>
                    </div>
                    <div class="card-body">
{{--                        <p class="mb-5">Use &lt;a&gt;s or &lt;button&gt;s to create actionable list group items with hover, disabled, and active states by adding .list-group-item-action. Read bootstrap documentaion for<a href="https://getbootstrap.com/docs/4.4/components/list-group/#links-and-buttons" target="_blank"> more details.</a></p>--}}
                        <div class="list-group">
                            {{--<a href="#" class="list-group-item list-group-item-action active">
                                Cras justo odio
                            </a>--}}
                            @foreach($items as $item)
                                <a href="#" class="list-group-item list-group-item-action">{{$item['name']}}</a>
                            @endforeach
                           {{-- <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
                            <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                            <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                            <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>--}}
                        </div>
                    </div>
                </div>
            </div>


        </div>




    </div>

@endsection

@section('app-script')




@endsection

