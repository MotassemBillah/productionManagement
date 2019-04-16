<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class FinishProduct extends Model {

    protected $table = 'finish_product';
    public $timestamps = false;

//    public function stocks() {
//        return $this->hasMany('App\Models\Stock', 'finish_product_id', 'id');
//    }

    public function category() {
        return $this->belongsTo('App\Models\FinishCategory', 'finish_category_id', 'id');
    }

    public function categoryName($id) {
        $data = "";
        if (!empty($id)) {
            $data = FinishCategory::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function sumOpeningQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = SalesItem::where([['type', 'os'], ['finish_product_id', $product_id]])->sum('quantity');
        } else {
            $data = SalesItem::where('type', 'os')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }
    
    public function sumInQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = SalesItem::where([['type', 'in'], ['finish_product_id', $product_id]])->sum('quantity');
        } else {
            $data = SalesItem::where('type', 'in')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = SalesItem::where([['type', 'out'], ['finish_product_id', $product_id]])->sum('quantity');
        } else {
            $data = SalesItem::where('type', 'out')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumStockQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = ($this->sumInQuantity($product_id) + $this->sumOpeningQuantity($product_id)) - $this->sumOutQuantity($product_id);
        } else {
            $data = ($this->sumInQuantity() + $this->sumOpeningQuantity()) - $this->sumOutQuantity();
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumInNetPrice($product_id = null) {
        if (!is_null($product_id)) {
            $data = SalesItem::where([['type', 'in'], ['finish_product_id', $product_id]])->sum('total_price');
        } else {
            $data = SalesItem::where('type', 'in')->sum('total_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutNetPrice($product_id = null) {
        if (!is_null($product_id)) {
            $data = SalesItem::where([['type', 'out'], ['finish_product_id', $product_id]])->sum('total_price');
        } else {
            $data = SalesItem::where('type', 'out')->sum('total_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function avgPurchasePrice($product_id) {
        $price = $this->sumInNetPrice($product_id);
        $quantity = $this->sumInQuantity($product_id);
        if ($quantity == 0) {
            $quantity = 1;
        }
        $data = $price / $quantity;
        return !empty($data) ? doubleval($data) : 0;
    }

    public function avgProductionPrice($product_id) {
        $price = $this->sumOutNetPrice($product_id);
        $quantity = $this->sumOutQuantity($product_id);
        if ($quantity == 0) {
            $quantity = 1;
        }
        $data = $price / $quantity;
        return !empty($data) ? doubleval($data) : 0;
    }

}
