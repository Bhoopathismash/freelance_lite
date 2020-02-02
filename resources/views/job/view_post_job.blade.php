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

              @if($user->user_type==2)
                <div>
                  <?php $check_bid=$job->bid()->where('user_id',$user->id)->first(); 
                        $chat_start=$job->chat()->where('worker_user_id',$user->id)->first(); ?>
                 
                  @if(!$job->final_bid)
                      <h5>How To Apply</h5>
                      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>
                  
                      <form action="{{route('bidJob',$job->id)}}" method="POST">
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
                          <button type="submit" class="btn btn-common">@if($check_bid) Update Bid @else Place Bid @endif</button> 
                        </div>
                      </form>                    
                  @endif

                  @if($chat_start)
                    <a href="{{route('chat',[$job->id,$job->user_id,$user->id])}}" class="btn btn-info float-right">Go to Chat</a>
                  @endif

                </div>
              @elseif(Auth::user()->user_type==1)
                <div class="">
                  <h4 class="small-title text-left">Bids of this Project</h4>

                  @foreach($job->bid as $value)
                    <div class="job-listings">
                      <label><b>User:</b></label> {{$value->user->name}}<br>
                      <label><b>Bid Amount:</b></label> {{$value->bid_amount}}<br>
                      <label><b>Delivery:</b></label> {{$value->period}} in days<br>
                      <label><b>Description:</b></label> {{$value->description}}
                      <a href="{{route('chat',[$job->id,$job->user_id,$value->user_id])}}" class="btn btn-info float-right">Chat</a>
                    </div>
                  @endforeach
                </div>
              @endif

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
                </div>
              </div>
              
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