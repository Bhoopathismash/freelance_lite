<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    //

    public function category(){
    	return $this->hasOne('App\JobCategory','id','category_id');
    }


    public function milestone(){
    	return $this->hasMany('App\Milestones','post_job_id','id');
    }
}
