<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\JobCategory;
use App\PostJob;
use App\PostFiles;
use App\Milestones;
use App\Bid;
use App\BidPackages;
use App\UserBidPackages;
use App\Chat;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user=Auth::user();
        $user_id=$user->id;        

        $user_bid_packages=UserBidPackages::where('user_id',$user_id)->where('status',1)->where('balance_bids','>',0)->first();

        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['user' => $user, 'user_bid_packages' => $user_bid_packages] ], 200);
        }else{    
            if(!$user_bid_packages){
                return redirect('/package')->with('flash_error','Your biding limit are over, Kindly update your package for further biding...');
            }
            return view('dashboard');
        }
    }

    public function package(Request $request)
    {
        $user=Auth::user();
        $bid_packages=BidPackages::orderBy('sort','asc')->get();
        $user_bid_packages=UserBidPackages::where('user_id',$user->id)->where('status',1)->where('balance_bids','>',0)->first();
        //dd($user_bid_packages);

        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['user' => $user, 'bid_packages' => $bid_packages, 'user_bid_packages' => $user_bid_packages] ], 200);
                
        }else{
            return view('packages',compact('user','bid_packages','user_bid_packages'));
        }
    }

    public function userPackage($id, Request $request)
    {
        $user=Auth::user();
        $bid_packages=BidPackages::get();
        //dd($bid_packages);
        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['user' => $user, 'bid_packages' => $bid_packages] ], 200);
        }else{    
            return view('packages',compact('user','bid_packages'));
        }
    }

    public function profile(Request $request)
    {
        $user=Auth::user();
        $user_bid_packages=UserBidPackages::where('user_id',$user->id)->where('status',1)->with('bidPackage')->first();
        //dd($user_bid_packages);
        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['user' => $user, 'user_bid_packages' => $user_bid_packages] ], 200);
        }else{ 
            return view('profile',compact('user','user_bid_packages'));
        }
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'profile_image' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try{

            $user=Auth::user();        
            $user->name=$request->name;
            $user->description=$request->description;
            if($request->hasFile('profile_image')) {
                $user->profile_image = 'storage/'.$request->profile_image->store('profile_image');
            }
            $user->save();

            if($request->ajax()) {
                return response()->json(['status' => true, 'data' => ['msg' => 'Profile updated successfully'] ], 200);
            }else{ 
                return back()->with('flash_success','Profile updated successfully');
            }

        }catch(Exception $e){
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error','Something went wrong');
            }
        }
    }

    //Change Password
    public function update_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'current_password' => 'required',
        ]);

        $User = Auth::user();

        if(Hash::check($request->current_password, $User->password))
        {
            if($request->current_password!=$request->password){
                $User->password = bcrypt($request->password);
                $User->save();
                
                if($request->ajax()) {
                    return response()->json(['status' => true, 'data' => ['msg' => trans('user.profiles.pass_updated')] ], 200);
                }else{ 
                     return back()->with('flash_success',trans('user.profiles.pass_updated'));
                }

            } else {
                if($request->ajax()) {
                    return response()->json(['status' => false, 'data' => ['msg' => trans('user.profiles.same')] ]);
                }else{ 
                    return back()->with('flash_error', trans('user.profiles.same'));
                }
            }

        } else {
            if($request->ajax()) {
                return response()->json(['status' => false, 'data' => ['msg' => trans('user.profiles.current_wrong_pwd')] ]);
            }else{ 
                return back()->with('flash_error', trans('user.profiles.current_wrong_pwd'));
            }
        }
    }    

    public function jobList(Request $request)
    {
        $user=Auth::user();
        $category=JobCategory::where('status',1)->get();
        $jobs=PostJob::where('user_id',$user->id);

        $keyword=$request->keyword;
        $location=$request->location;
        $category_id=$request->category_id;
        if($category_id){
            $jobs=$jobs->where('category_id',$category_id);
        }
        if($keyword){
            $jobs=$jobs->where('job_title','LIKE', "%{$keyword}%")->orWhere('company_name','LIKE', "%{$keyword}%");
        }
        if($location){
            $jobs=$jobs->where('location','LIKE', "%{$location}%");
        }
        $jobs=$jobs->orderBy('created_at', 'DESC')->paginate(15);
        
        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['jobs' => $jobs, 'category' => $category] ], 200);
        }else{
            return view('job.job_list',compact('jobs','category'));
        }
    }

    public function myJobs(Request $request){
        $user=Auth::user();
        $category=JobCategory::where('status',1)->get();
        $jobs=PostJob::where('assigned_to',$user->id);
        
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
        
        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['jobs' => $jobs, 'category' => $category] ], 200);
        }else{
            return view('job.job_list',compact('jobs','category'));
        }    
    }

    public function postJob(Request $request)
    {
        $category=JobCategory::where('status',1)->get();

        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['category' => $category] ], 200);
        }else{
            return view('job.post_job',compact('category'));
        }    
    }

    public function postJobStore(Request $request)
    {
        //dd($request);
        $this->validate($request, [            
            'job_title' => 'required',
            'category_id' => 'required',            
            'job_description' => 'required',            
            'job_file.*' => 'mimes:pdf,docx,doc,png,jpg,jpeg',            
        ]);

        try{

            $user=Auth::user();
            $user_id=$user->id;

            $job=new PostJob;
            $job->user_id=$user_id;
            $job->job_title=$request->job_title;
            $job->category_id=$request->category_id;
            $job->budget=$request->budget;
            $job->job_tags=$request->job_tags;
            $job->description=$request->job_description;            
            $job->closing_date=date('Y-m-d',strtotime($request->closing_date));
            $job->company_name=$request->company_name;
            $job->location=$request->location;
            $job->email=$request->email;
            $job->website=$request->website;
            $job->tagline=$request->tagline;
            $job->status=0;
            $job->save();

            foreach ($request->job_file as $key => $value) {
                $job_image=new PostFiles;
                $job_image->post_job_id = $job->id;
                $job_image->document = 'storage/'.$value->store('job_file');
                $job_image->save();
            }

            foreach ($request->milestone as $key => $value) {
                $milestone=new Milestones;
                $milestone->post_job_id=$job->id;
                $milestone->milestone=$value;
                $milestone->description=$request->description[$key];
                $milestone->save();
            }

            if($request->ajax()) {
                return response()->json(['status' => false, 'data' => ['msg' => "Job posted successfully"] ], 200);
            }else{ 
                return back()->with('flash_success','Job posted successfully');
            }
        }catch(Exception $e){
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    public function editPost($id, Request $request)
    {
        $job=PostJob::where('id',$id)->with('jobFiles')->with('milestone')->first();
        //dd($job);
        $category=JobCategory::get();

        if($request->ajax()) {
            return response()->json(['status' => true, 'data' => ['jobs' => $jobs, 'category' => $category] ], 200);
        }else{            
            return view('job.edit_post_job',compact('job','category'));
        }
    }

    public function postJobUpdate(Request $request,$id)
    {
        $this->validate($request, [            
            'job_title' => 'required',
            'category_id' => 'required',            
            'job_description' => 'required',            
            'job_file.*' => 'mimes:pdf,docx,doc,png,jpg,jpeg',            
        ]);

        try{

            $user=Auth::user();
            $user_id=$user->id;

            $job=PostJob::findOrFail($id);
            $job->user_id=$user_id;
            $job->job_title=$request->job_title;
            $job->category_id=$request->category_id;
            $job->job_tags=$request->job_tags;
            $job->description=$request->job_description;
            if($request->hasFile('job_file')) {
                $job->job_file = 'storage/'.$request->job_file->store('job_file');
            }
            $job->closing_date=date('Y-m-d',strtotime($request->closing_date));
            $job->company_name=$request->company_name;
            $job->location=$request->location;
            $job->email=$request->email;
            $job->website=$request->website;
            $job->tagline=$request->tagline;
            $job->status=0;
            $job->save();

            foreach ($request->job_file as $key => $value) {
                $job_image=new PostFiles;
                $job_image->post_job_id = $job->id;
                $job_image->document = 'storage/'.$value->store('job_file');
                $job_image->save();
            }

            Milestones::where('post_job_id',$id)->delete();

            foreach ($request->milestone as $key => $value) {
                $milestone=new Milestones;
                $milestone->post_job_id=$id;
                $milestone->milestone=$value;
                $milestone->description=$request->description[$key];
                $milestone->save();
            }
            if($request->ajax()) {
                return response()->json(['status' => true, 'data' => ['msg' => 'Job posted successfully']], 200);
            }else{
                return back()->with('flash_success','Job posted successfully');
            }    

        }catch(Exception $e){
            return back()->with('flash_error','Something went wrong');
        }
    }

    
    
    public function bidJob(Request $request, $post_id)
    {
        $this->validate($request, [            
            'bid_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'period' => 'required|numeric',            
            'description' => 'required',            
        ]);

        try{
            $user=Auth::user();
            $user_id=$user->id;

            $user_bid_packages=UserBidPackages::where('user_id',$user_id)->where('status',1)->where('balance_bids','>',0)->first();

            if(!$user_bid_packages){
                return redirect('/package')->with('flash_error','Your biding limit are over, Kindly update your package for further biding...');
            }

            $bid=new Bid;
            $bid->user_id=$user_id;
            $bid->post_job_id=$post_id;
            $bid->bid_amount=$request->bid_amount;
            $bid->period=$request->period;
            $bid->description=$request->description;
            $bid->status=0;
            $bid->save();


            if($request->ajax()) {
                return response()->json(['status' => true, 'data' => ['msg' => 'Your bid placed successfully']], 200);
            }else{            
                return back()->with('flash_success','Your bid placed successfully');
            }    

        }catch(Exception $e){

            return back()->with('flash_error','Something went wrong');
        }
    } 

    public function assignJob(Request $request)
    {
        $this->validate($request, [            
            'post_id' => 'required|numeric',            
            'worker_id' => 'required|numeric',            
        ]);

        try{

            $user=Auth::user();
            $user_id=$user->id;

            $job=PostJob::findOrFail($request->post_id);
            if($user->id==$job->user_id){
                $job->assigned_to=$request->worker_id;
                $job->status=1;
                $job->save();
                
                if($request->ajax()) {
                    return response()->json(['status' => true, 'data' => ['msg' => 'Job assigned successfully']], 200);
                }else{  
                    return back()->with('flash_success','Job assigned successfully');
                }

            }else{
                if($request->ajax()) {
                    return response()->json(['status' => true, 'data' => ['msg' => 'Your are not allowed to do this operation']]);
                }else{  
                    return back()->with('flash_error','Your are not allowed to do this operation');
                }
            }

        }catch(Exception $e){
            if($request->ajax()) {
                return response()->json(['status' => true, 'data' => ['msg' => 'Something went wrong']], 500);
            }else{  
                return back()->with('flash_error','Something went wrong');
            }    
        }
    }

    public function releaseMilestone($id, Request $request)
    {
        try{

            $user=Auth::user();
            $user_id=$user->id;

            $milestone=Milestones::findOrFail($id);
            $job=PostJob::findOrFail($milestone->post_job_id);
            if($user->id==$job->user_id){
                $milestone->release_status=1;
                $milestone->save();
                
                if($request->ajax()) {
                    return response()->json(['status' => true, 'data' => ['msg' => 'Milestone released successfully']], 200);
                }else{ 
                    return back()->with('flash_success','Milestone released successfully');
                }
            }else{
                if($request->ajax()) {
                    return response()->json(['status' => true, 'data' => ['msg' => 'Your are not allowed to do this operation']]);
                }else{ 
                    return back()->with('flash_error','Your are not allowed to do this operation');
                }
            }

        }catch(Exception $e){
            if($request->ajax()) {
                return response()->json(['status' => true, 'data' => ['msg' => 'Something went wrong']], 500);
            }else{ 
                return back()->with('flash_error','Something went wrong');
            }
        }
    }

    public function milestonePay(Request $request)
    {
        $this->validate($request, [            
            'post_id' => 'required|numeric',            
            'worker_id' => 'required|numeric',            
        ]);

        try{

            $user=Auth::user();
            $user_id=$user->id;

            $job=PostJob::findOrFail($request->post_id);
            if($user->id==$job->user_id){
                $job->assigned_to=$request->worker_id;
                $job->status=1;
                $job->save();
                if($request->ajax()) {
                    return response()->json(['status' => true, 'data' => ['msg' => 'Job assigned successfully']], 200);
                }else{ 
                    return back()->with('flash_success','Job assigned successfully');
                }
            }else{
                if($request->ajax()) {
                    return response()->json(['status' => false, 'data' => ['msg' => 'Your are not allowed to do this operation']], 200);
                }else{ 
                    return back()->with('flash_error','Your are not allowed to do this operation');
                }
            }

        }catch(Exception $e){
            if($request->ajax()) {
                return response()->json(['status' => false, 'data' => ['msg' => 'Something went wrong']], 500);
            }else{ 
                return back()->with('flash_error','Something went wrong');
            }
        }
    }

    public function chat($post_id, $hirer_id, $worker_id)
    {
        $user=Auth::user();
        $hirer=User::findOrFail($hirer_id);
        $worker=User::findOrFail($worker_id);
        $chat=Chat::where('post_job_id',$post_id)->where(function($query) use($hirer_id, $worker_id){
                    $query->where('hirer_user_id',$hirer_id)->orWhere('worker_user_id',$worker_id);
                })->get();
        
        $job=PostJob::where('id',$post_id)->with('milestone')->with('bid')->first(); 

        return view('job.chat',compact('user','job','chat','hirer','worker'));
    }
    
    public function chatSend(Request $request)
    {
        try{
            $user=Auth::user();
            $post_id=$request->post_id;
            $job=PostJob::findOrFail($post_id);

            $chat=new Chat; 
            $chat->post_job_id=$post_id;
            $chat->status=0;
            if($job->user_id==$user->id){
                $chat->hirer_user_id=$user->id; 
            }else{            
                $chat->worker_user_id=$user->id; 
            }        
            $chat->content=trim($request->chat_content); 
            $chat->save();

            return response()->json(['status'=>1],200);
        }catch(Exception $e){
            return response()->json(['status'=>0],500);
        }

    }

    public function refreshChat(Request $request)
    {
        try{
            $html=$align="";
            $user=Auth::user();
            $post_id=$request->post_id;
            $hirer_id=$request->hirer_id;
            $worker_id=$request->worker_id;
            
            $chat=Chat::where('post_job_id',$post_id)->where(function($query) use($hirer_id, $worker_id){
                    $query->where('hirer_user_id',$hirer_id)->orWhere('worker_user_id',$worker_id);
                })->get();
        
            foreach ($chat as $key => $value) {

                if($value->hirer_user_id==$user->id || $value->worker_user_id==$user->id){ 
                    $align="float-right right-chat";
                }else{ 
                    $align="float-left left-chat";
                }

                $html.='<div class="chat-block '.$align.'">'.$value->content.'<span class="chat-time">'.date('h:i A',strtotime($value->created_at)).'</span></div>';
            }

            return response()->json(['status'=>1,'refresh_content'=>$html],200);
        }catch(Exception $e){
            return response()->json(['status'=>0],500);
        }
    }

    // Check User Online/Offline Staus
    public function userLogStatus($id)
    {
        $user=User::findOrFail($id);
        if($user->isOnline()){
            return 1;
        }else{

            return 0;
        }
    }

    public function updateBidPackage()
    {
        try{
            $user=Auth::user();
            

            return response()->json(['status'=>1],200);
        }catch(Exception $e){
            return response()->json(['status'=>0],500);
        }

    }

    public function logout()
    {
       Auth::logout();
        return redirect('/');
    }
    
}
