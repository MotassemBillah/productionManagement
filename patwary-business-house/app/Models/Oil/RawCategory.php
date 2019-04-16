<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class RawCategory extends Model {

    protected $table = 'raw_category';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\RawProduct', 'raw_category_id', 'id');
    }
}
