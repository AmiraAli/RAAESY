<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAsset extends Model {

	public function asset(){

		return $this->belongsTo('App\Asset', 'asset_id', 'id');
	}

}
