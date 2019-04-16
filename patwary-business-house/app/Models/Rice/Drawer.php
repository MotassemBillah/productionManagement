<?php

namespace App\Models\Rice;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Drawer extends Model {

    protected $table = 'rice_drawers';
    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\Models\Rice\ProductionOrder', 'drawer_id', 'id');
    }
    
    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }
}
