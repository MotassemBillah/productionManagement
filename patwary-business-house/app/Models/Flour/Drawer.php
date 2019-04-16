<?php

namespace App\Models\Flour;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Drawer extends Model {

    protected $table = 'flour_drawers';
    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\Models\Flour\ProductionOrder', 'drawer_id', 'id');
    }
}
