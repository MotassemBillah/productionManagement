<?php

namespace App\Models\Rice;

use Illuminate\Database\Eloquent\Model;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Inv\Category;
use App\Models\Inv\Product;

class SalesChallan extends Model {

    protected $table = 'rice_sales_challan';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('App\Models\Rice\SalesChallanItem', 'sales_challan_id', 'id');
    }

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }

    public function production_stocks() {
        return $this->hasMany('App\Models\Rice\ProductionStockItem', 'sales_challan_id', 'id');
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
