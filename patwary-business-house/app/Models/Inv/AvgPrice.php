<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Model;

class AvgPrice extends Model {

    protected $table = 'inv_avg_price';
    public $timestamps = false;

    public function avg_price($id = null) {
        $_retval = "";
        if (!is_null($id)) {
            $data = $this->find($id);
            $_retval = $data->avg_price;
        } else {
            $_retval = $this->avg_price;
        }

        return $_retval;
    }

    public function opening_avg_price($pid) {
        $query = $this->where('is_deleted', 0);
        $query->where('product_id', $pid);
        $query->whereNull('purchase_id');
        $query->whereNull('sale_id');
        $query->orderBy('id', 'DESC');
        $query->limit(1);
        $_data = $query->first();

        return !empty($_data) ? round($_data->avg_price, 2) : "";
    }

    public function last_avg_price($pid) {
        $_tqty = $this->sum_total_qty($pid);
        $_tprice = $this->sum_total_price($pid);
        if ($_tprice > 0 && $_tqty > 0) {
            $_avgPrice = ($_tprice / $_tqty);
        } else {
            $_avgPrice = 0;
        }

        return !empty($_avgPrice) ? round($_avgPrice, 2) : "";
    }

    public function sum_total_qty($pid = null) {
        $query = $this->where('is_deleted', 0);
        if (!is_null($pid)) {
            $query->where('product_id', $pid);
        }
        $sum = $query->sum('quantity');
        return !empty($sum) ? $sum : 0;
    }

    public function sum_total_price($pid = null) {
        $query = $this->where('is_deleted', 0);
        if (!is_null($pid)) {
            $query->where('product_id', $pid);
        }
        $sum = $query->sum('total_price');
        return !empty($sum) ? round($sum, 2) : 0;
    }

}
