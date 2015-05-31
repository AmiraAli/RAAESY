<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	public function section()
	    {
	        return $this->belongsTo('App\Section');
	    }

	public function articles() 
	   {
           return $this->hasMany('App\Article');
       }

}
