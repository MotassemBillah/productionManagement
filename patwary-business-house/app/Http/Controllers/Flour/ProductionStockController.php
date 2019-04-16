<?php

namespace App\Http\Controllers\Flour;

use App\Http\Controllers\HomeController;
use Auth;
use DB;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\AfterProduction;
use App\Models\Flour\ProductionItem;
use App\Models\Flour\Drawer;
use App\Models\Flour\ProductionStock;
use App\Models\Flour\ProductionStockItem;
use Validator;
use Exception;
use Illuminate\Http\Request;

class ProductionStockController extends HomeController {

    public function index() {
        check_user_access('flour_production_stocks');
        $model = new ProductionStock;
        $drawer = new Drawer;
        $dataset = $model->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('flour.production_stocks.index', compact('dataset', 'drawer'));
    }

    public function create() {
        check_user_access('flour_production_stocks');
        $production_order = ProductionItem::where([['process_status', '=', 1], ['stock_status', '=', 0],])->groupBy('production_id')->get();
        return view('flour.production_stocks.create', compact('production_order'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $resp = [];
        $input = $r->all();
        $drawers = [];
        $products = [];
        $rule = array(
            'date' => 'required',
            'production_stocks_no' => 'required',
        );
        $messages = array(
            'date.required' => 'Please insert date',
            'production_stocks_no.required' => 'Production Stocks No Required',
        );
        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($_POST['item'] as $item) {
                $pmodel = ProductionItem::find($item);
                $pmodel->stock_status = 1;
                $pmodel->modified_by = Auth::id();
                $drawers[] = $pmodel->drawer_id;
                $products[] = $pmodel->product_id;
                if (!$pmodel->save()) {
                    throw new Exception("Error! while Updating Production Item.");
                }
            }
//            if (count(array_count_values($products)) !== 1) {
//                throw new Exception("Warning! You can not process different Product at a time.");
//            }

            if (array_sum($_POST['quantity']) < 1) {
                throw new Exception("Warning! You must provide at least one Quantity.");
            }
            $product_id = $pmodel->product_id;
            $category_id = $pmodel->category_id;
            $order_id = $pmodel->order->order_no;
            $drawer_id = json_encode($drawers);
            $item_id = json_encode($_POST['item']);

            if (empty($_POST['after_production_id'])) {
                throw new Exception("Please check your given information.");
            }

            $model = new ProductionStock();
            $model->date = date_ymd($r->date);
            $model->production_id = $r->production_id;
            $model->production_item_id = $item_id;
            $model->drawer_id = $drawer_id;
            $model->order_no = $order_id;
            $model->production_stocks_no = $r->production_stocks_no;
            $model->weight = '';
            $model->quantity = '';
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Production Stock.");
            }
            $last_id = DB::getPdo()->lastInsertId();

            foreach ($_POST['after_production_id'] as $key => $value) {
                if (!empty($_POST['after_production_id'][$key])) {
                    //$_productName = Product::find($value)->name;
//                    if (empty($_POST['quantity'][$value])) {
//                        throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
//                    }
//                   
//                    if (empty($_POST['per_qty_weight'][$value])) {
//                        throw new Exception("Please Provide Bag Weight for <b>{$_productName}</b>.");
//                    }
//                    if (empty($_POST['net_weight'][$value])) {
//                        throw new Exception("Please Provide Weight for <b>{$_productName}</b>.");
//                    }

                    $modelItem = new ProductionStockItem();
                    $modelItem->date = date_ymd($r->date);
                    $modelItem->production_stocks_id = $last_id;
                    $modelItem->production_id = $r->production_id;
                    $modelItem->production_item_id = $item_id;
                    $modelItem->drawer_id = $drawer_id;
                    $modelItem->category_id = $category_id;
                    $modelItem->product_id = $product_id;
                    $modelItem->order_no = $order_id;
                    $modelItem->production_stocks_no = $r->production_stocks_no;
                    $modelItem->type = 'in';
                    $modelItem->after_production_id = $value;
                    $modelItem->weight = $_POST['net_weight'][$value];
                    $modelItem->quantity = $_POST['quantity'][$value];
                    $modelItem->per_qty_weight = $_POST['per_qty_weight'][$value];
                    $modelItem->created_by = Auth::id();
                    if (!$modelItem->save()) {
                        throw new Exception("Error! while creating Production Stock Item.");
                    }
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Production Stock has been Inserted Successfully.';
            $resp['url'] = url('flour/production-stocks');
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function show($id) {
        $data = ProductionStock::find($id);
        $drawer = new Drawer();
        return view('flour.production_stocks.view', compact('data', 'drawer'));
    }

    public function edit($id) {
        $data = ProductionStock::find($id);
        $drawer = new Drawer();
        $drawer_info = '';
        $draws = json_decode($data->drawer_id);
        if (is_array($draws)) {
            foreach ($draws as $_key => $dr) {
                $drName = $drawer->find($dr)->name;
                if ($_key == (count($draws) - 1)) {
                    $drawer_info .= $drName;
                } else {
                    $drawer_info .= $drName . ", ";
                }
            }
        }

        return view('flour.production_stocks.edit', compact('data', 'drawer_info'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $drawers = [];
        $products = [];
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
            $model = ProductionStock::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->modified_by = Auth::id();
            if (!$model->save()) {
                throw new Exception("Error! while updating Production Stocks.");
            }
            if (array_sum($_POST['quantity']) < 1) {
                throw new Exception("Warning! You must provide at least one Quantity.");
            }
            foreach ($_POST['hid'] as $key => $value) {
                $modelItem = ProductionStockItem::find($value);
                $modelItem->weight = $_POST['net_weight'][$value];
                $modelItem->quantity = $_POST['quantity'][$value];
                $modelItem->modified_by = Auth::id();
                if (!$modelItem->save()) {
                    throw new Exception("Error! while updating Production Stocks items.");
                }
            }
            DB::commit();
            return redirect('flour/production-stocks')->with('success', 'Production Stocks Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function stocks() {
        check_user_access('flour_production_stocks');
        $dataset = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $categories = Category::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $stock = new ProductionStockItem();
        return view('flour.production_stocks.stocks', compact('dataset', 'categories', 'stock'));
    }

    public function details() {
        //check_user_access('production_order');
        $product = new Product();
        $drawer = new Drawer();
        $dataset = ProductionStockItem::where('type', 'in')->groupBy('order_no')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('flour.production_stocks.details', compact('dataset', 'product', 'drawer'));
    }

    // Ajax Functions

    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = ProductionStock::query();
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search)) {
            $query->where('production_stocks_no', 'like', '%' . $search . '%');
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        $drawer = new Drawer;
        return view('flour.production_stocks._list', compact('dataset', 'drawer'));
    }

    public function stocks_search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', FLOURMILL]]);
        if (!empty($category)) {
            $query->where('category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        if (!empty($search)) {
            $productarr = [];
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
            foreach ($products as $pro) {
                $productarr[] = $pro->id;
            }
            $query->whereIn('id', $productarr);
        }
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new Category();
        $product = new Product();
        $stock = new ProductionStockItem();
        return view('flour.production_stocks.stocks_list', compact('dataset', 'category', 'product', 'stock'));
    }

    public function details_search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = ProductionStockItem::where('type', 'in');
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search)) {
            $query->where('order_no', 'like', '%' . $search . '%');
        }
        $product = new Product();
        $drawer = new Drawer();
        $dataset = $query->groupBy('order_no')->orderBy('date', 'DESC')->paginate($item_count);
        return view('flour.production_stocks.details_search', compact('dataset', 'product', 'drawer'));
    }

}
