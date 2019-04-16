<?php

namespace App\Models\Rice;

use Illuminate\Database\Eloquent\Model;

class ProductionStockItem extends Model {

    protected $table = 'rice_production_stocks_item';
    public $timestamps = false;

    public function production_stocks() {
        return $this->belongsTo('App\Models\Rice|ProductionStock', 'production_stocks_id');
    }

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }

    public function productName($id) {
        return \App\Models\Inv\Product::find($id)->name;
    }

    public function productWeight($id) {
        return \App\Models\Inv\Product::find($id)->weight;
    }

    public function sumInQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['institute_id', institute_id()],['type', 'in'], ['after_production_id', $product_id]])->sum('quantity');
        } else {
            $data = $this->where([['institute_id', institute_id()], ['type', 'in']])->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumInWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['institute_id', institute_id()],['type', 'in'], ['after_production_id', $product_id]])->sum('weight');
        } else {
            $data = $this->where([['institute_id', institute_id()], ['type', 'in']])->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['institute_id', institute_id()],['type', 'out'], ['after_production_id', $product_id]])->sum('quantity');
        } else {
            $data = $this->where([['institute_id', institute_id()], ['type', 'out']])->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['institute_id', institute_id()],['type', 'out'], ['after_production_id', $product_id]])->sum('weight');
        } else {
            $data = $this->where([['institute_id', institute_id()], ['type', 'out']])->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumStockQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->sumInQuantity($product_id) - $this->sumOutQuantity($product_id);
        } else {
            $data = $this->sumInQuantity() - $this->sumOutQuantity();
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumStockWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->sumInWeight($product_id) - $this->sumOutWeight($product_id);
        } else {
            $data = $this->sumInWeight() - $this->sumOutWeight();
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function getDrawerByOrder($order) {
        $data = $this->where('order_no', $order)->groupBy('drawer_id')->get();
        return $data;
    }

    public function getProductByDrawer($order, $drawer) {
        $data = $this->where([['institute_id', institute_id()],['order_no', $order], ['drawer_id', $drawer]])->get();
        return $data;
    }

}
