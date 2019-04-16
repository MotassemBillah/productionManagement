<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Account extends Model {

    protected $table = 'accounts';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\LedgerSubHead', 'ledger_head_id', 'id');
        //return $this->hasMany('App\Models\LedgerSubHead');
    }

}
