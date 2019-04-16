<?php

namespace App\Models\Muri;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class SubHead extends Model {

    protected $table = 'subheads';
    public $timestamps = false;

    public function head() {
        return $this->belongsTo('App\Models\Head', 'head_id');
    }

    public function particular() {
        return $this->hasMany('App\Models\Particular', 'subhead_id', 'id');
    }

}
