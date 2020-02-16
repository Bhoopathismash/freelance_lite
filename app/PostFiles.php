<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostFiles extends Model
{
    public function post(){
    	return $this->belongsTo('App\PostJob','post_job_id','id');
    }
}
