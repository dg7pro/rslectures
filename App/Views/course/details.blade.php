@extends('layouts.boot')

@section('custom_css')

@endsection

@section('content')

    <div class="container mb-5">

        <!-- Lesson Contents for students-->
        <div class="mt-5" id="study-material">
            <h2 class="text-primary">{{$group['name']}}</h2>
            <h4 class="mb-4">{{$group['descr']}}</h4>
            {!! $group['matter']  !!}

            <span class="font-weight-bold font-italic" style="font-size: 16px; background-color: skyblue; padding: 5px; border-radius: 5px">{{'Total Fees: '. $group['price'] .' INR'}}</span><br><br>
            <span class="font-weight-bold font-italic" style="font-size: 16px; background-color: skyblue; padding: 5px; border-radius: 5px">{{'Duration: '.$group['timings'].' months'}}</span><br><br>
            <span class="font-weight-bold font-italic" style="font-size: 16px; background-color: skyblue; padding: 5px; border-radius: 5px">{{'Installments Facility: Yes, Fees can be paid in '. $group['timings'] .' installments of Rs. '.$group['installment']. ' each'}}</span><br><br>
            <span class="font-weight-bold font-italic" style="font-size: 16px; background-color: skyblue; padding: 5px; border-radius: 5px">{{'Admission/Registration Fees: 1st Installment of '.$group['installment']. ' rupees'}}</span><br><br>


            <br>

            {{--Open Auth check--}}
            @if(!$authUser)

                <a href="{{'/login/index'}}" role="button" class="btn btn-lg btn-success">Register to Enroll</a>

            @else

                @if(in_array($group['id'],$subscribed))
                    {{--<button type="submit" class="btn btn-lg btn-block btn-dark disabled">Subscribe</button>--}}
                    <a class="btn btn-lg btn-block btn-success" href="{{'/page/load?gid='.$group['id']}}" role="button">Course Dashboard</a>
                @else

                    <form action="{{'/payment/redirect-payment'}}" method="POST">

                                <input type="text" id="ORDER_ID" maxlength="20" size="20"
                                       name="ORDER_ID" autocomplete="off"
                                       value="{{"ORDS" . mt_rand() . $authUser->id}}" hidden>
                                <input type="text" id="CUST_ID" maxlength="20" size="20"
                                       name="CUST_ID" autocomplete="off"
                                       value="{{$authUser->code}}" hidden>
                                <input type="text" id="INDUSTRY_TYPE_ID" maxlength="20" size="20"
                                       name="INDUSTRY_TYPE_ID" autocomplete="off"
                                       value="Retail" hidden>
                                <input type="text" id="CHANNEL_ID" maxlength="20" size="20"
                                       name="CHANNEL_ID" autocomplete="off"
                                       value="WEB" hidden>
                                <!-- Course/Group related -->
                                <input type="text" id="COURSE_ID"
                                       name="COURSE_ID" autocomplete="off"
                                       value="{{$group['id']}}" hidden >
                                <input type="text" id="COURSE"
                                       name="COURSE" autocomplete="off"
                                       value="{{$group['name']}}" hidden >
                                <input type="text" id="TXN_AMOUNT"
                                       name="TXN_AMOUNT" autocomplete="off"
                                       value="{{$group['installment']}}" hidden >
                                <button type="submit" class="btn btn-lg btn-success">Pay 1st Installment to Enroll now</button>
                            </form>

                @endif

            @endif
            {{--End Auth check--}}
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
