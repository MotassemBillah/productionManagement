<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Weight;

class Weight extends Model {

    protected $table = 'weights';
    public $timestamps = false;

    public static function get_purchase_invoice() {
        $invpre = 'PINV-';
        $data = DB::table('weights')->where('weight_type', '=', 'in')->orderBy('id', 'desc')->first();
        $invNo = !empty($data) ? $data->invoice_no : '';
        $invId = !empty($invNo) ? ltrim($invNo, $invpre) : 0;
        $nextVal = $invId + 1;
        return $invpre . $nextVal;
    }

    public static function get_sale_invoice() {
        $invpre = 'SINV-';
        $data = DB::table('weights')->where('weight_type', '=', 'out')->orderBy('id', 'desc')->first();
        $invNo = !empty($data) ? $data->invoice_no : '';
        $invId = !empty($invNo) ? ltrim($invNo, $invpre) : 0;
        $nextVal = $invId + 1;
        return $invpre . $nextVal;
    }

    public function items() {
        return $this->hasMany('App\WeightItem', 'weight_id', 'id');
    }

    public function stocks() {
        return $this->hasMany('App\Stock', 'weight_id', 'id');
    }

    public function production_stocks() {
        return $this->hasMany('App\ProductionStockItem', 'weight_id', 'id');
    }

    public function purchase_transaction() {
        return $this->hasMany('App\Models\Transaction', 'purchase_id', 'id');
    }

    public function sale_transaction() {
        return $this->hasMany('App\Models\Transaction', 'sale_id', 'id');
    }


}
