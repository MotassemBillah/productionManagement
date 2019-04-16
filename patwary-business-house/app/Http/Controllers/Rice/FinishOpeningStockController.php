<?php

namespace App\Http\Controllers\Rice;

use App\Http\Controllers\HomeController;
use Auth;
use DB;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Rice\ProductionItem;
use App\Models\Rice\ProductionStock;
use App\Models\Rice\ProductionStockItem;
use Validator;
use Exception;
use Illuminate\Http\Request;

class FinishOpeningStockController extends HomeController {

    public function index() {
        //check_user_access('production_stocks');
        $product = new Product();
        $category = new Category();
        $data = ProductionStock::where([['institute_id', institute_id()], ['order_no', 'OS']])->first();
        if (!empty($data)) {
            $dataset = $data;
            return view('rice.finish_opening_stocks.index', compact('dataset', 'category', 'product'));
        } else {
            $dataset = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', RICEMILL]])->get();
            return view('rice.finish_opening_stocks.create', compact('dataset', 'category', 'product'));
        }
    }

    public function create() {
        $dataset = AfterProduction::all();
        $category = new Category();
        return view('rice.finish_opening_stocks.create', compact('dataset', 'category'));
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
            $model = new ProductionStock();
            $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
            $model->date = date_ymd($r->date);
            $model->order_no = 'OS';
            $model->type = 'in';
            $model->production_stocks_no = $model->order_no;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Production Stock.");
            }
            $last_id = DB::getPdo()->lastInsertId();

            foreach ($_POST['category_id'] as $key => $value) {
                $modelItem = new ProductionStockItem();
                $modelItem->institute_id = $model->institute_id;
                $modelItem->date = $model->date;
                $modelItem->type = $model->type;
                $modelItem->production_stocks_id = $last_id;
                $modelItem->category_id = $value;
                $modelItem->after_production_id = $_POST['product_id'][$key];
                $modelItem->order_no = $model->order_no;
                $modelItem->production_stocks_no = $model->production_stocks_no;
                $modelItem->weight = $_POST['net_weight'][$key];
                $modelItem->quantity = $_POST['quantity'][$key];
                $modelItem->created_by = $model->created_by;
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Production Stock Item.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Opening Stock has been Inserted Successfully.';
            $resp['url'] = url('rice/finish-opening-stocks');
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
        $id = $r->hid;
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
            $model = new ProductionStock();
            $modelItem = new ProductionStockItem();
            $data = $model->with('items')->find($id);
            if (!empty($data->items)) {
                foreach ($data->items as $item) {
                    $existStockITem = $modelItem->find($item->id);
                    if (!empty($existStockITem)) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Stock Item.");
                        }
                    }
                }
            }

            if (!$data->delete()) {
                throw new Exception("Error while deleting records from Production Stock.");
            }

            $model->date = date_ymd($r->date);
            $model->order_no = 'OS';
            $model->type = 'in';
            $model->production_stocks_no = $model->order_no;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Production Stock.");
            }
            $last_id = DB::getPdo()->lastInsertId();

            foreach ($_POST['category_id'] as $key => $value) {
                $modelItem = new ProductionStockItem();
                $modelItem->date = $model->date;
                $modelItem->type = $model->type;
                $modelItem->production_stocks_id = $last_id;
                $modelItem->category_id = $value;
                $modelItem->after_production_id = $_POST['product_id'][$key];
                $modelItem->order_no = $model->order_no;
                $modelItem->production_stocks_no = $model->production_stocks_no;
                $modelItem->weight = $_POST['net_weight'][$key];
                $modelItem->quantity = $_POST['quantity'][$key];
                $modelItem->created_by = $model->created_by;
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Production Stock Item.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Opening Stock has been Updated Successfully.';
            $resp['url'] = url('rice/finish-opening-stocks');
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = AfterProduction::query();
        if (!empty($category)) {
            $query->where('category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        if (!empty($search)) {
            $productarr = [];
            $products = AfterProduction::where('name', 'like', '%' . $search . '%')->get();
            foreach ($products as $pro) {
                $productarr[] = $pro->id;
            }
            $query->whereIn('id', $productarr);
        }
        $query->orderBy('category_id', 'DESC');
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new Category();
        $product = new AfterProduction();
        $stock = new ProductionStock();
        return view('rice.production_stocks._list', compact('dataset', 'category', 'product', 'stock'));
    }

}
