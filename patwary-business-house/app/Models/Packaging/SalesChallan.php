<?php

namespace App\Models\Packaging;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Inv\Category;
use App\Models\Inv\Product;

class SalesChallan extends Model {

    protected $table = 'packaging_sales_challan';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\Packaging\SalesChallanItem', 'sales_challan_id', 'id');
    }

    public static function get_finishgoods_invoice() {
        $invpre = 'FG-';
        $data = DB::table('packaging_sales_challan')->where('type', '=', 'in')->orderBy('id', 'desc')->first();
        $invNo = !empty($data) ? $data->invoice_no : '';
        $invId = !empty($invNo) ? ltrim($invNo, $invpre) : 0;
        $nextVal = $invId + 1;
        return $invpre . $nextVal;
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

}
