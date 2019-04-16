<?php

namespace App;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class AfterProduction extends Model {

    protected $table = 'after_production';
    public $timestamps = false;

    public function category() {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
}
