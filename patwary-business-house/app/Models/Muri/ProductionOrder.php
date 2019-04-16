<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model {

    protected $table = 'production_orders';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\ProductionOrderItem', 'production_id', 'id');
    }
    public function stocks() {
        return $this->hasMany('App\Stock', 'production_id', 'id');
    }
    public function production_stocks() {
        return $this->hasMany('App\ProductionStock', 'production_id', 'id');
    }
    public function drawers() {
        return $this->hasMany('App\Drawer', 'drawer_id', 'id');
    }

    public static function get_production_invoice() {
        $invpre = 'ORD-';
        $data = ProductionOrder::orderBy('id', 'desc')->first();
        $orderNo = !empty($data) ? $data->order_no : '';
        $lastOrd = !empty($orderNo) ? ltrim($orderNo, $invpre) : 0;
        $nextVal = $lastOrd + 1;
        return $invpre . $nextVal;
    }

}
