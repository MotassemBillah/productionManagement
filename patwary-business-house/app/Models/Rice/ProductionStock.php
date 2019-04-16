<?php

namespace App\Models\Rice;

use Illuminate\Database\Eloquent\Model;

class ProductionStock extends Model {

    protected $table = 'rice_production_stocks';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\Rice\ProductionStockItem', 'production_stocks_id', 'id');
    }

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
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
