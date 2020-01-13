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
              <a href="/" class="navbar-brand"><img src="assets/img/logo.png" class="img-fluid" alt="setetres"></a>
            </div>
            <div class="collapse navbar-collapse" id="main-navbar">
              <ul class="navbar-nav mr-auto w-100 justify-content-end">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('faq')}}">How it works</a>
                </li>
                 <li class="nav-item active">
                  <a class="nav-link" href="{{route('login')}}">Sign In</a>
                </li>
                <li class="button-group">
                  <a href="post-job" class="button btn btn-common">Post a Job</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="mobile-menu" data-logo="assets/img/logo.jpeg"></div>
      </nav>