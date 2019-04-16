<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Head extends Model {

    protected $table = 'heads';
    public $timestamps = false;

    public function subhead() {
        return $this->hasMany('App\Models\SubHead', 'head_id', 'id');
    }
    public function particular() {
        return $this->hasMany('App\Models\Particular', 'head_id', 'id');
    }

}
