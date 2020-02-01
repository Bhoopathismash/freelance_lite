<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function post(){
    	return $this->belongsTo('App\PostJob','post_job_id','id');
    }
}
