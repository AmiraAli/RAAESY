<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model {


	public function user() {
        return $this->belongsTo('App\User');
    }

	public function assettype(){
		return $this->belongsTo('App\AssetType'); 
	}


	public function AssetTickets()
    {
        return $this->belongsToMany('App\Ticket','ticket_assets');
	}
	public function tickets() {
         return $this->belongsToMany('App\Ticket','ticket_assets');

    }

}
