<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

    protected $table = 'inv_stocks';
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('App\Models\Inv\Product', 'product_id');
    }

    public function purchase() {
        return $this->belongsTo('App\Models\Inv\Purchase', 'purchase_id');
    }

    public function sale() {
        return $this->belongsTo('App\Models\Inv\Sale', 'sale_id');
    }

    // stock checking method
    public function hasProduct($pid) {
        $query = $this->where('is_deleted', 0);
        $query->where('product_id', $pid);
        $_obj = $query->exists();
        if (!$_obj) {
            return false;
        } else {
            return true;
        }
    }

    public function opening_qty($pid) {
        $query = $this->where('is_deleted', 0);
        $query->where('stock_type', STOCK_OPENING);
        $query->where('product_id', $pid);
        $sum = $query->sum('quantity');
        return !empty($sum) ? $sum : 0;
    }

    public function purchase_qty($pid, $_date = []) {
        $query = $this->where('is_deleted', 0);
        $query->where('stock_type', STOCK_PURCHASE);
        $query->where('product_id', $pid);
        if (!empty($_date) && is_array($_date)) {
            $from_date = date("Y-m-d", strtotime($_date[0]));
            $end_date = date("Y-m-d", strtotime($_date[1]));
            $query->whereBetween('invoice_date', [$from_date, $end_date]);
        }
        $sum = $query->sum('quantity');
        return !empty($sum) ? $sum : 0;
    }

    public function sale_qty($pid, $_date = []) {
        $query = $this->where('is_deleted', 0);
        $query->where('stock_type', STOCK_SALE);
        $query->where('product_id', $pid);
        if (!empty($_date) && is_array($_date)) {
            $from_date = date("Y-m-d", strtotime($_date[0]));
            $end_date = date("Y-m-d", strtotime($_date[1]));
            $query->whereBetween('invoice_date', [$from_date, $end_date]);
        }
        $sum = $query->sum('quantity');
        return !empty($sum) ? $sum : 0;
    }

    public function available_qty($pid, $_date = []) {
        $_opQty = $this->opening_qty($pid);
        $_purchaseQty = $this->purchase_qty($pid, $_date);
        $_saleQty = $this->sale_qty($pid, $_date);
        $_stock = (($_opQty + $_purchaseQty) - $_saleQty);
        return !empty($_stock) ? $_stock : 0;
    }

    // previous stock count
    public function prev_pqty($pid, $_date) {
        $_dt = date('Y-m-d', strtotime($_date));
        $query = $this->where('is_deleted', 0);
        $query->where('stock_type', STOCK_PURCHASE);
        $query->where('product_id', $pid);
        $query->where('invoice_date', ' < ', $_dt);

        $sum = $query->sum('quantity');
        return !empty($sum) ? $sum : 0;
    }

    public function prev_sqty($pid, $_date) {
        $_dt = date('Y-m-d', strtotime($_date));
        $query = $this->where('is_deleted', 0);
        $query->where('stock_type', STOCK_SALE);
        $query->where('product_id', $pid);
        $query->where('invoice_date', ' < ', $_dt);

        $sum = $query->sum('quantity');
        return !empty($sum) ? $sum : 0;
    }

    public function available_prev_qty($pid, $_date) {
        $_opQty = $this->opening_qty($pid);
        $_purchaseQty = $this->prev_pqty($pid, $_date);
        $_saleQty = $this->prev_sqty($pid, $_date);
        $_stock = (($_opQty + $_purchaseQty) - $_saleQty);
        return !empty($_stock) ? $_stock : 0;
    }

    // sum method by date, product, particular
    public function sum_qty_by_date_product_particular($type, $date, $productId, $particularId) {
        $query = $this->where('is_deleted', 0);
        $query->where('stock_type', $type);
        $query->where('invoice_date', $date);
        $query->where('product_id', $productId);
        $query->where('particular_id', $particularId);
        $sum = $query->sum('quantity');
        return !empty($sum) ? $sum : 0;
    }

    // stock date
    public function get_date($_end = false) {
        $query = $this->orderBy("invoice_date", "ASC");
        if ($_end == true) {
            $query = $this->orderBy("invoice_date", "DESC");
        }
        $query->limit(1);
        $_data = $query->first();
        return !empty($_data) ? date("Y-m-d", strtotime($_data->invoice_date)) : "";
    }

    public static function get_date_val($_end = false) {
        $query = Stock::orderBy("invoice_date", "ASC");
        if ($_end == true) {
            $query = Stock::orderBy("invoice_date", "DESC");
        }
        $query->limit(1);
        $_data = $query->first();
        return !empty($_data) ? date("Y-m-d", strtotime($_data->invoice_date)) : "";
    }

}
