<?php

namespace App\Http\Controllers\Inv;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\Models\BusinessType;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Inv\AvgPrice;
use App\Models\Inv\Purchase;
use App\Models\Inv\Sale;
use App\Models\Inv\Stock;
use App\Models\SubHead;
use App\Models\Particular;
use DB;
use Validator;
use Illuminate\Http\Request;

class ProductController extends HomeController {

    public function index() {
        //check_user_access('inv_product_list');
        $model = new Product();
        $query = $model->where('is_deleted', 0);
        $dataset = $query->paginate($this->getSettings()->pagesize);

        $business_types = BusinessType::get();
        $categories = Category::get();
        $types = type_list();

        $this->model['breadcrumb_title'] = "Product List";
        $this->model['dataset'] = $dataset;
        $this->model['business_types'] = $business_types;
        $this->model['categories'] = $categories;
        $this->model['types'] = $types;
        return view('inv.product.index', $this->model);
    }

    public function create() {
        //check_user_access('inv_product_create');
        $business_types = BusinessType::get();
        $categories = Category::get();
        $types = type_list();

        $this->model['breadcrumb_title'] = "Product Information";
        $this->model['business_types'] = $business_types;
        $this->model['categories'] = $categories;
        $this->model['types'] = $types;
        return view('inv.product.create', $this->model);
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'business_type_id' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'name' => 'required',
        );

        $messages = array(
            'business_type_id.required' => 'Please select business type.',
            'category_id.required' => 'Please select categoty.',
            'type.required' => 'Please select product type.',
            'name.required' => 'Name required.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new Product();
        $model->business_type_id = $r->business_type_id;
        $model->category_id = $r->category_id;
        $model->type = $r->type;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->size = $r->size;
        $model->weight = $r->weight;
        $model->color = $r->color;
        $model->grade = $r->grade;
        $model->printed = $r->printed;
        $model->laminated = $r->laminated;
        $model->liner = $r->liner;
        $model->buy_price = $r->buy_price;
        $model->created_by = Auth::id();
        $model->created_at = cur_date_time();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query problem on creating record.");
            }

            DB::commit();
            return redirect('inv/product')->with('success', 'New record created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('inv_product_edit');
        $business_types = BusinessType::get();
        $categories = Category::get();
        $types = type_list();
        $data = Product::find($id);

        $this->model['breadcrumb_title'] = "Product Information";
        $this->model['business_types'] = $business_types;
        $this->model['categories'] = $categories;
        $this->model['types'] = $types;
        $this->model['data'] = $data;
        return view('inv.product.edit', $this->model);
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'business_type_id' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'name' => 'required',
        );

        $messages = array(
            'business_type_id.required' => 'Please select business type.',
            'category_id.required' => 'Please select categoty.',
            'type.required' => 'Please select product type.',
            'name.required' => 'Name required.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Product::find($id);
        $model->business_type_id = $r->business_type_id;
        $model->category_id = $r->category_id;
        $model->type = $r->type;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->size = $r->size;
        $model->weight = $r->weight;
        $model->color = $r->color;
        $model->grade = $r->grade;
        $model->printed = $r->printed;
        $model->laminated = $r->laminated;
        $model->liner = $r->liner;
        $model->buy_price = $r->buy_price;
        $model->modified_by = Auth::id();
        $model->modified_at = cur_date_time();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query problem on updating record.");
            }

            DB::commit();
            return redirect('inv/product')->with('success', 'Record updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show() {
        $model = new Product();
        $query = $model->where('is_deleted', 0);
        $dataset = $query->paginate($this->getSettings()->pagesize);

        $business_types = BusinessType::get();
        $categories = Category::get();
        $types = type_list();
        $stockModel = new Stock();

        $this->model['breadcrumb_title'] = "Product Stock";
        $this->model['dataset'] = $dataset;
        $this->model['business_types'] = $business_types;
        $this->model['categories'] = $categories;
        $this->model['types'] = $types;
        $this->model['stockModel'] = $stockModel;
        return view('inv.product.stock', $this->model);
    }

    public function ledger() {
        $_initituteID = institute_id();
        $business_types = BusinessType::get();
        $subhead_list = SubHead::where([['institute_id', $_initituteID], ['is_deleted', 0]])->whereIn('head_id', [PATWARY_HEAD_DEBTORS, PATWARY_HEAD_CREDITORS])->get();
        $startDate = Stock::get_date_val();
        $endDate = Stock::get_date_val(true);

        $this->model['breadcrumb_title'] = "Product Ledger";
        $this->model['business_types'] = $business_types;
        $this->model['subhead_list'] = $subhead_list;
        $this->model['startDate'] = $startDate;
        $this->model['endDate'] = $endDate;
        return view('inv.product.ledger', $this->model);
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = $r->input('item_count');
        $_business_type = $r->input('business_type_id');
        $_category = $r->input('category_id');
        $_type = $r->input('type');
        $search = $r->input('srch');

        $query = Product::query();
        $query->where('is_deleted', 0);
        if (!empty($_business_type)) {
            $query->where('business_type_id', $_business_type);
        }
        if (!empty($_category)) {
            $query->where('category_id', $_category);
        }
        if (!empty($_type)) {
            $query->where('type', 'like', '%' . trim($_type) . '%');
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . trim($search) . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($item_count);
        return view('inv.product._list', compact('dataset'));
    }

    public function search_stock(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = $r->input('item_count');
        $_business_type = $r->input('business_type_id');
        $_category = $r->input('category_id');
        $_type = $r->input('type');
        $search = $r->input('srch');

        $query = Product::query();
        $query->where('is_deleted', 0);
        if (!empty($_business_type)) {
            $query->where('business_type_id', $_business_type);
        }
        if (!empty($_category)) {
            $query->where('category_id', $_category);
        }
        if (!empty($_type)) {
            $query->where('type', 'like', '%' . trim($_type) . '%');
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . trim($search) . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($item_count);

        $stockModel = new Stock();
        return view('inv.product._stock', compact('dataset', 'stockModel'));
    }

    public function search_ledger(Request $r) {
        //$this->is_ajax_request(Request $request);
        $_business_typeId = $r->input('business_type_id');
        $_categoryId = $r->input('category_id');
        $_productId = $r->input('product_id');
        $_subheadId = $r->input('subhead_id');
        $_particularId = $r->input('particular_id');
        $fromDate = $r->input('from_date');
        $toDate = $r->input('end_date');

        if (empty($_productId)) {
            throw new Exception("Please select a product.");
        }

        if (empty($_particularId)) {
            throw new Exception("Please select a particulart.");
        }

        $query = Stock::where('is_deleted', 0);
        $query->whereIn('stock_type', [STOCK_PURCHASE, STOCK_SALE]);
        if (!empty($_productId)) {
            $query->where('product_id', $_productId);
        }
        if (!empty($_particularId)) {
            $query->where('particular_id', $_particularId);
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $from_date = date_ymd($fromDate);
            $end_date = date_ymd($toDate);
            $query->whereBetween('invoice_date', [$from_date, $end_date]);
        }
        $query->orderBy("invoice_date", "ASC");
        //$query->groupBy('invoice_date');
        //$dataset = $query->paginate(100);
        $dataset = $query->get();

        $product = Product::find($_productId);
        $particular = Particular::find($_particularId);
        $printHeader = "Ledger - {$particular->name} - {$product->name}";
        return view('inv.product._ledger', compact('product', 'particular', 'printHeader', 'dataset', 'fromDate', 'toDate'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Product::find($id);
                $data->is_deleted = 1;
                $data->deleted_by = Auth::id();
                $data->deleted_at = cur_date_time();
                if (!$data->save()) {
                    throw new Exception("Error while deleting records.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record has been deleted successfully.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    // opening stock
    public function form_opening_stock($id) {
        $resp = array();
        $avgPrice = new AvgPrice();

        $_model = new Stock();
        $query = $_model->where('is_deleted', 0);
        $query->where('product_id', $id);
        $query->where('stock_type', STOCK_OPENING);
        $_data = $query->first();

        $resp['productID'] = $id;
        $resp['new'] = true;
        $resp['qty'] = null;
        $resp['avg_price'] = null;

        if (!empty($_data)) {
            $resp['new'] = false;
            $resp['qty'] = $_data->quantity;
            $resp['avg_price'] = $avgPrice->opening_avg_price($id);
        }

        return view('inv.product._form_ostock', compact('resp'));
    }

    public function update_opening_stock(Request $r) {
        $resp = array();
        $_productID = $r->productID;

        $_modelAvgPrice = new AvgPrice();
        $_modelStock = new Stock();

        DB::beginTransaction();
        try {
            $queryStock = $_modelStock->where('is_deleted', 0);
            $queryStock->where('product_id', $_productID);
            $queryStock->where('stock_type', STOCK_OPENING);
            $_stock = $queryStock->first();

            if (!empty($_stock)) {
                $_stock->product_id = $_productID;
                $_stock->invoice_date = date("Y-m-d");
                $_stock->quantity = $r->qty;
                if (!$_stock->save()) {
                    throw new Exception("Error while updating record.");
                }

                $queryAvgprice = $_modelAvgPrice->where('is_deleted', 0);
                $queryAvgprice->where('stock_id', $_stock->id);
                $_avgPrice = $queryAvgprice->first();
                $_avgPrice->stock_id = $_stock->id;
                $_avgPrice->product_id = $_productID;
                $_avgPrice->invoice_date = date("Y-m-d");
                $_avgPrice->quantity = $r->qty;
                $_avgPrice->avg_price = $r->avg_price;
                $_avgPrice->total_price = round(($_avgPrice->quantity * $_avgPrice->avg_price), 2);
                if (!$_avgPrice->save()) {
                    throw new Exception("Error while updating avg price record.");
                }
            } else {
                $_modelStock->stock_type = STOCK_OPENING;
                $_modelStock->product_id = $_productID;
                $_modelStock->invoice_date = date("Y-m-d");
                $_modelStock->quantity = $r->qty;
                if (!$_modelStock->save()) {
                    throw new Exception("Error while saving record.");
                }

                $_stockId = DB::getPdo()->lastInsertId();
                $_modelAvgPrice->stock_id = $_stockId;
                $_modelAvgPrice->product_id = $_productID;
                $_modelAvgPrice->invoice_date = date("Y-m-d");
                $_modelAvgPrice->quantity = $r->qty;
                $_modelAvgPrice->avg_price = $r->avg_price;
                $_modelAvgPrice->total_price = round(($_modelAvgPrice->quantity * $_modelAvgPrice->avg_price), 2);
                if (!$_modelAvgPrice->save()) {
                    throw new Exception("Error while saving avg price record.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record updated successfully.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
