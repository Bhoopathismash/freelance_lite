<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\UserBidPackages;

class StaticController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }  

    public function index()
    {
        if(Auth::check()){
            $user=Auth::user();
            $user_id=$user->id;
            if($user->user_type==2){ //Work
                $user_bid_packages=UserBidPackages::where('user_id',$user_id)->where('status',1)->where('balance_bids','>',0)->first();                
                if(!$user_bid_packages){
                    return redirect('/package')->with('flash_error','Your biding limit are over, Kindly update your package for further biding...');
                }
            }
        }
        return view('welcome');
    }

    public function about()
    {
        return view('about');
    }

    public function faq()
    {
        return view('faq');
    }

    public function contact()
    {
        return view('contact');
    }

    
}
