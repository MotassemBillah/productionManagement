<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BagSize extends Model {

    protected $table = 'bag_size';
    public $timestamps = false;

}
