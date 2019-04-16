<?php

namespace App\Http\Controllers\Oven;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Validator;
use Exception;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Oven\SalesChallan;
use App\Models\Oven\SalesChallanItem;
use DB;
use Auth;

class FinishStockController extends HomeController {

    public function index() {
        $dataset = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]])->get();
        $categories = Category::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]])->get();
        $stock = new SalesChallanItem();
        return view('oven.finish_stock.index', compact('dataset', 'categories', 'stock'));
    }

    public function details() {
        $dataset = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]])->get();
        $categories = Category::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]])->get();
        $stock = new SalesChallanItem();
        return view('oven.finish_stock.details', compact('dataset', 'categories', 'stock'));
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]]);
        if (!empty($category)) {
            $query->where('category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        $query->limit($item_count);
        $dataset = $query->get();
        $stock = new SalesChallanItem();
        return view('oven.finish_stock._list', compact('dataset', 'stock'));
    }

    public function details_search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]]);
        if (!empty($category)) {
            $query->where('category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        //$query->orderBy('category_id', 'DESC');
        $query->limit($item_count);
        $dataset = $query->get();
        $stock = new SalesChallanItem();
        return view('oven.finish_stock.details_search', compact('dataset', 'stock'));
    }

    public function opening_stocks() {
        $data = SalesChallan::where('type', 'os')->first();
        if ((!empty($data))) {
            $products = $data;
            return view('oven.finish_stock.exist', compact('products'));
        } else {
            $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]])->get();
            return view('oven.finish_stock.create', compact('products'));
        }
    }

    public function store_opening_stocks(Request $r) {
        //pr($_POST);
        $resp = [];

        DB::beginTransaction();
        try {
            if (array_sum($_POST['quantity']) < 1) {
                throw new Exception("Warning! You must provide at least one Quantity.");
            }

            if (empty($_POST['product_id'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            $model = new SalesChallan();

            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->order_no = 'OS';
            $model->type = 'os';
            $model->total_quantity = array_sum($_POST['quantity']);
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Record.");
            }

            $last_id = DB::getPdo()->lastInsertId();
            foreach ($_POST['product_id'] as $key => $value) {
//                $_productName = Product::find($value)->name;
//                if (empty($_POST['quantity'][$value])) {
//                    throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
//                }

                $modelItem = new SalesChallanItem();
                $modelItem->sales_challan_id = $last_id;
                $modelItem->date = $model->date;
                $modelItem->type = $model->type;
                $modelItem->category_id = $_POST['category_id'][$key];
                $modelItem->product_id = $_POST['product_id'][$key];
                $modelItem->quantity = $_POST['quantity'][$key];
                $modelItem->created_by = $model->created_by;
                $modelItem->_key = uniqueKey() . $key;
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Record items.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record has been Inserted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function update_opening_stocks(Request $r) {
        //pr($_POST);
        $resp = [];
        $id = $r->hid;
        DB::beginTransaction();
        try {
            if (array_sum($_POST['quantity']) < 1) {
                throw new Exception("Warning! You must provide at least one Quantity.");
            }
            $model = SalesChallan::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->modified_by = Auth::id();
            $model->total_quantity = array_sum($_POST['quantity']);

            if (!$model->save()) {
                throw new Exception("Error! while creating Record.");
            }
            if (!empty($_POST['product_id'])) {
                foreach ($_POST['product_id'] as $key => $value) {
                    if (!empty($_POST['product_id'][$key])) {
//                        $_productName = Product::find($value)->name;
//                        if (empty($_POST['quantity'][$key])) {
//                            throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
//                        }
                        $modelItem = SalesChallanItem::find($key);

                        $modelItem->date = $model->date;
                        $modelItem->category_id = $_POST['category_id'][$key];
                        $modelItem->product_id = $_POST['product_id'][$key];
                        $modelItem->quantity = $_POST['quantity'][$key];
                        $modelItem->modified_by = $model->modified_by;
                        $modelItem->_key = uniqueKey() . $key;
                        if (!$modelItem->save()) {
                            throw new Exception("Error! while creating Record items.");
                        }
                    }
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record has been Inserted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
