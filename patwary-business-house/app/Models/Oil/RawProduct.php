<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class RawProduct extends Model {

    protected $table = 'raw_product';
    public $timestamps = false;

    public function stocks() {
        return $this->hasMany('App\Models\Stock', 'raw_product_id', 'id');
    }

    public function category() {
        return $this->belongsTo('App\Models\RawCategory', 'raw_category_id', 'id');
    }

    public function categoryName($id) {
        return RawCategory::find($id)->name;
    }
    

    public function sumOpeningQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = PurchaseItem::where([['type', 'os'], ['raw_product_id', $product_id]])->sum('quantity');
        } else {
            $data = PurchaseItem::where('type', 'os')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }
    
    public function sumInQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = PurchaseItem::where([['type', 'in'], ['raw_product_id', $product_id]])->sum('quantity');
        } else {
            $data = PurchaseItem::where('type', 'in')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }
    
    public function sumOutQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = PurchaseItem::where([['type', 'out'], ['raw_product_id', $product_id]])->sum('quantity');
        } else {
            $data = PurchaseItem::where('type', 'out')->sum('quantity');
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
            $data = PurchaseItem::where([['type', 'in'], ['raw_product_id', $product_id]])->sum('total_price');
        } else {
            $data = PurchaseItem::where('type', 'in')->sum('total_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }
    
    public function sumOutNetPrice($product_id = null) {
        if (!is_null($product_id)) {
            $data = PurchaseItem::where([['type', 'out'], ['raw_product_id', $product_id]])->sum('total_price');
        } else {
            $data = PurchaseItem::where('type', 'out')->sum('total_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function avgPurchasePrice($product_id) {
        $price = $this->sumInNetPrice($product_id);
        $quantity = $this->sumInQuantity($product_id);
        if($quantity == 0){
            $quantity = 1;
        }
        $data = $price / $quantity;
        return !empty($data) ? doubleval($data) : 0;
    }
    
    public function avgProductionPrice($product_id) {
        $price = $this->sumOutNetPrice($product_id);
        $quantity = $this->sumOutQuantity($product_id);
        if($quantity == 0){
            $quantity = 1;
        }
        $data = $price / $quantity;
        return !empty($data) ? doubleval($data) : 0;
    }

}
