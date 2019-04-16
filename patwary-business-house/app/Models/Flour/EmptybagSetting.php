<?php

namespace App\Models\Flour;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class EmptybagSetting extends Model {

    protected $table = 'flour_emptybag_setting';
    public $timestamps = false;
    
    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }
}
