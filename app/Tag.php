<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	public function tickets()
    {
        return $this->belongsToMany('App\Ticket','ticket_tags');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Article','article_tags');
    }

}
