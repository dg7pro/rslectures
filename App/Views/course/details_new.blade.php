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

            <a href="https://wa.me/7565097233?text=I'm%20want%20to%20take%20admission%20in%20{{$group['name']}}%20course" target="_blank"
               class="btn btn-lg btn-success" role="button" aria-pressed="true"><i class="fab fa-whatsapp"> </i> Chat directly to Executive</a>

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
