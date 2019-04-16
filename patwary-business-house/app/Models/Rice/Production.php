<?php

namespace App\Models\Rice;

use Illuminate\Database\Eloquent\Model;

class Production extends Model {

    protected $table = 'rice_production';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\Rice\ProductionItem', 'production_id', 'id');
    }

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }

    public function stocks() {
        return $this->hasMany('App\Models\Rice\Stock', 'production_id', 'id');
    }

    public function production_stocks() {
        return $this->hasMany('App\Models\Rice\ProductionStock', 'production_id', 'id');
    }

    public function drawers() {
        return $this->hasMany('App\Models\Rice\Drawer', 'drawer_id', 'id');
    }

    public static function get_production_invoice() {
        $invpre = 'ORD-';
        $data = Production::orderBy('id', 'desc')->first();
        $orderNo = !empty($data) ? $data->order_no : '';
        $lastOrd = !empty($orderNo) ? ltrim($orderNo, $invpre) : 0;
        $nextVal = $lastOrd + 1;
        return $invpre . $nextVal;
    }

}
