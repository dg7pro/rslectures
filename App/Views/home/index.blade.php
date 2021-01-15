@extends('layouts.boot')

@section('content')

  {{-- <div class="container-fluid">


      <h1 class="mt-5">R.S. Lectures Home</h1>
   </div>--}}

   <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center" style="background-color: #ffa45b">
      <div class="col-md-5 p-lg-5 mx-auto my-5">
         <h1 class="display-4 font-weight-normal">Learning Online</h1>
{{--         <p class="lead font-weight-normal">And an even wittier subheading to boot. Jumpstart your marketing efforts with this example based on Apple's marketing pages.</p>--}}
         <p class="lead font-weight-normal">Completing your regular course was never so easy before, during the Corona lockdowns. We provide easy and complete subject matter, of all university courses</p>
         <a class="btn btn-outline-secondary" href="{{'/register/index'}}">Register/ Signup</a>
      </div>
      <div class="product-device shadow-sm d-none d-md-block"></div>
      <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
   </div>

  <div class="container">
     <!-- Example row of columns -->
     <div class="row text-center mt-5">
        <div class="col-md-12">
           <h2 class="text-warning">About R.S. Lectures</h2>
           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
              dolore magna aliqua. Ornare quam viverra orci sagittis eu. Sed cras ornare arcu dui vivamus arcu felis
              bibendum. Turpis egestas integer eget aliquet nibh praesent. Sed cras ornare arcu dui vivamus arcu felis
              bibendum ut. Natoque penatibus et magnis dis. In mollis nunc sed id. Ut sem viverra aliquet eget sit.
              Semper risus in hendrerit gravida rutrum. Ut tellus elementum sagittis vitae et leo. Cursus in hac
              habitasse platea dictumst quisque. Urna molestie at elementum eu facilisis sed odio morbi quis.
           </p>
           <p>
              Praesent elementum facilisis leo vel fringilla est. Rutrum quisque non tellus orci. Morbi tristique
              senectus et netus et. Quis risus sed vulputate odio ut enim blandit. Euismod elementum nisi quis eleifend
              quam. Massa tincidunt dui ut ornare lectus sit amet. Porttitor leo a diam sollicitudin tempor id eu nisl
              nunc. Neque laoreet suspendisse interdum consectetur libero id faucibus nisl. Aenean sed adipiscing diam
              donec adipiscing tristique risus nec. Lectus sit amet est placerat in egestas erat.
           </p>

           <p>
              {{--<a class="btn btn-secondary" href="{{'/company/read-more'}}" role="button">View details &raquo;</a>--}}
              <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#myModal">View details &raquo;</button>
           </p>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                 <div class="modal-body">
                    <p>
                       Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                       egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
                    </p>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                 </div>
              </div>
           </div>
        </div>

        {{--<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="gridModalLabel">Grids in modals</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                    <p>
                       Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                       egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
                    </p>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                 </div>
              </div>
           </div>
        </div>
--}}

     </div>

     {{--<div class="row text-center border-top">

        <div class="col-md-12">

           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
              dolore magna aliqua. Ornare quam viverra orci sagittis eu. Sed cras ornare arcu dui vivamus arcu felis
              bibendum. Turpis egestas integer eget aliquet nibh praesent. Sed cras ornare arcu dui vivamus arcu felis
              bibendum ut. Natoque penatibus et magnis dis. In mollis nunc sed id. Ut sem viverra aliquet eget sit.
              Semper risus in hendrerit gravida rutrum. Ut tellus elementum sagittis vitae et leo. Cursus in hac
              habitasse platea dictumst quisque. Urna molestie at elementum eu facilisis sed odio morbi quis.
           </p>
        </div>
     </div>--}}

     {{--<footer class="page-footer font-small blue border-top mt-5 mb-3">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
           <a href="{{'/company/read-more'}}"> R S Lectures</a> |
           <a href="{{'/company/privacy-policy'}}"> Privacy</a> |
           <a href="{{'/company/tnc'}}"> T&C</a> |
           <a href="{{'/company/disclaimer'}}"> Disclaimer</a>

        </div>
        <!-- Copyright -->

     </footer>--}}

     @include('layouts.footer')


  </div>



@endsection