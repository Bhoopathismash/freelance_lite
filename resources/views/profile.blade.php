@extends('layouts.base')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>Profile</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page Header End -->  

    <!-- Content section Start --> 
    <section class="section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="post-job box">
              <div class="row">
                <div class="col-lg-6">
                  <h3 class="job-title">Profile</h3>
                  <div class="form-group">
                    <label>Email</label>
                    <input id="email" class="form-control"  value="{{ $user->email }}" readonly>                    
                  </div>                             
                  <form method="POST" action="{{ route('profileUpdate') }}" >
                    @csrf
                    <div class="form-group">
                      <label>Name</label>
                      <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus placeholder="Name">
                    </div>
                    <button class="btn btn-common log-btn mt-3" type="submit" >Update</button>
                  </form>
                </div>

                <div class="col-lg-6">
                  <h3 class="job-title">Bids</h3>
                  @if($user_bid_packages->bidPackage)
                  <div>
                    <label>Membership Plan</label>
                    <p>{{$user_bid_packages->bidPackage->name}}</p>
                    <p>{{$user_bid_packages->bidPackage->period}}</p>
                    <p>{{$user_bid_packages->bidPackage->no_of_bids}}</p>
                  </div>
                  @endif

                  <div>  
                    <label>Bid Details</label>
                    <p><b>Number of bids placed: </b>{{$user_bid_packages->no_of_bids}}</p>
                    <p><b>Balance bids: </b>{{$user_bid_packages->balance_bids}}</p>
                    <p><b>Plan purchased on: </b>{{date('d-m-Y',strtotime($user_bid_packages->created_at))}}</p>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                  <div class="col-lg-6">
                      <div class="security-content">
                          <h3 class="job-title">Password</h3>
                          <h6>Create a new password for your account</h6>
                      </div>
                  </div>
                  <div class="col-lg-6">
                      <form action="{{url('/change/password')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="security-content">
                            <h3 class="job-title">Change Password</h3>
                            <div class="form-group">                  
                              <label>Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control"autocomplete="off" required="">
                            </div>
                            <div class="form-group">
                              <label>New Password</label>
                                <input type="password" id="new_password" name="password" class="form-control" autocomplete="off" required="" >
                            </div>
                            <div class="form-group">
                              <label>New Password Confirmation</label>
                                <input type="password" id="conform_passwordRepeat" name="password_confirmation" class="form-control" required="">
                            </div>
                            <button type="submit" class="btn btn-common">Change Password</button>
                        </div>
                      </form>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Content section End -->   
@endsection

@section('scripts')
    
@endsection