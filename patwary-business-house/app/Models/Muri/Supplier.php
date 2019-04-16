<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

    protected $table = 'suppliers';
    public $timestamps = false;

}
