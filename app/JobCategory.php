<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    //

    public function post(){
    	return $this->belongsTo('App\PostJob','id','category_id');
    }

    public function jobpost(){
    	return $this->hasMany('App\PostJob','category_id', 'id');
    }
}
