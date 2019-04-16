<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Purchase extends Model {

    protected $table = 'purchase';
    public $timestamps = false;

    public static function get_purchase_invoice() {
        $invpre = 'PINV-';
        $data = DB::table('purchase')->where('type', '=', 'in')->orderBy('id', 'desc')->first();
        $invNo = !empty($data) ? $data->invoice_no : '';
        $invId = !empty($invNo) ? ltrim($invNo, $invpre) : 0;
        $nextVal = $invId + 1;
        return $invpre . $nextVal;
    }

    public static function get_opening_invoice() {
        $invpre = 'OINV-';
        $data = DB::table('purchase')->where('type', '=', 'in')->orderBy('id', 'desc')->first();
        $invNo = !empty($data) ? $data->invoice_no : '';
        $invId = !empty($invNo) ? ltrim($invNo, $invpre) : 0;
        $nextVal = $invId + 1;
        return $invpre . $nextVal;
    }

    public static function get_production_invoice() {
        $invpre = 'PRO-';
        $data = DB::table('purchase')->where('type', '=', 'out')->orderBy('id', 'desc')->first();
        $invNo = !empty($data) ? $data->invoice_no : '';
        $invId = !empty($invNo) ? ltrim($invNo, $invpre) : 0;
        $nextVal = $invId + 1;
        return $invpre . $nextVal;
    }

    public function categoryName($id) {
        return RawCategory::find($id)->name;
    }

    public function productName($id) {
        return RawProduct::find($id)->name;
    }

    public function items() {
        return $this->hasMany('App\Models\PurchaseItem', 'purchase_id', 'id');
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

//    public function stocks() {
//        return $this->hasMany('App\Stock', 'weight_id', 'id');
//    }
//
//    public function production_stocks() {
//        return $this->hasMany('App\ProductionStockItem', 'weight_id', 'id');
//    }

    public function transaction() {
        return $this->hasMany('App\Models\Transaction', 'purchase_id', 'id');
    }

//    public function sale_transaction() {
//        return $this->hasMany('App\Models\Transaction', 'sale_id', 'id');
//    }
}
