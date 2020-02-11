    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="">
    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/line-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">    
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/override.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/summernote.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css"> 
      .chat-list{
        display: inline-block;
        width: 100%;
        height: 55vh;
        overflow-y: auto;
        border: 1px solid #eee;
        border-radius: 3px;
      }
      .chat-content{ width:90%; float: left; }
      .chat-block{
        margin: 15px;
        padding: 8px 15px;
        border: 1px solid #eee;
        clear: both;
        display: inline-block;
        position: relative;
      }
      .left-chat{  background-color: #F2F3F5;  color: #000;  border-radius: 0px 14px 14px 14px;  }
      .left-chat .chat-time{  color: #666;  } 
      .right-chat{  background-color: #3A87F1;  color: #F2F7FE; border-radius: 14px 0px 14px 14px; }  
      .right-chat .chat-time{  color: #efefef;  } 
      .chat-time{ font-size: 8px; color: #666; padding-left: 12px;  }
      .chat-send{ padding-left: 10px;  }
      .chat-send img{ width: 6%; }
      .online-status-online { color: #afa !important; }
      .online-status {
          display: inline-block;
          vertical-align: super;
          font-size: 70%;
          text-shadow: 0 0 1px rgba(66, 66, 66, 0.5);
          margin: 6px 10px 10px;
      }
      .online-status-recent { color: #dd8 !important; }
      .online-status-offline { color: #ccc !important; }
      .user-alert .alert{position: fixed; z-index: 999; bottom: 1%;width: 35%;left: 35%;}
    </style>
    
    <?php $pageurl = basename($_SERVER['PHP_SELF']);  ?>