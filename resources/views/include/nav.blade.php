<nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
        <div class="container">
          <div class="theme-header clearfix">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="lni-menu"></span>
                <span class="lni-menu"></span>
                <span class="lni-menu"></span>
              </button>
              <a href="/" class="navbar-brand"><img src="/assets/img/logo.png" class="img-fluid" alt="setetres"></a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
              <ul class="navbar-nav mr-auto w-100 justify-content-end">
                <li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
                  <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>

                <!-- All jobs -->   
                <li class="nav-item {{ Request::is('jobs') ? 'active' : '' }}">
                  <a href="{{route('jobs')}}" class="nav-link">Browse</a>
                </li>
                <!-- <li class="nav-item {{ Request::is('faq') ? 'active' : '' }}">
                  <a class="nav-link" href="{{route('faq')}}">How it works</a>
                </li> -->

                <?php $nav_user=Auth::user(); ?>  
                @if(Auth::check())
                  <!-- <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                  </li>  -->              

                  <!-- Worker taken jobs -->   
                  <li class="nav-item {{ Request::is('my_jobs') ? 'active' : '' }}">
                    <a href="{{route('myJobs')}}" class="nav-link">Projects Taken</a>
                  </li>

                  <!-- Hirer own jobs -->             
                  <li class="nav-item {{ Request::is('joblist') ? 'active' : '' }}">
                    <a href="{{route('jobList')}}" class="nav-link">My Projects</a>
                  </li>                               

                  
                  <li class="nav-item {{ Request::is('post_job') ? 'active' : '' }}">
                    <a href="{{route('postJob')}}" class="nav-link">Post a Job</a>
                  </li>

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  text-capitalize" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img  @if($nav_user->profile_image) src="{{$nav_user->profile_image}}" @else src="/assets/img/user-icon.png" @endif   class="img-thumbnail" width='50' /> &nbsp; {{$nav_user->name}} <i class="lni-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{route('profile')}}">Profile</a>
                      <a class="dropdown-item" href="{{route('logout')}}">Sign Out</a>
                    </div>
                  </li>                               
                @else
                  <li class="nav-item active">
                    <a class="nav-link" href="{{route('login')}}">Sign In</a>
                  </li>
                @endif

              </ul>
            </div>
          </div>
        </div>
        <div class="mobile-menu" data-logo="assets/img/logo.jpeg"></div>
      </nav>