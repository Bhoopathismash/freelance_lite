<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\JobCategory;
use App\PostJob;
use App\Milestones;

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

    public function jobs()
    {
        $user=Auth::user();
        $jobs=PostJob::whereIn('status',[0,1])->get();
        return view('job.job_list',compact('jobs'));
    }

    public function jobList()
    {
        $user=Auth::user();
        $jobs=PostJob::where('user_id',$user->id)->get();
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
        $job=PostJob::where('id',$id)->with('milestone')->first();
        //dd($job);
        $category=JobCategory::get();
        return view('job.view_post_job',compact('job','category'));
    }

    public function bidJob($id)
    {
        $job=PostJob::where('id',$id)->with('milestone')->first();
        //dd($job);
        $category=JobCategory::get();
        return view('job.view_post_job',compact('job','category'));
    }
    
}
