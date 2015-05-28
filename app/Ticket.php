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

	public function comments()
    {
        return $this->hasMany('App\Comment');
    }
	public function TicketTags()
    {
        return $this->belongsToMany('App\Tag','ticket_tags');
    }

	public function TicketAssets()
    {
        return $this->belongsToMany('App\Asset','ticket_assets');
    }

}
