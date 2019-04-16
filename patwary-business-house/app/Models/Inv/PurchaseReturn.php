<?php

namespace App\Models\Inv;

use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model {

    protected $table = 'inv_purchase_return';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\Inv\PurchaseReturnItem', 'purchase_return_id', 'id')->where('is_deleted', '=', 0);
    }

    public function stocks() {
        return $this->hasMany('App\Models\Inv\Stock', 'purchase_return_id', 'id')->where('is_deleted', '=', 0);
    }

    public function avg_price_list() {
        return $this->hasMany('App\Models\Inv\AvgPrice', 'purchase_return_id', 'id')->where('is_deleted', '=', 0);
    }

    public function head_name($id) {
        $data = "";
        if (!empty($id)) {
            $data = Head::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function subhead_name($id) {
        $data = "";
        if (!empty($id)) {
            $data = SubHead::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function particular_name($id) {
        $data = "";
        if (!empty($id)) {
            $data = Particular::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function process_status() {
        return [
            "Pending" => "Pending",
            "Processed" => "Processed",
        ];
    }

    public function payment_status() {
        return [
            "Not Paid" => "Not Paid",
            "Partial Paid" => "Partial Paid",
            "Paid" => "Paid",
        ];
    }

    public function invoice_number() {
        $query = $this->max("invoice_no");
        $inv_no = $query;
        return !empty($inv_no) ? ($inv_no + 1) : 1;
    }

}
