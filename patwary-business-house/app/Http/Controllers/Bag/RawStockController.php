<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Exception;
use App\Models\RawCategory;
use App\Models\RawProduct;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use DB;
use Auth;

class RawStockController extends HomeController {

    public function index() {
        $dataset = RawProduct::orderBy('raw_category_id', 'DESC')->get();
        $category = new RawCategory();
        $product = new RawProduct();
        return view('Admin.raw_stock.index', compact('dataset', 'category', 'product'));
    }
    
    public function details() {
        $dataset = RawProduct::orderBy('raw_category_id', 'DESC')->get();
        $category = new RawCategory();
        $product = new RawProduct();
        return view('Admin.raw_stock.details', compact('dataset', 'category', 'product'));
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = RawProduct::query();
        if (!empty($category)) {
            $query->where('raw_category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        $query->orderBy('raw_category_id', 'DESC');
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new RawCategory();
        $product = new RawProduct();
        return view('Admin.raw_stock._list', compact('dataset', 'category', 'product'));
    }
    
    public function details_search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = RawProduct::query();
        if (!empty($category)) {
            $query->where('raw_category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        $query->orderBy('raw_category_id', 'DESC');
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new RawCategory();
        $product = new RawProduct();
        return view('Admin.raw_stock.details_search', compact('dataset', 'category', 'product'));
    }

    public function opening_stocks() {
        $data = Purchase::where('type', 'os')->first();
        if ((!empty($data) && count($data) > 0)) {
            $products = $data;
            return view('Admin.raw_stock.exist', compact('products'));
        } else {
            $products = RawProduct::orderBy('raw_category_id', 'DESC')->get();
            return view('Admin.raw_stock.create', compact('products'));
        }
    }

    public function store_opening_stocks(Request $r) {
        //pr($_POST);
        $resp = [];
        $invoice = $r->invoice_no;

        DB::beginTransaction();
        try {
            if (array_sum($_POST['quantity']) < 1) {
                throw new Exception("Warning! You must provide at least one Quantity.");
            }
            $inv = Purchase::where('invoice_no', $invoice)->first();
            if (!empty($inv)) {
                throw new Exception("Invoice already exist.");
            }

            if (empty($_POST['product'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            $model = new Purchase();

            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->invoice_no = $r->invoice_no;
            $model->type = 'os';
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Record.");
            }

            $last_id = DB::getPdo()->lastInsertId();

            $total_price = [];
            foreach ($_POST['product_id'] as $key => $value) {
//                    $_productName = RawProduct::find($value)->name;
//                    if (empty($_POST['quantity'][$value])) {
//                        throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
//                    }
//
//                    if (empty($_POST['per_qty_price'][$value])) {
//                        throw new Exception("Please Provide Per Qty Price.");
//                    }

                $modelItem = new PurchaseItem();
                $modelItem->purchase_id = $last_id;
                $modelItem->type = $model->type;
                $modelItem->date = $model->date;
                $modelItem->raw_category_id = $_POST['category_id'][$key];
                $modelItem->raw_product_id = $_POST['product_id'][$key];
                $modelItem->quantity = $_POST['quantity'][$key];
                $modelItem->per_qty_price = $_POST['per_qty_price'][$key];
                $modelItem->total_price = $_POST['total_price'][$key];
                $modelItem->created_by = $model->created_by;
                $modelItem->_key = uniqueKey() + $key;
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Record items.");
                }
            }

            $model->invoice_amount = array_sum($_POST['total_price']);
            $model->save();

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

            $model = Purchase::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->modified_by = Auth::id();

            if (!$model->save()) {
                throw new Exception("Error! while creating Record.");
            }

            $total_price = [];
            if (!empty($_POST['product_id'])) {
                foreach ($_POST['product_id'] as $key => $value) {
                    if (!empty($_POST['product_id'][$key])) {
                        $_productName = RawProduct::find($value)->name;
//                        if (empty($_POST['quantity'][$key])) {
//                            throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
//                        }

                        $modelItem = PurchaseItem::find($key);

                        $modelItem->date = $model->date;
                        $modelItem->raw_category_id = $_POST['category_id'][$key];
                        $modelItem->raw_product_id = $_POST['product_id'][$key];
                        $modelItem->quantity = $_POST['quantity'][$key];
                        $modelItem->per_qty_price = $_POST['per_qty_price'][$key];
                        $modelItem->total_price = $_POST['total_price'][$key];
                        $modelItem->modified_by = $model->modified_by;
                        $modelItem->_key = uniqueKey() + $key;
                        if (!$modelItem->save()) {
                            throw new Exception("Error! while creating Record items.");
                        }
                    }
                }
            }

            $model->invoice_amount = array_sum($_POST['total_price']);
            $model->save();

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
