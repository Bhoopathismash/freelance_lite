@extends('layouts.auth')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>Create Your account</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page Header End --> 

    <!-- Content section Start --> 
    <section id="content" class="section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-6 col-xs-12">
            <div class="page-login-form box">
              <h3>
                Create Your account
              </h3>
              <div id="response"></div>
                <form method="POST" action="{{ route('register') }}" class="login-form">
                    @csrf
                    <div class="form-group">
                      <div class="input-icon">
                        <i class="lni-user"></i>

                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div> 
                    <div class="form-group">
                      <div class="input-icon">
                        <i class="lni-envelope"></i>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email Address">

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div> 
                    <div class="form-group">
                      <div class="input-icon">
                        <i class="lni-lock"></i>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>  
                    <div class="form-group">
                      <div class="input-icon">
                        <i class="lni-unlock"></i>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Retype Password">
                      </div>
                    </div>     

                    <div class="form-group">
                      <div class="input-icon">
                        <label>Want to work</label>
                        <input id="user_type1" type="radio" class="form-control" name="user_type" required value="2">

                         <label>Want to hire</label>
                        <input id="user_type2" type="radio" class="form-control" name="user_type" required value="1">
                      </div>
                    </div>  

                    <button class="btn btn-common log-btn mt-3" type="submit" >Register</button>
                    <p class="text-center">Already have an account?<a href="login"> Sign In</a></p>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Content section End --> 
@endsection
