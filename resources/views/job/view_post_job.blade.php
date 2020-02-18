@extends('layouts.base')

@section('content')
 <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-8 col-md-6 col-xs-12">
            <div class="breadcrumb-wrapper">
              <!-- <div class="img-wrapper">
                <img src="assets/img/about/company-logo.png" alt="">
              </div> -->
              <div class="content" style="padding-left:0px;">
                <h3 class="product-title text-capitalize">{{$job->job_title}}</h3>
                <p class="brand">{{@$job->category->category_name}}</p>
                <div class="tags">  
                  <span class="text-capitalize"><i class="lni-map-marker"></i> {{@$job->location}}</span>  
                  <span><i class="lni-calendar"></i> Posted {{date('D F, Y',strtotime($job->created_at))}}</span>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="month-price">
              <span class="year">Yearly</span>
              <div class="price">$65,000</div>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <!-- Page Header End --> 

    <!-- Job Detail Section Start -->  
    <section class="job-detail section">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-8 col-md-12 col-xs-12">
            <div class="content-area">  
              <h4>Job Description</h4>
              {{$job->tagline}}
              <br>
              <br>
              {!!html_entity_decode($job->description)!!}

              <div class="content-area">  
                <h4>Attachments</h4>
                @forelse($job->jobFiles as $key => $value)
                   <a href="/{{$value->document}}" class="btn btn-default" download> <i class="lni-download"></i> File {{$key+1}}</a>
                @empty
                  <p>No Files Added</p>
                @endforelse
              </div>
              @if($user)
                @if(($user->id==$job->user_id || $user->id==$job->assigned_to) && $job->status > 0)
                  <h5>Milestones</h5>
                   @foreach($job->milestone as $value)
                      @if($user->id==$job->user_id || ($job->user_id!=$user->id && $value->release_status==1))
                        <div class="job-listings">
                          <label><b>Milestone:</b></label> {{$value->milestone}}<br>
                          <label><b>Description:</b></label> {{$value->description}}<br>
                          <label><b>Amount:</b></label> {{$value->amount}}<br>
                          @if($value->worker_status)<label><b>Worker Status:</b></label> {{$value->worker_status}}<br>@endif
                          @if($value->worker_comment)<label><b>Worker Comment:</b></label> {{$value->worker_comment}}<br>@endif
                          @if($value->hirer_status)<label><b>Hirer Status:</b></label> {{$value->hirer_status}}<br>@endif
                          @if($value->hirer_comment)<label><b>Hirer Comment:</b></label> {{$value->hirer_comment}}<br>@endif
                          @if($value->payment_status==1)<label><b>Payment Status:</b></label> Paid<br>@endif
                          @if($value->paid_amount)<label><b>Paid Amount:</b></label> {{$value->paid_amount}}<br>@endif

                          @if($user->id==$job->user_id)
                            <div class="float-right">        
                              @if($value->release_status==0)
                                <a href="{{route('releaseMilestone',$value->id)}}" class="btn btn-common">Release Milestone</a>
                              @else
                                @if(!$value->razorpay_payment_id)                            
                                    <form action="{{route('mileStonePayment')}}" method="POST" >
                                        @csrf
                                        <input type="hidden" name="milestone_id" value="{{$value->id}}">
                                        <!-- Note that the amount is in paise   -->
                                        <!--amount need to be in paisa-->
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                data-key="{{ Config::get('custom.razor_key') }}"
                                                data-amount="{{$value->amount}}00"
                                                data-buttontext="Pay Milestone"
                                                data-name="{{$value->milestone}}"
                                                data-description="Milestone Value"
                                                >
                                        </script>
                                    </form>
                                @else
                                   <button class="btn btn-success" type="button">Paid</button>
                                @endif
                              @endif
                            </div>
                          @endif
                        </div>
                      @endif
                    @endforeach
                @endif
              @endif
                  
              @if($job->status==0)
                <div>
                  <?php 
                    $check_bid=$chat_start="";

                    if($user){ 
                        $check_bid=$job->bid()->where('user_id',$user->id)->first(); 
                        $chat_start=$job->chat()->where('worker_user_id',$user->id)->first();
                    }     
                  ?>
                 
                  @if(!$job->final_bid && $user->id!=$job->user_id)
                      <h5>How To Apply</h5>
                      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>                    
                      <form @if($user) action="{{route('bidJob',$job->id)}}" @endif method="POST">
                        @csrf
                        <div class="">
                          <h4 class="small-title text-left">Place a Bid on this Project</h4>
                          <p>You will be able to edit your bid until the project is awarded to someone.</p>
                          <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                              <label>Bid Amount</label>
                              <input type="text" name="bid_amount" class="form-control" placeholder="Enter your bid" required="" @if($check_bid) value="{{$check_bid->bid_amount}}" @endif >
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                              <label>This project will be delivered in</label>
                              <input type="number" name="period" class="form-control" placeholder="In days" required="" @if($check_bid) value="{{$check_bid->period}}" @endif>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-xs-12">
                              <label>Describe your proposal</label>
                              <textarea name="description" class="form-control" placeholder="What makes you the best candidate for this project?" rows="7" required="">@if($check_bid) {{$check_bid->description}} @endif</textarea>
                            </div>
                          </div>
                          @if($user)
                            @if($user_bid_packages)
                              @if($user_bid_packages->balance_bids>0)
                                <button type="submit" class="btn btn-common">@if($check_bid) Update Bid @else Place Bid @endif</button>
                              @endif   
                            @else
                              <p>You have exceed your bid limit, to update your bid membership plan. Click on below button.</p>
                              <a href="{{route('package')}}">Update Bid Plan</a>
                            @endif
                          @else                              
                              <a href="{{route('login')}}">Login to bid this project</a>
                          @endif
                        </div>
                      </form>  
                  @endif

                  @if($chat_start)
                    <a href="{{route('chat',[$job->id,$job->user_id,$user->id])}}" class="btn btn-common float-right">Go to Chat</a>
                  @endif

                </div>
              @endif

              @if($user)
                @if($user->id==$job->user_id)
                  <div class="">
                    <h4 class="small-title text-left">Bids of this Project</h4>

                    @forelse($job->bid as $value)
                      <div class="job-listings">
                        <img  @if($value->user->profile_image) src="{{$value->user->profile_image}}" @else src="/assets/img/user-icon.png" @endif   class="img-thumbnail" width='50' />
                        <label><b>User:</b></label> {{$value->user->name}}<br>
                        <label><b>Bid Amount:</b></label> {{$value->bid_amount}}<br>
                        <label><b>Delivery:</b></label> {{$value->period}} in days<br>
                        <label><b>Description:</b></label> {{$value->description}}
                        @if($job->status==0)
                          <a href="{{route('chat',[$job->id,$job->user_id,$value->user_id])}}" class="btn btn-common float-right">Chat</a>
                        @endif
                        @if($job->assigned_to==$value->user_id)
                          <p class="float-right">Worker</p>
                        @endif
                      </div>
                    @empty
                      <p>No Bids Yet</p>
                  @endforelse
                  </div>
                @endif 
              @endif 

              <div>
                <h5>Tags</h5>
                <?php $tags=explode(',', $job->job_tags); ?>
                @foreach($tags as $value)
                  <a href="" class="btn btn-default">{{$value}}</a>
                @endforeach
              </div>

            </div>
          </div>

          <div class="col-lg-4 col-md-12 col-xs-12">
            <div class="sideber">
              <div class="widghet">
                <h3>About the Employer</h3>
                <div class="">
                    <p>{{$job->company_name}}</p>
                    <p>{{$job->location}}</p>
                    <p>{{$job->website}}</p>
                    @if($user)
                      @if($job->assigned_to==$user->id)
                        <br>
                        <a href="{{route('chat',[$job->id,$job->user_id,$job->assigned_to])}}" class="btn btn-common">Chat</a>
                      @endif
                    @endif
                    
                    @if($job->user->email_verified==1)
                      <p><span class="text-success"><b><i class="lni-check-mark-circle"></i></b></span> Email Verified</p>
                    @else
                      <p><span class="text-danger"><b><i class="lni-cross-circle"></i></b></span> Email Not Verified</p>
                    @endif

                    @if($job->user->admin_verified==1)
                      <p><span class="text-success"><b><i class="lni-check-mark-circle"></i></b></span> Admin Verified</p>
                    @else
                      <p><span class="text-danger"><b><i class="lni-cross-circle"></i></b></span> Admin Not Verified</p>
                    @endif
                </div>
              </div>

              @if($user)
                @if($user->id==$job->user_id && $job->status > 0)
                <div class="widghet">
                  <h3>Worker Details</h3>
                  <div class="">
                      <p>Name:{{@$value->assignedTo->name}}</p> 
                      <p>Email: {{@$value->assignedTo->email}} </p>
                      <p>Final Bid: {{$job->final_bid}}</p>
                      <br>
                      <a href="{{route('chat',[$job->id,$job->user_id,$job->assigned_to])}}" class="btn btn-common">Chat</a>
                  </div>
                </div>
                @endif
              @endif
              
            </div>
          </div>
        
        </div>
      </div>
    </section>
    <!-- Job Detail Section End -->  

    
@endsection

@section('scripts')

<script type="text/javascript">
  
    $(document).ready(function() {

      var n=1;
      
      $('#add_mile').click(function(){

          var mile_html='<div class="mile-block" id="mile_block_'+n+'"><hr><div class="form-group"><input type="text" name="milestone[]" id="milestone_'+n+'" class="form-control" placeholder="Milestone"/></div><div class="form-group"><textarea name="description[]" id="description_'+n+'" class="form-control" placeholder="Milestone Description"></textarea></div><div class="form-group"> <button type="button" id="remove_mile_'+n+'" class="btn btn-danger remove_mile" style="float:right;" onclick="removemile('+n+')" alt="Remove Milestone">X</button></div><br></div>';

          $('.mile-section').append(mile_html);
          n+=1;

      });    

    });

    function removemile(n){
        $('#mile_block_'+n).remove();
    }
</script>

@endsection