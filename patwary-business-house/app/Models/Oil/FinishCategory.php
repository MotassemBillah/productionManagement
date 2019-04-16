<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class FinishCategory extends Model {

    protected $table = 'finish_category';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\FinishProduct', 'finish_category_id', 'id');
    }
}
