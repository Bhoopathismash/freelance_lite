<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\JobCategory;
use App\PostJob;

class AdminController extends Controller
{
    public function index(){
    	$users[] = Auth::user();
	    $users[] = Auth::guard()->user();
	    $users[] = Auth::guard('admin')->user();

	    //dd($users);

	    $users_count=User::count();
	    $job_count=PostJob::count();
	    $recent_jobs=PostJob::orderBy('id','desc')->take(5)->get();

	    return view('admin.dashboard',compact('users_count','job_count','recent_jobs'));
    }

    public function userindex(){
    	$users=User::get();
        return view('admin.users.index',compact('users'));
    }

    public function jobindex(){
    	$jobs=PostJob::get();
        return view('admin.jobs.index',compact('jobs'));
    }
}
