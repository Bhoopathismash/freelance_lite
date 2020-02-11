@extends('layouts.base')

@section('content')
<style type="text/css">
  .package-block{
    .flex: 0 0 19.666667%;
    max-width: 19.666667%;
    padding: 20px;
    text-align: center;
  }
</style>

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
                @foreach($bid_packages as $value)
                  <div class="col-lg-2 col-md-2 package-block">
                    <div class="MembershipPlan-header-inner ">
                      <div class="MembershipPlan-header-title">
                          <h3 class="job-title">
                              {{$value->name}}
                          </h3>
                      </div>
                      <p class="MembershipPlan-price  MembershipPlan-price--small">{{$value->amount >0 ? $value->amount : "Free"}}</p>
                      <p class="MembershipPlan-duration MembershipPlan-duration--no-discount">{{$value->period}} month</p>
                      <p class="MembershipPlan-duration MembershipPlan-duration--no-discount">{{$value->no_of_bids}} Bids Per Month</p>
                      <!-- NEW -->
                      <div class="MembershipPlan-cta">
                        <a href="{{route('payPackage',$value->id)}}" class="btn btn-small btn-info">Get Started!</a>
                      </div>
                    </div>
                  </div>               
                @endforeach
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