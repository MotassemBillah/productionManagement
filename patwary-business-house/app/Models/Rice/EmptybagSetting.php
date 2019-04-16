<?php

namespace App\Models\Rice;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class EmptybagSetting extends Model {

    protected $table = 'rice_emptybag_setting';
    public $timestamps = false;
    
    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }
}
