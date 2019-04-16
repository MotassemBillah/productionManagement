<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class LaborPayment extends Model {

    protected $table = 'labor_payment';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\LaborPaymentItem', 'labor_payment_id', 'id');
    }

    public function transaction() {
        return $this->hasMany('App\Models\Transaction', 'labor_payment_id', 'id');
    }

    public function headName($id) {
        $data = "";
        if (!empty($id)) {
            $data = Head::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function subheadName($id) {
        $data = "";
        if (!empty($id)) {
            $data = SubHead::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

}
