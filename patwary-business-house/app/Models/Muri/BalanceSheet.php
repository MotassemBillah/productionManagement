<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model {

    protected $table = 'balancesheet';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\LedgerSubHead', 'ledger_head_id', 'id');
    }

}
