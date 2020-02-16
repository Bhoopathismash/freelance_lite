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
                   

                  <form method="POST" action="{{ route('profileUpdate') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                      <label>Profile Image</label><br>
                      <img  @if($user->profile_image) src="{{$user->profile_image}}" @else src="/assets/img/user-icon.png" @endif   class="img-thumbnail float-left" width='100' />
                      
                      <input id="profile_image" type="file" class="form-control" name="profile_image" style="width: 80%; margin-left: 10px; " />
                    </div>

                    <div class="form-group clear">
                      <br>
                      <label>Name</label>
                      <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus placeholder="Name">
                    </div>

                    <div class="form-group">
                      <label>Description</label>
                      <input id="description" type="text" class="form-control" name="description" value="{{ $user->description }}" placeholder="Description">
                    </div>

                    <div class="form-group">
                      @if($user->email_verified==1)
                        <p><span class="text-success"><b><i class="lni-check-mark-circle"></i></b></span> Email Verified</p>
                      @else
                        <p><span class="text-danger"><b><i class="lni-cross-circle"></i></b></span> Email Not Verified</p>
                      @endif
                    </div>

                    <div class="form-group">
                      @if($user->admin_verified==1)
                        <p><span class="text-success"><b><i class="lni-check-mark-circle"></i></b></span> Admin Verified</p>
                      @else
                        <p><span class="text-danger"><b><i class="lni-cross-circle"></i></b></span> Admin Not Verified</p>
                      @endif
                    </div>
                    
                    <div class="form-group">
                      <button class="btn btn-common log-btn mt-3" type="submit" >Update</button>
                    </div>
                  </form>
                </div>

                <div class="col-lg-6">
                  <h3 class="job-title">Change E-mail</h3>
                  <h6>Change email with caution</h6>
                  <form method="POST" action="{{ route('profileUpdate') }}" >
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input id="email" class="form-control"  value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-common log-btn mt-3" type="submit" >Update</button>
                    </div>
                  </form>   

                </div>
               
              </div>
              <br>
              <div class="row">
                  
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

                  @if($user_bid_packages && $user->user_type==2)
                  <div class="col-lg-6">
                    <h3 class="job-title">Bids</h3>                    
                    <div class="float-left">  
                      <h6>Bid Details</h6>
                      <p><b>Number of bids placed: </b>{{$user_bid_packages->used_bids}}</p>
                      <p><b>Balance bids: </b>{{$user_bid_packages->balance_bids}}</p>
                      <p><b>Plan purchased on: </b>{{date('d-m-Y',strtotime($user_bid_packages->created_at))}}</p>
                    </div>

                    @if(isset($user_bid_packages->bidPackage))
                    <div class="float-right">
                      <h6>Membership Plan</h6>
                      <p><b>Plan Name: </b> {{$user_bid_packages->bidPackage->name}}</p>
                      <p><b>Period: </b> {{$user_bid_packages->bidPackage->period}} month</p>
                      <p><b>Number of bids bought: </b> {{$user_bid_packages->bidPackage->no_of_bids}}</p>
                    </div>
                    @endif

                    <br>
                    <a href="{{route('package')}}" class="btn btn-common">Go to membership page</a>
                  </div>

                @endif
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