<!DOCTYPE html>
<html lang="en">
  <head>
    @include('include.header')
    <title>Home | Welcome to Setetres</title>
  </head>
  
  <body>

    <!-- Header Section Start -->
    <header id="home" class="hero-area">
		@include('include.nav')
    <div class="user-alert">
      @include('common.notify')      
    </div>

   	@yield('home_content')
               
    </header>
    <!-- Header Section End --> 

    @yield('content')

    @include('include.footer')
    @include('include.script')
    
  </body>
</html>