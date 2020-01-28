<!DOCTYPE html>
<html lang="en">
  <head>
    @include('include.authheader')
    <title>Home | Welcome to Setetres</title>
  </head>
  
  <body>

    <!-- Header Section Start -->
    <header id="home" class="hero-area">
		@include('include.nav')
   	@yield('home_content')
               
    </header>
    <!-- Header Section End --> 

    @yield('content')

    @include('include.footer')
    @include('include.script')
    
  </body>
</html>