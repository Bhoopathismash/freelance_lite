@extends('layouts.base')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>Pay</h3>
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
          <div class="col-lg-9 col-md-12 col-xs-12">
            <div class="post-job box">
              	<h3 class="job-title">Pay</h3>
        		<form id="rzp-footer-form" action="{{route('dopayment')}}" method="POST" style="width: 100%; text-align: center" >
                @csrf

                <p>Sample</p>   
                <br/>
                <p><br/>Price: 2,475 INR </p>
                <input type="hidden" name="amount" id="amount" value="2475"/>
                <div class="pay">
                    <button class="razorpay-payment-button btn filled small btn-common" id="paybtn" type="button">Pay with Razorpay</button>                        
                </div>
            </form>
            <br/><br/>
            <div id="paymentDetail" style="display: none">
                <center>
                    <div>paymentID: <span id="paymentID"></span></div>
                    <div>paymentDate: <span id="paymentDate"></span></div>
                </center>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Content section End -->   
@endsection

@section('scripts')
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <!-- Include whatever JQuery which you are using -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Other js and css scripts -->
	<script>
	    $('#rzp-footer-form').submit(function (e) {
	        var button = $(this).find('button');
	        var parent = $(this);
	        button.attr('disabled', 'true').html('Please Wait...');
	        $.ajax({
	            method: 'get',
	            url: this.action,
	            data: $(this).serialize(),
	            complete: function (r) {
	                console.log('complete');
	                console.log(r);
	            }
	        })
	        return false;
	    })
	</script>

	<script>
	    function padStart(str) {
	        return ('0' + str).slice(-2)
	    }

	    function demoSuccessHandler(transaction) {
	        // You can write success code here. If you want to store some data in database.
	        $("#paymentDetail").removeAttr('style');
	        $('#paymentID').text(transaction.razorpay_payment_id);
	        var paymentDate = new Date();
	        $('#paymentDate').text(
	                padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
	                );

	        $.ajax({
	            method: 'post',
	            url: "{!!route('dopayment')!!}",
	            data: {
	                "_token": "{{ csrf_token() }}",
	                "razorpay_payment_id": transaction.razorpay_payment_id
	            },
	            complete: function (r) {
	                console.log('complete');
	                console.log(r);
	            }
	        })
	    }
	</script>
	<script>
	    var options = {
	        key: "{{ env('RAZORPAY_KEY') }}",
	        amount: '247500',
	        name: 'CodesCompanion',
	        description: 'TVS Keyboard',
	        image: 'https://i.imgur.com/n5tjHFD.png',
	        handler: demoSuccessHandler
	    }
	</script>
	<script>
	    window.r = new Razorpay(options);
	    document.getElementById('paybtn').onclick = function () {
	        r.open()
	    }
	</script>

@endsection