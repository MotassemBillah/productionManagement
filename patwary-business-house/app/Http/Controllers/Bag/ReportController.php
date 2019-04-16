<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Carbon\CarbonPeriod;
use App\ProductionStockItem;
use Validator;
use Exception;
use DB;
use Auth;
use App\Category;
use App\Product;
use App\AfterProduction;
use Session;
use Illuminate\Http\Request;

class ReportController extends HomeController {

    public function product_register() {
        $products = AfterProduction::all();
        return view('Admin.report.product_register', compact('products'));
    }

    public function product_register_search(Request $r) {
        //pr($_POST);
        $model = new ProductionStockItem();
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $id = $r->product;
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $query = ProductionStockItem::where('quantity', '!=', 0);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($id)) {
            $query->where('after_production_id', $id);
        }
        $product_info = AfterProduction::find($id);
        $pre = $model->where([['after_production_id', $id],['production_stocks_no', 'OS'], ['quantity', '!=', 0]])->first();
        $previous = !empty($pre) ? $pre->quantity : 0;
        $product = !empty($product_info) ? $product_info->name : '';
        $dataset = $query->orderBy('date', 'ASC')->paginate($item_count);
        return view('Admin.report.product_register_search', compact('dataset', 'product', 'previous'));
    }

}
