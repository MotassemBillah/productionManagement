<?php

namespace App\Models\Rental;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Building extends Model {

    protected $table = 'rental_building';
    public $timestamps = false;

    public function floor() {
        return $this->hasMany('App\Models\Rental\Floor', 'building_id', 'id');
    }
    
    public function flat() {
        return $this->hasMany('App\Models\Rental\Flat', 'building_id', 'id');
    }
    
    public function party() {
        return $this->hasMany('App\Models\Rental\Party', 'building_id', 'id');
    }


}
