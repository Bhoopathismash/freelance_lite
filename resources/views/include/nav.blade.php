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

                @if(Auth::check())

                  <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                  </li>               

                  <?php $nav_user=Auth::user(); ?>  
                  
                  @if($nav_user->user_type!=2)              
                    <li class="nav-item {{ Request::is('post_job') ? 'active' : '' }}">
                      <a href="{{route('postJob')}}" class="nav-link">Post a Job</a>
                    </li>
                  @endif  

                  @if($nav_user->user_type==1)              
                    <li class="nav-item {{ Request::is('joblist') ? 'active' : '' }}">
                      <a href="{{route('jobList')}}" class="nav-link">Jobs</a>
                    </li>
                  @else
                    <li class="nav-item {{ Request::is('jobs') ? 'active' : '' }}">
                      <a href="{{route('jobs')}}" class="nav-link">Jobs</a>
                    </li>
                  @endif
                  
                  <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('profile')}}">Profile</a>
                  </li>
                
                @endif

                <li class="nav-item {{ Request::is('faq') ? 'active' : '' }}">
                  <a class="nav-link" href="{{route('faq')}}">How it works</a>
                </li>

                @if(Auth::check())
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">Sign Out</a>
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