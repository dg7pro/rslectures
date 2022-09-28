@extends('layouts.boot')

@section('content')

  {{-- <div class="container-fluid">


      <h1 class="mt-5">R.S. Lectures Home</h1>
   </div>--}}
{{--   #ffa45b--}}
   <div class="position-relative overflow-hidden p-3 p-md-5 text-center" style="background-color: #fd7e67">
      <div class="col-md-8 p-lg-5 mx-auto my-5">
         <h1 class="display-4 font-weight-normal">e-Learning</h1>
{{--         <p class="lead font-weight-normal">And an even wittier subheading to boot. Jumpstart your marketing efforts with this example based on Apple's marketing pages.</p>--}}
{{--         <p class="lead font-weight-normal">Completing your regular course was never so easy before, during the Corona lockdowns. We provide easy and complete subject matter, of all university courses</p>--}}
         <p class="lead font-weight-normal">Learning online is the easiest way to enhance and boost your carrier. It saves
            time, money, transportation charges and unnecessary efforts, in other words it is completely hassle-free,
            with comfort and safety of home. When government has taken initiative of Digital India, e-Learning is the
            best choice for students of 21st century.
         </p>
         {{--<a class="btn btn-dark" href="{{'/register/index'}}">Register/ Signup</a>--}}
         <a class="btn btn-dark" href="{{'/courses'}}">Courses Available</a>
      </div>
      <div class="product-device shadow-sm d-none d-md-block"></div>
      <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
   </div>

  <div class="container">
     <!-- Example row of columns -->
     <div class="row text-center mt-5 mb-5">
        <div class="col-md-12">
           <h2 class="text-warning">About R.S. Lectures</h2>
           <p>This website is dedicated to online courses and lectures. Online mode of education is cheaper from
              student’s point of views. It is faster also. The various courses available on this website is designed
              and drafted in such a way that students get maximum about the subject matter in lesser effort. In year 2020, during the
              Corona Lockdown periods, we decided to go online and provide e-learning service, to our students through live online classes & various other e-learning modes such as docs, pdfs, videos etc.
              on their demands. Our courses include a bunch of technical & regular courses
           </p>
           <p>
              Education is the process of the acquisition of knowledge and skills. R S Publishing, not only involves
              in planning, editing, acquisition, but we also work on copy editing, copyrighting, designing, art
              directing, production managing, distributing, selling and promoting etc.
           </p>
           <p>
              The publication is truly difficult but not with us. It involves risk of not selling, published books.
              Having finished your book and having it published are incredible moments, but between them, there may be
              some halts disappointments. R S Publishing plays an important role here by correct advising till
              publication of actual no. of units, to marketing & advertisement. So if you want to publish your books
              please drop us a message at address/email given in footer section of the website.
           </p>


           <p>
              {{--<a class="btn btn-secondary" href="{{'/company/read-more'}}" role="button">View details &raquo;</a>--}}
              <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#myModal">Start Online Learning &raquo;</button>
           </p>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Just 5 simple steps:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                 <div class="modal-body">
                    <p>
                       <b><span class="text-primary">Step 1: Create Account</span></b>
                       <br><span>Please Register to create account</span>
                    </p>
                    <p>
                       <b><span class="text-primary">Step 2: Verify your Email</span></b>
                       <br><span>Check your registered Email for verification link</span>
                    </p>
                    <p>
                       <b><span class="text-primary">Step 3: Select Course</span></b>
                       <br><span>Select the course you want to enroll</span>
                    </p>
                    <p>
                       <b><span class="text-primary">Step 4: Make Payment</span></b>
                       <br><span>Pay the prescribed fees of that course</span>
                    </p>
                    <p>
                       <b><span class="text-primary">Step 5: Start Learning</span></b>
                       <br><span>Find the awesome Course material & Start learning</span>
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




  </div>

  @include('layouts.footer2')



@endsection