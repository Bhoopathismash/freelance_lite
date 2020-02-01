<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function hirerUser(){
    	return $this->belongsTo('App\User','hirer_user_id','id');
    }

    public function workerUser(){
    	return $this->belongsTo('App\User','worker_user_id','id');
    }

    public function post(){
    	return $this->belongsTo('App\PostJob','post_job_id','id');
    }
}
