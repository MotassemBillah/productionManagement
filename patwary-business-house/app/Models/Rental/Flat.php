<?php

namespace App\Models\Rental;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model {

    protected $table = 'rental_flat';
    public $timestamps = false;

    public function floor() {
        return $this->belongsTo('App\Models\Rental\Floor', 'floor_id');
    }
    
    public function building() {
        return $this->belongsTo('App\Models\Rental\Building', 'building_id');
    }

    public function buildingName($id) {
        $_name = "";
        if (!empty($id)) {
            $_name = Building::find($id)->building_name;
        }
        return $_name;
    }

}
