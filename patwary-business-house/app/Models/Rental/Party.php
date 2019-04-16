<?php

namespace App\Models\Rental;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Party extends Model {

    protected $table = 'rental_party';
    public $timestamps = false;

    public function building() {
        return $this->belongsTo('App\Models\Rental\Building', 'building_id');
    }
    
    public function floor() {
        return $this->belongsTo('App\Models\Rental\Floor', 'floor_id');
    }

    public function flat() {
        return $this->belongsTo('App\Models\Rental\Flat', 'flat_id', 'id');
    }

    public function buildingName($id) {
        $_name = "";
        if (!empty($id)) {
            $_name = Building::find($id)->building_name;
        }
        return $_name;
    }

}
