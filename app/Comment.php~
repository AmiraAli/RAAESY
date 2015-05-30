<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	//
	public function ticket()
    {
        return $this->belongsTo('App\ticket');
    }

     public function user()
    {
        return $this->belongsTo('App\User');
    }

}
