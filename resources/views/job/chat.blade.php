@extends('layouts.base')

@section('content')

<style type="text/css">
  .chat-list{
    height: 90%;
    border: 1px solid #eee;
    border-radius: 3px; 
  }
  .chat-content{
    width:90%;float: left;
  }
  .chat-block{
    margin: 5px;
    padding: 5px;
    border: 1px solid #eee;
    border-radius: 2px; 
  }
</style>

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
              
              <div class="chat-section">
                <div class="chat-list">
                  @foreach($chat as $value)
                    <div class="chat-block @if($value->hirer_user_id==$user->id) float-right  @elseif($value->worker_user_id==$user->id) float-right @else float-left @endif">
                      {{$value->content}}
                    </div>
                  @endforeach
                </div>
                
                <br>
                <div class="form-group chat-type clearfix">
                    <textarea rows="1" name="chat_content" id="chat_content" class="form-control chat-content"></textarea>
                    <button type="button" class="chat-send" id="chat_send"><img src="{{asset('assets/img.chat-send.png')}}" width="20" /></button>
                </div>

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

      setInterval(refreshChat,2000);

      $('#chat_content').keypress(function(event){
  
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          sendChat();
        }

      });

      $('#chat_send').click(function(){
        sendChat();
      });    

    

      function sendChat(){
        
          var html_content="";
          var post_id=<?=$job->id?>;
          var chat_content=$('#chat_content').val();

          $.ajax({
                url: "{{route('chatSend')}}",
                type: "POST",
                data:{'post_id':post_id,'chat_content':chat_content,'_token': '{{ csrf_token() }}'}
          }).done(function(response){
              if(response.status==1){
                  html_content='<div class="chat-block float-right">'+chat_content+'</div>';                              
                  $('.chat-list').append(html_content);
                  $('#chat_content').val('');
              }else{
              }              

          }).fail(function(jqXhr,status){

          });
      }

    });

    function refreshChat(){
      var post_id=<?=$job->id?>;
         $.ajax({
                url: "{{route('refreshChat')}}",
                type: "GET",
                data:{'post_id':post_id,'_token': '{{ csrf_token() }}'}
          }).done(function(response){
              if(response.status==1){
                  //$('.chat-list').empty();
                  $('.chat-list').empty().html(response.refresh_content);
              }else{
              }              

          }).fail(function(jqXhr,status){

          });
    }
</script>

@endsection