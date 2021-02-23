@extends('layouts.boot')

@section('content')

    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">RS Lectures</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/list-group'}}">Courses</a></li>

                        <li class="breadcrumb-item active" aria-current="page">{{'Change Order'}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- First Row  -->
        <div class="row mt-3 mb-3">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Change Order

                        </h2>
                    </div>
                    <div class="card-body">
                        {{--                        <p class="mb-5">These users need approval before their profile gets live.</p>--}}
                        <p class="mb-5">This is the order in which contents will be visible.</p>

                        <form>
                            <div id="records_content">
                                {{--<table class="table table-bordered">
                                    <tbody>
                                    <form action="">
                                        @if(count($arr)>0)
                                            @foreach($arr as $unit)
                                                @if(count($unit['lessons'])>0)
                                                    <tr><td colspan="3">Unit: {{$unit['no']}}</td></tr>

                                                    @foreach($unit['lessons'] as $row)
                                                        <tr>
                                                            <td>{{ $row['id'] }}</td>
                                                            <td><a href="/lesson/display?pdf={{$row['name']}}" target="_blank">{{$row['title']}}</a></td>
                                                            <td>
                                                                <select class="form-control" id="exampleFormControlSelect1" name="sno[]">
                                                                    <option>Change Order</option>
                                                                    @for($i=1;$i<=$num;$i++)
                                                                        <option value="{{$i}}" {{$row['sno']==$i?'Selected':''}}>{{$i}}</option>
                                                                    @endfor

                                                                </select>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                @endif
                                            @endforeach

                                        @endif
                                    </form>
                                    </tbody>
                                </table>--}}


                            </div>
                        </form>
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
                url: "/Adjax/listGroupsForChangingOrder",
                type: "POST",
                data: {
                    readrecord:readrecord
                },
                success: function(data,status){
                    //console.log(readrecord)
                    //console.log(data);
                    $('#records_content').html(data);
                }
            })
        }

        function setSno($id, $sno){

            console.log($id);
            console.log($sno);

            if($id && $sno){
                $.ajax({
                    type:'POST',
                    url:'/Adjax/changeGroupOrder',
                    data:{
                        id:$id,
                        sno:$sno
                    },
                    success:function(data,status){
                        readRecords();
                    }
                });
            }


        }

    </script>


@endsection

