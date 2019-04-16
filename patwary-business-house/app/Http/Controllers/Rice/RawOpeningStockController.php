<?php

namespace App\Http\Controllers\Rice;

use App\Http\Controllers\HomeController;
use Auth;
use DB;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Rice\Stock;
use Validator;
use Exception;
use Illuminate\Http\Request;

class RawOpeningStockController extends HomeController {

    public function index() {
        //check_user_access('production_stocks');
        $product = new Product();
        $category = new Category();
        $data = Stock::where([['institute_id', institute_id()], ['type', 'os']])->get();
        if (!empty($data) && count($data) > 0) {
            $dataset = $data;
            return view('rice.raw_opening_stocks.index', compact('dataset', 'category', 'product'));
        } else {
            $dataset = Product::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', RICEMILL]])->get();
            return view('rice.raw_opening_stocks.create', compact('dataset', 'category', 'product'));
        }
    }

    public function store(Request $r) {
        //pr($_POST);
        $resp = [];
        $input = $r->all();
        $rule = array(
            'date' => 'required',
        );
        $messages = array(
            'date.required' => 'Please insert date',
        );
        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            if (array_sum($_POST['quantity']) < 1) {
                throw new Exception("Warning! You must provide at least one Quantity.");
            }
            foreach ($_POST['category_id'] as $key => $value) {
                $model = new Stock();
                $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
                $model->date = date_ymd($r->date);
                $model->invoice_no = 'OS';
                $model->type = 'os';
                $model->category_id = $value;
                $model->product_id = $_POST['product_id'][$key];
                $model->weight = $_POST['net_weight'][$key];
                $model->quantity = $_POST['quantity'][$key];
                $model->created_by = Auth::id();
                $model->_key = uniqueKey();

                if (!$model->save()) {
                    throw new Exception("Error! while creating Production Stock.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Opening Stock has been Inserted Successfully.';
            $resp['url'] = url('rice/raw-opening-stocks');
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function update(Request $r) {
        //pr($_POST);
        $resp = [];
        $input = $r->all();
        $rule = array(
            'date' => 'required',
        );
        $messages = array(
            'date.required' => 'Please insert date',
        );
        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($_POST['hid'] as $key => $value) {
                $model = Stock::find($value);
                //pr($model);
                $model->date = date_ymd($r->date);
                $model->category_id = $_POST['category_id'][$value];
                ;
                $model->product_id = $_POST['product_id'][$value];
                $model->weight = $_POST['net_weight'][$value];
                $model->quantity = $_POST['quantity'][$value];
                $model->modified_by = Auth::id();

                if (!$model->save()) {
                    throw new Exception("Error! while Updating Production Stock.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Opening Stock has been Updated Successfully.';
            $resp['url'] = url('rice/raw-opening-stocks');
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
