<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model {

	public function categories() {
        return $this->hasMany('App\Category');
    }

}
