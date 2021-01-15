<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand h1 mt-1" href="{{'/'}}">R. S. Lectures</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    @if($authUser)
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My Courses
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($courses as $course)
                            <a class="dropdown-item" href="#">{{$course->name}}</a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">All Courses</a>

                    </div>
                </li>
            </ul>

            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{--                    <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg" width="40" height="40" class="rounded-circle">--}}
                        <span class="mr-2">{{$authUser->first_name.' '.$authUser->last_name}}</span>
                        <img data-name="{{$authUser->first_name}}" width="35" height="35" class="rounded-circle initialjs">

                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{'/account/welcome'}}">Dashboard</a>
                        <a class="dropdown-item" href="#">Edit Profile</a>
                        <a class="dropdown-item" href="{{'/account/logout'}}">Log Out</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{'/admin/index'}}">Admin Area</a>
                    </div>
                </li>


            </ul>


        </div>
    @else


        <div class="my-2 my-lg-0 btn-nav mt-1 mb-1">
            <a href="{{'/login/index'}}" class="btn btn-outline-success my-2 my-sm-0">Login</a>
        </div>

    @endif
</nav>