<?php

namespace App\Models\Flour;

use Illuminate\Database\Eloquent\Model;

class ProductionStock extends Model {

    protected $table = 'flour_production_stocks';
    public $timestamps = false;

    
    
    public function items() {
        return $this->hasMany('App\Models\Flour\ProductionStockItem', 'production_stocks_id', 'id');
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
