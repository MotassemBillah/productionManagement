<?php

namespace App\Models\Flour;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Godown extends Model {

    protected $table = 'flour_godowns';
    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\Models\Flour\ProductionOrder', 'godown_id', 'id');
    }
    
    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }
}
