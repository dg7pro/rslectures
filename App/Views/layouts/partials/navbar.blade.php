
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm">
    <a class="navbar-brand mt-1 mb-2" href="{{'/'}}">R. S. Lectures</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">


        <ul class="navbar-nav mr-auto">
            @if($authUser)
                <li class="nav-item">
                    <a class="nav-link" href="{{'/account/welcome'}}"><mark> Dashboard</mark></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{'/subscribe/index'}}"><mark> Courses</mark></a>
                </li>
               {{-- <li class="nav-item">
                    <a class="nav-link" href="{{'/home/catalog'}}"><mark> Catalog</mark></a>
                </li>--}}
                {{--<li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>--}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <mark>My Area</mark>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($courses as $course)
                            <a class="dropdown-item" href="{{'/page/load?gid='.$course->gid}}">{{$course->name}}</a>
                        @endforeach
                        @if(!empty($courses))
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{'/account/welcome'}}">Subscription</a>
                       {{-- <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{'/Subscribe/index'}}">Other Courses</a>--}}
                    </div>
                </li>
                {{--<li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>--}}

            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{'/account/welcome'}}"><mark>Dashboard</mark> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{'/subscribe/index'}}"><mark> Courses</mark></a>
                </li>
               {{-- <li class="nav-item">
                    <a class="nav-link" href="{{'/home/catalog'}}"><mark> Catalog</mark></a>
                </li>--}}
            @endif
        </ul>



        <div class="my-2 my-lg-0">
            @if($authUser)
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2">{{$authUser->first_name.' '.$authUser->last_name}}</span>
                            <img data-name="{{$authUser->first_name}}" width="35" height="35" class="rounded-circle initialjs">

                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">{{'UID: '.$authUser->code}}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{'/account/welcome'}}">Dashboard</a>
                            <a class="dropdown-item" href="{{'/account/edit-profile'}}">Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{'/account/logout'}}">Log Out</a>
                            @if($authUser->is_admin)
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{'/admin/index'}}">Admin Area</a>
                            @endif
                        </div>
                    </li>
                </ul>
            @else
                {{--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">--}}
                {{--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>--}}
                <a href="{{'/login/index'}}" class="btn btn-outline-success my-2 my-sm-0  mt-1 mb-2">Login</a>
                <a href="{{'/register/index'}}" class="btn btn-primary my-2 my-sm-0  mt-1 mb-2">Register</a>
            @endif
        </div>


    </div>
</nav>

{{--
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="#">Features</a>
        <a class="p-2 text-dark" href="#">Enterprise</a>
        <a class="p-2 text-dark" href="#">Support</a>
        <a class="p-2 text-dark" href="#">Pricing</a>
    </nav>
    <a class="btn btn-outline-primary" href="#">Sign up</a>
</div>--}}
