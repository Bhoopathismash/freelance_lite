<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\JobCategory;
use App\PostJob;
use App\Milestones;
use App\Bid;
use App\BidPackages;
use App\UserBidPackages;
use App\Chat;

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
            $user_bid_packages=UserBidPackages::where('user_id',$user_id)->where('status',1)->where('balance_bids','>',0)->first();                
            if(!$user_bid_packages){
                return redirect('/package')->with('flash_error','Your biding limit are over, Kindly update your package for further biding...');
            }
        }

        $category=JobCategory::where('status',1)->get();
        return view('welcome', compact('category'));
    }

    public function jobs(Request $request)
    {
        $user=Auth::user();
        $category=JobCategory::where('status',1)->get();
        $jobs=PostJob::whereIn('status',[0,1]);
        $category_id=$request->category_id;
        $keyword=$request->keyword;
        $location=$request->location;
        if($category_id){
            $jobs=$jobs->where('category_id',$category_id);
        }
        if($keyword){
            $jobs=$jobs->where('job_title','LIKE', "%{$keyword}%")->orWhere('company_name','LIKE', "%{$keyword}%");
        }
        if($location){
            $jobs=$jobs->where('location','LIKE', "%{$location}%");
        }
        $jobs=$jobs->orderBy('created_at', 'DESC')->paginate(10);

        return view('job.job_list',compact('jobs','category'));
    }

    public function viewPost($id)
    {
        $user=Auth::user();
        
        $job=PostJob::where('id',$id)->with('milestone')->with('bid')->first();
        //dd($job);

        
        $category=JobCategory::get();

        $user_bid_packages=UserBidPackages::where('status',1);
        if($user){
            $user_bid_packages=$user_bid_packages->where('user_id',$user->id);
        }
        $user_bid_packages=$user_bid_packages->first();

        return view('job.view_post_job',compact('user','job','category','user_bid_packages'));
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
