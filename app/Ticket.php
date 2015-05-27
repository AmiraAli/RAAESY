<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {

	 public function subject()
	    {
	        return $this->belongsTo('App\Subject');
	    }
	 public function category()
	    {
	        return $this->belongsTo('App\Category');
	    }
	 public function user()
	    {
	        return $this->belongsTo('App\User');
	    }

}
