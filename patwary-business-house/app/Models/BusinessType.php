<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model {

    protected $table = 'business_type';
    public $timestamps = false;

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id');
    }

}
