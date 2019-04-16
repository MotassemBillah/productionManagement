<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BagType extends Model {

    protected $table = 'bag_type';
    public $timestamps = false;

}
