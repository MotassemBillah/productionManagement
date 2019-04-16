<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BagColor extends Model {

    protected $table = 'bag_color';
    public $timestamps = false;

}
