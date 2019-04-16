<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Particular extends Model {

    protected $table = 'particulars';
    public $timestamps = false;

    public function head() {
        return $this->belongsTo('App\Models\Head', 'head_id', 'id');
    }

    public function subhead() {
        return $this->belongsTo('App\Models\SubHead', 'subhead_id', 'id');
    }

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id');
    }

}
