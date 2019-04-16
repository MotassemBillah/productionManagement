<?php

namespace App\Models\Rental;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model {

    protected $table = 'rental_floor';
    public $timestamps = false;

    public function building() {
        return $this->belongsTo('App\Models\Rental\Building', 'building_id');
    }

    public function flat() {
        return $this->hasMany('App\Models\Rental\Flat', 'building_id', 'id');
    }

    public function buildingName($id) {
        $_name = "";
        if (!empty($id)) {
            $_name = Building::find($id)->building_name;
        }
        return $_name;
    }

}
