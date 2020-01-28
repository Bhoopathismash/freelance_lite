@extends('admin.layout.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5" style="margin: 60px auto auto auto;">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Admin Login</h3></div>
                <div class="card-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                            <input class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Enter email address"  name="email" value="{{ old('email') }}" autofocus/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="small mb-1" for="inputPassword">Password</label>
                            <input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password"  name="password" />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- <div class="form-group">
                            <div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" name="remember" /><label class="custom-control-label" for="rememberPasswordCheck">Remember password</label></div>
                        </div> -->
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                            <!-- <a class="btn btn-primary" href="index.html">Login</a> -->
                            <button type="submit" class="btn btn-primary" style="margin: 0 auto;width: 200px;">Login</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="card-footer text-center">
                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
