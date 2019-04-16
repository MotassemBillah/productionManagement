<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class AccountBalance extends Model {

    protected $table = 'account_balance';
    public $timestamps = false;

    public function bank_account() {
        return $this->belongsTo('App\Models\BankAccount', 'bank_account_id', 'bank_id');
    }

    public function sumDebit($bank_account_id = null) {
        if (!is_null($bank_account_id)) {
            $data = AccountBalance::where('bank_account_id', $bank_account_id)->sum('debit');
        } else {
            $data = AccountBalance::where('bank_account_id', '')->sum('debit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumCredit($bank_account_id = null) {
        if (!is_null($bank_account_id)) {
            $data = AccountBalance::where('bank_account_id', $bank_account_id)->sum('credit');
        } else {
            $data = AccountBalance::where('bank_account_id', '')->sum('credit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumBalance($bank_account_id = null) {
        if (!is_null($bank_account_id)) {
            $data = $this->sumDebit($bank_account_id) - $this->sumCredit($bank_account_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

}
