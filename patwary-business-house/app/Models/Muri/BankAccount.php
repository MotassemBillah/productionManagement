<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {

    protected $table = 'bank_accounts';
    public $timestamps = false;

    public function bank() {
        return $this->belongsTo('App\Models\Bank', 'bank_id');
    }

    public function balances() {
        return $this->hasMany('App\Models\AccountBalance', 'bank_account_id', 'bank_id');
    }
    
    public function transactions() {
        return $this->hasMany('App\Models\Transactions', 'bank_account_id', 'id');
    }

    public function sumDebit($bank_id = null) {
        if (!is_null($bank_id)) {
            $data = Transactions::where('bank_account_id', $bank_id)->sum('debit');
        } else {
            $data = Transactions::where('bank_account_id', '')->sum('debit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumCredit($bank_id = null) {
        if (!is_null($bank_id)) {
            $data = Transactions::where('bank_account_id', $bank_id)->sum('credit');
        } else {
            $data = Transactions::where('bank_account_id', '')->sum('credit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumBalance($bank_id = null) {
        if (!is_null($bank_id)) {
            $data = $this->sumDebit($bank_id) - $this->sumCredit($bank_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

}
