<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\JobCategory;
use App\PostJob;
use App\Milestones;
use App\Bid;
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
    public function index()
    {
        $user=Auth::user();

        if($user->user_type==1){ //Hire

           return view('hire_dashboard');
        }else{ //Work
            return view('work_dashboard');
        }
    }

    public function profile()
    {
        $user=Auth::user();
        return view('profile',compact('user'));
    }

    public function jobs(Request $request)
    {
        $user=Auth::user();
        $jobs=PostJob::whereIn('status',[0,1]);

        $keyword=$request->keyword;
        $location=$request->location;
        if($keyword){
            $jobs=$jobs->where('job_title','LIKE', "%{$keyword}%")->orWhere('company_name','LIKE', "%{$keyword}%");
        }
        if($location){
            $jobs=$jobs->where('location','LIKE', "%{$location}%");
        }
        $jobs=$jobs->orderBy('created_at', 'DESC')->paginate(10);

        return view('job.job_list',compact('jobs'));
    }

    public function jobList(Request $request)
    {
        $user=Auth::user();

        $jobs=PostJob::where('user_id',$user->id);

        $keyword=$request->keyword;
        $location=$request->location;
        if($keyword){
            $jobs=$jobs->where('job_title','LIKE', "%{$keyword}%")->orWhere('company_name','LIKE', "%{$keyword}%");
        }
        if($location){
            $jobs=$jobs->where('location','LIKE', "%{$location}%");
        }
        $jobs=$jobs->orderBy('created_at', 'DESC')->paginate(10);
        
        return view('job.job_list',compact('jobs'));
    }

    public function postJob()
    {
        $category=JobCategory::where('status',1)->get();
        return view('job.post_job',compact('category'));
    }

    public function postJobStore(Request $request)
    {
        //dd($request);
        $this->validate($request, [            
            'job_title' => 'required',
            'category_id' => 'required',            
            'job_description' => 'required',            
            'job_file' => 'mimes:pdf,docx,doc,png,jpg,jpeg',            
        ]);

        try{

            $user=Auth::user();
            $user_id=$user->id;

            $job=new PostJob;
            $job->user_id=$user_id;
            $job->job_title=$request->job_title;
            $job->category_id=$request->category_id;
            $job->job_tags=$request->job_tags;
            $job->description=$request->job_description;
            if($request->hasFile('job_file')) {
                $job->job_file = 'storage/'.$request->job_file->store('job_file');
            }
            $job->closing_date=date('Y-m-d',strtotime($request->company_name));
            $job->company_name=$request->company_name;
            $job->location=$request->location;
            $job->email=$request->email;
            $job->website=$request->website;
            $job->tagline=$request->tagline;
            $job->status=0;
            $job->save();

            foreach ($request->milestone as $key => $value) {
                $milestone=new Milestones;
                $milestone->post_job_id=$job->id;
                $milestone->milestone=$value;
                $milestone->description=$request->description[$key];
                $milestone->save();
            }

            return back()->with('flash_success','Job posted successfully');

        }catch(Exception $e){

            return back()->with('flash_error','Something went wrong');
        }
    }



    public function editPost($id)
    {
        $job=PostJob::where('id',$id)->with('milestone')->first();
        //dd($job);
        $category=JobCategory::get();
        return view('job.edit_post_job',compact('job','category'));
    }

    public function postJobUpdate(Request $request,$id)
    {
        $this->validate($request, [            
            'job_title' => 'required',
            'category_id' => 'required',            
            'job_description' => 'required',            
            'job_file' => 'mimes:pdf,docx,doc,png,jpg,jpeg',            
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

            Milestones::where('post_job_id',$id)->delete();

            foreach ($request->milestone as $key => $value) {
                $milestone=new Milestones;
                $milestone->post_job_id=$id;
                $milestone->milestone=$value;
                $milestone->description=$request->description[$key];
                $milestone->save();
            }

            return back()->with('flash_success','Job posted successfully');

        }catch(Exception $e){
            return back()->with('flash_error','Something went wrong');
        }
    }

    public function viewPost($id)
    {
        $user=Auth::user();
        
        $job=PostJob::where('id',$id)->with('milestone')->with('bid')->first();

        if(($user->user_type==1) && ($job->user_id != $user->id)){
           return back()->with('flash_error','You are not allowed to perform this operation');
        }

        //dd($job);
        $category=JobCategory::get();
        return view('job.view_post_job',compact('user','job','category'));
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

            $bid=new Bid;
            $bid->user_id=$user_id;
            $bid->post_job_id=$post_id;
            $bid->bid_amount=$request->bid_amount;
            $bid->period=$request->period;
            $bid->description=$request->description;
            $bid->status=0;
            $bid->save();
            
            return back()->with('flash_success','Your bid placed successfully');

        }catch(Exception $e){

            return back()->with('flash_error','Something went wrong');
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
                    $align="float-right right-chat triangle right-top";
                }else{ 
                    $align="float-left left-chat triangle left-top";
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

    public function logout()
    {
       Auth::logout();
        return redirect('/');
    }
    
}
