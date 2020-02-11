<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBidPackages extends Model
{
   	public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function bidPackage(){
    	return $this->belongsTo('App\BidPackages','package_id','id');
    }
}
