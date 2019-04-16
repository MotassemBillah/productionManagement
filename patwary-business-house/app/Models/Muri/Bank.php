<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model {

    protected $table = 'banks';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\BankAccount', 'bank_id', 'id');
    }

}
