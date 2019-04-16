<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Validator;
use Exception;
use Illuminate\Http\Request;
use App\Models\FinishCategory;
use App\Models\FinishProduct;
use App\Models\Sales;
use App\Models\SalesItem;

class FinishStockController extends HomeController {

    public function index() {
        $dataset = FinishProduct::orderBy('finish_category_id', 'DESC')->get();
        $category = new FinishCategory();
        $product = new FinishProduct();
        return view('Admin.finish_stock.index', compact('dataset', 'category', 'product'));
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = FinishProduct::query();
        if (!empty($category)) {
            $query->where('finish_category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        $query->orderBy('finish_category_id', 'DESC');
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new FinishCategory();
        $product = new FinishProduct();
        return view('Admin.finish_stock._list', compact('dataset', 'category', 'product'));
    }

    public function details() {
        $dataset = FinishProduct::orderBy('finish_category_id', 'DESC')->get();
        $category = new FinishCategory();
        $product = new FinishProduct();
        return view('Admin.finish_stock.details', compact('dataset', 'category', 'product'));
    }

    public function details_search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = FinishProduct::query();
        if (!empty($category)) {
            $query->where('finish_category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        $query->orderBy('finish_category_id', 'DESC');
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new FinishCategory();
        $product = new FinishProduct();
        return view('Admin.finish_stock.details_search', compact('dataset', 'category', 'product'));
    }

    public function opening_stocks() {
        $data = Sales::where('type', 'os')->first();
        if ((!empty($data) && count($data) > 0)) {
            $products = $data;
            return view('Admin.finish_stock.exist', compact('products'));
        } else {
            $products = FinishProduct::orderBy('finish_category_id', 'DESC')->get();
            return view('Admin.finish_stock.create', compact('products'));
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
            $inv = Sales::where('invoice_no', $invoice)->first();
            if (!empty($inv)) {
                throw new Exception("Invoice already exist.");
            }

            if (empty($_POST['product'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            $model = new Sales();

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
//                    $_productName = FinishProduct::find($value)->name;
//                    if (empty($_POST['quantity'][$value])) {
//                        throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
//                    }
//
//                    if (empty($_POST['per_qty_price'][$value])) {
//                        throw new Exception("Please Provide Per Qty Price.");
//                    }

                $modelItem = new SalesItem();
                $modelItem->sales_id = $last_id;
                $modelItem->type = $model->type;
                $modelItem->date = $model->date;
                $modelItem->finish_category_id = $_POST['category_id'][$key];
                $modelItem->finish_product_id = $_POST['product_id'][$key];
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

            $model = Sales::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->modified_by = Auth::id();

            if (!$model->save()) {
                throw new Exception("Error! while creating Record.");
            }

            $total_price = [];
            if (!empty($_POST['product_id'])) {
                foreach ($_POST['product_id'] as $key => $value) {
                    if (!empty($_POST['product_id'][$key])) {
                        $_productName = FinishProduct::find($value)->name;
//                        if (empty($_POST['quantity'][$key])) {
//                            throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
//                        }

                        $modelItem = SalesItem::find($key);

                        $modelItem->date = $model->date;
                        $modelItem->finish_category_id = $_POST['category_id'][$key];
                        $modelItem->finish_product_id = $_POST['product_id'][$key];
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
