<?php

namespace App\Http\Controllers\Rice;

use App\Http\Controllers\HomeController;
use App\Models\Institute;
use Exception;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Rice\Drawer;
use App\Models\Rice\Production;
use App\Models\Rice\ProductionItem;
use App\Models\Rice\Stock;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Auth;

class ProductionController extends HomeController {

    public function index() {
        check_user_access('rice_manage_production');
        $model = new Production();
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        $dataset = $query->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('rice.production.index', compact('dataset', 'insList'));
    }

    public function order_list() {
        check_user_access('rice_manage_production');
        $model = new Production();
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        $dataset = $query->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        $drawer = new Drawer();
        return view('rice.production.order_list', compact('dataset', 'drawer', 'insList'));
    }

    public function create() {
        check_user_access('rice_manage_production');
        $drawers = Drawer::where('institute_id', institute_id())->get();
        $stock = new Stock();
        $products = Product::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', RICEMILL]])->get();
        return view('rice.production.create', compact('products', 'category', 'stock', 'drawers', 'insList'));
    }

    public function store(Request $r) {
        // pr($_POST);
        $resp = [];
        $order = $r->order_no;
        $total_weight = 0;
        $total_quantity = 0;

        DB::beginTransaction();
        try {
            $ord = Production::where('order_no', $order)->first();
            if (!empty($ord)) {
                throw new Exception("Order already exist.");
            }

            $model = new Production();
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
            $model->order_no = $order;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Order.");
            }

            $order_id = DB::getPdo()->lastInsertId();
            if (empty($_POST['product'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            foreach ($_POST['product'] as $key => $value) {
                $_productName = Product::find($value)->name;
                if (empty($_POST['drawer'])) {
                    throw new Exception("No Drawer checked for <b>{$_productName}</b>");
                }
                foreach ($_POST['drawer'][$value] as $key2 => $drawer) {
                    $_drawerName = Drawer::find($drawer)->name;
                    if (empty($_POST['quantity'][$value][$drawer])) {
                        throw new Exception("Please Provide Quantity for <b>{$_productName} ({$_drawerName})</b>.");
                    }
                    if (empty($_POST['weight'][$value][$drawer])) {
                        throw new Exception("Please Provide Weight for <b>{$_productName} ({$_drawerName})</b>.");
                    }
                    $modelPi = new ProductionItem();
                    $modelPi->production_id = $order_id;
                    $modelPi->institute_id = $model->institute_id;
                    $modelPi->drawer_id = $drawer;
                    $modelPi->category_id = $_POST['category_id'][$value];
                    $modelPi->product_id = $_POST['product_id'][$value];
                    $modelPi->net_weight = $_POST['weight'][$value][$drawer];
                    $modelPi->net_quantity = $_POST['quantity'][$value][$drawer];
                    $modelPi->created_by = Auth::id();
                    $modelPi->_key = uniqueKey() . $key;
                    if (!$modelPi->save()) {
                        throw new Exception("Error! while creating Order items.");
                    }
                    $production_item_id = DB::getPdo()->lastInsertId();
                    $modelStock = new Stock();
                    $modelStock->production_id = $order_id;
                    $modelStock->institute_id = $model->institute_id;
                    $modelStock->production_no_id = $production_item_id;
                    $modelStock->category_id = $modelPi->category_id;
                    $modelStock->product_id = $modelPi->product_id;
                    $modelStock->type = 'process';
                    $modelStock->date = $model->date;
                    $modelStock->weight = $modelPi->net_weight;
                    $modelStock->quantity = $modelPi->net_quantity;
                    $modelStock->created_by = $modelPi->created_by;
                    $modelStock->_key = $modelPi->_key;
                    if (!$modelStock->save()) {
                        throw new Exception("Error! while Updating Stock.");
                    }
                    $total_weight += $modelStock->weight;
                    $total_quantity += $modelStock->quantity;
                }
            }
            $model->total_weight = $total_weight;
            $model->total_quantity = $total_quantity;
            if (!$model->save()) {
                throw new Exception("Error! while Saving Order.");
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Production Order has been Created Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function show($id) {
        $data = Production::find($id);
        $drawer = new Drawer();
        $products = new Product();
        $category = new Category();
        return view('rice.production.details', compact('data', 'category', 'products', 'drawer'));
    }

    public function edit($id) {
        $data = Production::find($id);
        $drawers = Drawer::where('institute_id', institute_id())->get();
        $stocks = new Stock();
        $category = new Category();
        $product = new Product();
        return view('rice.production.edit', compact('data', 'stocks', 'category', 'product', 'drawers'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'order_no' => 'required|unique:rice_production,order_no,' . $id,
            'date' => 'required',
        );
        $messages = array(
            'order_no.required' => 'Order no is required',
            'date.required' => 'Please insert date',
        );
        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = Production::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            // $model->order_no = $r->order_no;
            $model->modified_by = Auth::id();
            if (!$model->save()) {
                throw new Exception("Error! while updating Production Order.");
            }
            foreach ($_POST['hid'] as $key => $value) {
                $_productName = Product::find(ProductionItem::find($value)->product_id)->name;
                if (empty($_POST['process_quantity'][$value])) {
                    throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
                }
                if (empty($_POST['process_weight'][$value])) {
                    throw new Exception("Please Provide Net Weight for <b>{$_productName}</b>.");
                }
                if (empty($_POST['drawer'][$value])) {
                    throw new Exception("Please Select a Drawer");
                }

                $modelPi = ProductionItem::find($value);
                $modelPi->drawer_id = $_POST['drawer'][$value];
                $modelPi->net_weight = $_POST['process_weight'][$value];
                $modelPi->net_quantity = $_POST['process_quantity'][$value];
                $modelPi->modified_by = Auth::id();
                if (!$modelPi->save()) {
                    throw new Exception("Error! while updating Production Order items.");
                }
                $modelStock = Stock::where('production_no_id', $value)->first();
                $modelStock->date = $model->date;
                $modelStock->weight = $_POST['process_weight'][$value];
                $modelStock->quantity = $_POST['process_quantity'][$value];
                $modelStock->modified_by = Auth::id();
                if (!$modelStock->save()) {
                    throw new Exception("Error! while updating Stocks.");
                }
            }
            DB::commit();
            return redirect('rice/production')->with('success', 'Production Order Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function confirm($id) {
        $data = Production::find($id);
        DB::beginTransaction();
        try {
            foreach ($data->items as $key => $value) {
                $model = ProductionItem::find($value->id);
                $model->process_status = 1;
                $model->modified_by = Auth::id();
                if (!$model->save()) {
                    throw new Exception("Something Went Wrong. Please Re Submit your request.");
                }
            }
            $data->process_status = 1;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }

            DB::commit();
            return redirect('rice/production')->with('success', 'Production Order Processed Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('rice/production')->with('danger', $e->getMessage());
        }
    }

    public function order_items($id) {
        if (isset($id)) {
            $dataset = ProductionItem::where([['production_id', '=', $id], ['process_status', '=', 1], ['stock_status', '=', 0]])->get();
            $drawer = new Drawer();
            $category = new Category();
            $product = new Product();
            return view('rice.production.item', compact('dataset', 'category', 'product', 'drawer'));
        }
    }

    public function order_complete($id) {
        if (isset($id)) {
            $production_item = ProductionItem::find($id);
            //$products = Product::where([['category_id', $production_item->category_id], ['type', 'Finish']])->get();
            $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', RICEMILL]])->get();
            return view('rice.production.after_production', compact('products', 'production_item'));
        }
    }

    public function search(Request $r) {
        $model = new Production();
        $item_count = $r->input('item_count');
        $search_by = $r->input('search_by');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('order_no', 'like', '%' . $search . '%');
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('rice.production._list', compact('dataset'));
    }

    public function order_list_search(Request $r) {
        $model = new Production();
        $item_count = $r->input('item_count');
        $search_by = $r->input('search_by');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('order_no', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $drawer = new Drawer();
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('rice.production.order_list_search', compact('dataset', 'drawer'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Production::with('items', 'stocks')->find($id);
                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Items.");
                        }
                    }
                }
                if (!empty($data->stocks)) {
                    foreach ($data->stocks as $stock) {
                        if (!$stock->delete()) {
                            throw new Exception("Error while deleting records from Stocks.");
                        }
                    }
                }
                if (!empty($data->production_stocks)) {
                    foreach ($data->production_stocks as $pstock) {

                        if (!empty($pstock->items)) {
                            foreach ($pstock->items as $pitem) {
                                if (!$pitem->delete()) {
                                    throw new Exception("Error while deleting records from Production Stocks Item.");
                                }
                            }
                        }
                        if (!$pstock->delete()) {
                            throw new Exception("Error while deleting records from Production Stocks.");
                        }
                    }
                }
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Production Order has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
