<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    //

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function assignedTo(){
    	return $this->belongsTo('App\User','assigned_to','id');
    }

    public function category(){
    	return $this->hasOne('App\JobCategory','id','category_id');
    }

    public function jobFiles(){
    	return $this->hasMany('App\PostFiles','post_job_id','id');
    }

    public function milestone(){
        return $this->hasMany('App\Milestones','post_job_id','id');
    }

    public function bid(){
    	return $this->hasMany('App\Bid','post_job_id','id');
    }

    public function chat(){
    	return $this->hasMany('App\Chat','post_job_id','id');
    }
}
