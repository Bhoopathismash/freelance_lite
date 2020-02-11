<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Bid;
use App\BidPackages;
use App\UserBidPackages;

class RazorpayController extends Controller
{
    public function payPackage($id) {
    	$package=BidPackages::findOrFail($id);
        return view('pay_package',compact('package'));
    }

    public function packagePayment(Request $request) {
        dd("hi",$request);
    }

    public function pay() {
        return view('pay');
    }

    public function dopayment(Request $request) {
        //Input items of form
        $input = $request->all();

        // Please check browser console.
        print_r($input);
        exit;
    }
}
