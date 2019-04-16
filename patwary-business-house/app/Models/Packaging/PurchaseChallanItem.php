<?php

namespace App\Models\Packaging;

use Illuminate\Database\Eloquent\Model;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Inv\Category;
use App\Models\Inv\Product;

class PurchaseChallanItem extends Model {

    protected $table = 'packaging_purchase_challan_item';
    public $timestamps = false;

    public function purchase_challan() {
        return $this->belongsTo('App\Models\Packaging\PurchaseChallan', 'purchase_challan_id');
    }

    public function headName($id) {
        $data = "";
        if (!empty($id)) {
            $data = Head::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function subheadName($id) {
        $data = "";
        if (!empty($id)) {
            $data = SubHead::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function particularName($id) {
        $data = "";
        if (!empty($id)) {
            $data = Particular::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
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

    public function sumOpeningQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['type', 'os'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = $this->where('type', 'os')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumInQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['type', 'in'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = $this->where('type', 'in')->sum('quantity');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutQuantity($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['type', 'out'], ['product_id', $product_id]])->sum('quantity');
        } else {
            $data = $this->where('type', 'out')->sum('quantity');
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
            $data = $this->where([['type', 'in'], ['product_id', $product_id]])->sum('total_price');
        } else {
            $data = $this->where('type', 'in')->sum('total_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumOutNetPrice($product_id = null) {
        if (!is_null($product_id)) {
            $data = $this->where([['type', 'out'], ['product_id', $product_id]])->sum('total_price');
        } else {
            $data = $this->where('type', 'out')->sum('total_price');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

}
