<?php

namespace App;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Drawer extends Model {

    protected $table = 'drawers';
    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\ProductionOrder', 'drawer_id', 'id');
    }
}
