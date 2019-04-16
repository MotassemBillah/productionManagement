<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    protected $table = 'customers';
    public $timestamps = false;

}
