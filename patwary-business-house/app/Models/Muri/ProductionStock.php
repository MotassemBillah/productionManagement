<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionStock extends Model {

    protected $table = 'production_stocks';
    public $timestamps = false;

    
    
    public function items() {
        return $this->hasMany('App\ProductionStockItem', 'production_stocks_id', 'id');
    }

    public static function get_production_stocks_invoice() {
        $invpre = 'PS-';
        $data = ProductionStock::whereNotNull('production_id')->orderBy('id', 'desc')->first();
        $orderNo = !empty($data) ? $data->production_stocks_no : '';
        $lastOrd = !empty($orderNo) ? ltrim($orderNo, $invpre) : 0;
        $nextVal = $lastOrd + 1;
        return $invpre . $nextVal;
    }

}
