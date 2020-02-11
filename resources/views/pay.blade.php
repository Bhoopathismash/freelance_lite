@extends('layouts.base')

@section('content')
	<style type="text/css">
		
	</style>
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
	        <div class="col-md-4 col-md-offset-4">
	          
	            <div class="panel panel-default">
	                <div class="panel-heading">Pay With Razorpay</div>

	                <div class="panel-body text-center">
	                    <form action="{!!route('payment')!!}" method="POST" >
	                    	@csrf
	                        <!-- Note that the amount is in paise = 50 INR -->
	                        <!--amount need to be in paisa-->
	                        <script src="https://checkout.razorpay.com/v1/checkout.js"
	                                data-key="{{ Config::get('custom.razor_key') }}"
	                                data-amount="1000"
	                                data-buttontext="Pay 10 INR"
	                                data-name="Laravelcode"
	                                data-description="Order Value"
	                                >
	                        </script>
	                        <button class="btn btn-common" type="button"></button>
	                    </form>
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