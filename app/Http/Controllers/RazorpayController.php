<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Razorpay\Api\Api;
use Session;
use Redirect;

use Auth;
use App\User;
use App\Bid;
use App\BidPackages;
use App\UserBidPackages;
use App\Milestones;

class RazorpayController extends Controller
{
    public function payPackage($id) {
    	$package=BidPackages::findOrFail($id);
        return view('pay_package',compact('package'));
    }

    public function packagePayment(Request $request) {
        dd("hi",$request);
    }   

    public function mileStonePayment()
    {
        try{
            $input = Input::all();
            $razorpay_payment_id=$input['razorpay_payment_id'];
            $milestone_id=$input['milestone_id'];

            if(count($input)  && !empty($razorpay_payment_id)) {
                try {
                    //get API Configuration 
                    $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));
                    //Fetch payment information by razorpay_payment_id
                    $payment = $api->payment->fetch($razorpay_payment_id);
                    //$response = $api->payment->fetch($razorpay_payment_id)->capture(array('amount'=>$payment['amount'])); 
                } catch (\Exception $e) {
                    //return  $e->getMessage();                
                    return back()->with('flash_error',$e->getMessage());
                }

                $milestone=Milestones::findOrFail($milestone_id); 
                $milestone->razorpay_payment_id=$razorpay_payment_id;
                $milestone->razorpay_payment_status="authorized";
                $milestone->save();

                return back()->with('flash_success','Milestone paid successfully');

            }else{
                return back()->with('flash_error','Something went wrong');
            }
        }catch (\Exception $e) {
            return back()->with('flash_error',$e->getMessage());
        }
    }
}
