<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

    protected $table = "stocks";
    public $timestamps = false;

    public function sumInQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['weight_type', 'in'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = Stock::where('weight_type', 'in')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumInWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['weight_type', 'in'], ['product_id', $product_id]])->sum('weight');
        } else {
            $data = Stock::where('weight_type', 'in')->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['weight_type', 'out'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = Stock::where('weight_type', 'out')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['weight_type', 'out'], ['product_id', $product_id]])->sum('weight');
        } else {
            $data = Stock::where('weight_type', 'out')->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumProcessQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['weight_type', 'process'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = Stock::where('weight_type', 'process')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumProcessWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['weight_type', 'process'], ['product_id', $product_id]])->sum('weight');
        } else {
            $data = Stock::where('weight_type', 'process')->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumStockQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->sumInQuantity($product_id) - ($this->sumOutQuantity($product_id) + $this->sumProcessQuantity($product_id));
        } else {
            $data = $this->sumInQuantity() - ($this->sumOutQuantity() + $this->sumProcessQuantity());
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumStockWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->sumInWeight($product_id) - ($this->sumOutWeight($product_id) + $this->sumProcessWeight($product_id));
        } else {
            $data = $this->sumInWeight() - ($this->sumOutWeight() + $this->sumProcessWeight());
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumInNetPrice($product_id = null) {
        if (!is_null($product_id)) {
            $data = WeightItem::where([['weight_type', 'in'], ['product_id', $product_id]])->sum('net_price');
        } else {
            $data = WeightItem::where('weight_type', 'in')->sum('net_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

}
