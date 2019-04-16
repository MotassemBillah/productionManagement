<?php

namespace App\Models\Rice;
use App\Models\Inv\Category;
use App\Models\Inv\Product;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

    protected $table = "rice_stocks";
    public $timestamps = false;

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }

    public function categoryName($id) {
        $data = "";
        if (!empty($id)) {
            $data = Category::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function productName($id) {
        $data = "";
        if (!empty($id)) {
            $data = Product::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }
    
    public function productWeight($id) {
        $data = "";
        if (!empty($id)) {
            $data = Product::find($id);
        }
        $_name = !empty($data) ? $data->weight : '';
        return $_name;
    }

    public function sumInQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'in'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'in']])->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOsQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'os'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'os']])->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumInWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'in'], ['product_id', $product_id]])->sum('weight');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'in']])->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOsWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'os'], ['product_id', $product_id]])->sum('weight');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'os']])->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'out'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'out']])->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'out'], ['product_id', $product_id]])->sum('weight');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'out']])->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumProcessQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'process'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'process']])->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumProcessWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'process'], ['product_id', $product_id]])->sum('weight');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'process']])->sum('weight');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumStockQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = ($this->sumInQuantity($product_id) + $this->sumOsQuantity($product_id)) - ($this->sumOutQuantity($product_id) + $this->sumProcessQuantity($product_id));
        } else {
            $data = ($this->sumInQuantity() + $this->sumOsQuantity()) - ($this->sumOutQuantity() + $this->sumProcessQuantity());
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumStockWeight($product_id = null) {
        if (!is_null($product_id)) {
            $data = ($this->sumInWeight($product_id) + $this->sumOsWeight($product_id)) - ($this->sumOutWeight($product_id) + $this->sumProcessWeight($product_id));
        } else {
            $data = ($this->sumInWeight() + $this->sumOsWeight()) - ($this->sumOutWeight() + $this->sumProcessWeight());
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumInNetPrice($product_id = null) {
        if (!is_null($product_id)) {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'in'], ['product_id', $product_id]])->sum('net_price');
        } else {
            $data = Stock::where([['institute_id', institute_id()], ['type', 'in']])->sum('net_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function avgPurchasePrice($product_id) {
        $data = $this->sumInNetPrice($product_id) / $this->sumInWeight($product_id);
        return !empty($data) ? doubleval($data) : 0;
    }

}
