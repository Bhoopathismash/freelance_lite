@extends('layouts.base')

@section('content')

<style type="text/css"> 
  .chat-list{
    display: inline-block;
    width: 100%;
    height: 55vh;
    overflow-y: auto;
    border: 1px solid #eee;
    border-radius: 3px;
    /*background-image: url("/assets/img/chat-background.jpg"); */
  }
  .chat-content{ width:90%; float: left; }
  .chat-block{
    margin: 15px;
    padding: 8px 15px;
    border: 1px solid #eee;
    border-radius: 6px; 
    clear: both;
    display: inline-block;
    position: relative;
  }

  .left-chat{  background-color: #F2F3F5;  color: #000;  }
  .left-chat .chat-time{  color: #666;  }  
  .triangle.left-top:after {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
    left: -6px;
    right: auto;
    top: 0px;
    bottom: auto;
    border: 6px solid;
    border-color: #F2F3F5 transparent transparent transparent;
  }

  .right-chat{  background-color: #3A87F1;  color: #F2F7FE;  }  
  .right-chat .chat-time{  color: #efefef;  }  
  .triangle.right-top:before {
      content: ' ';
      position: absolute;
      width: 0;
      height: 0;
      left: auto;
      right: -6px;
      top: 0;
      bottom: auto;
      border: 6px solid;
      border-color: #3A87F1 transparent transparent transparent;
  }

  .chat-time{ font-size: 8px; color: #666; padding-left: 12px;  }
  .chat-send{ padding-left: 10px;  }
  .chat-send img{ width: 6%; }


  .online-status-online {
    color: #afa !important;
  }

  .online-status {
      display: inline-block;
      vertical-align: super;
      font-size: 70%;
      text-shadow: 0 0 1px rgba(66, 66, 66, 0.5);
      margin: 6px 10px 10px;
  }

  .online-status-recent {
      color: #dd8 !important;
  }

  .online-status-offline {
      color: #ccc !important;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-8 col-md-6 col-xs-12">
            <div class="breadcrumb-wrapper">              
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
              <h4>Job Discussion</h4> 
              <div>
                <p class="text-capitalize float-left">
                  <?php $opponent_id=0; ?>
                  @if($job->user_id==$user->id) 
                    {{$worker->name}} 
                    <?php $opponent_id=$worker->id; ?>
                  @else 
                    {{$hirer->name}} 
                    <?php $opponent_id=$hirer->id; ?>
                  @endif
                </p>
                <span id="user_status_light" class="online-status"><i class="fa fa-circle"></i></span>
              </div>             
              <div class="chat-section">
                <div class="chat-list">
                  @foreach($chat as $value)
                    <div class="chat-block @if($value->hirer_user_id==$user->id || $value->worker_user_id==$user->id) float-right right-chat triangle right-top @else float-left left-chat triangle left-top @endif">
                      {{$value->content}}
                      <span class="chat-time">{{date('h:i A',strtotime($value->created_at))}}</span>
                    </div>
                  @endforeach
                </div>                
                <br>
                <div class="form-group chat-type clearfix">
                    <textarea rows="1" name="chat_content" id="chat_content" class="form-control chat-content" placeholder="Type a message"></textarea>
                    <a href="javascript:void(0)" class="chat-send" id="chat_send"><img src="/assets/img/chat-send.png"/></a>
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
    $( window ).load(function() {
      chatScroll();
    });

    $(document).ready(function() {

      /*$('.chat-list').animate({
        scrollTop: $('.chat-list').get(0).scrollHeight
      }, 1000);*/

      setInterval(refreshChat,2000);
      setInterval(myfuncuseractive,5000);

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
      var hirer_id=<?=$job->user_id?>;
      var worker_id=<?=$worker->id?>;
         $.ajax({
                url: "{{route('refreshChat')}}",
                type: "GET",
                data:{'post_id':post_id,'hirer_id':hirer_id,'worker_id':worker_id,'_token': '{{ csrf_token() }}'}
          }).done(function(response){
              if(response.status==1){
                  //$('.chat-list').empty();
                  $('.chat-list').empty().html(response.refresh_content);
                  chatScroll();
              }else{
              }              

          }).fail(function(jqXhr,status){

          });
    }

    function chatScroll(){
      $('.chat-list').animate({
        scrollTop: $('.chat-list').get(0).scrollHeight
      }, 1);
    }

    function myfuncuseractive(){
                
        $.ajax({
            type: "GET",
            url : "{{url('/user_log_status')}}/"+<?=$opponent_id?>,            
            success: function(data)
            {                
                //console.log(data);
                if(data==1){
                    $('#user_status_light').addClass('online-status-online');
                    $('#user_status_light').removeClass('online-status-offline');  
                }else{
                    $('#user_status_light').addClass('online-status-offline');
                    $('#user_status_light').removeClass('online-status-online');
                }  
            }
        });  
        
    }
</script>

@endsection