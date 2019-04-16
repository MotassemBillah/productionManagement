<?php

namespace App\Http\Controllers\Flour;

use App\Http\Controllers\HomeController;
use Exception;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Flour\SalesChallan;
use App\Models\Flour\SalesChallanItem;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Transaction;
use App\Models\Flour\Drawer;
use App\Models\Flour\ProductionOrderItem;
use App\Models\Flour\ProductionStockItem;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Auth;

class SalesChallanController extends HomeController {

    public function index() {
        $dataset = SalesChallan::orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('flour.sales_challan.index', compact('dataset'));
    }

    public function details() {
        $dataset = SalesChallanItem::orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('flour.sales_challan.items', compact('dataset'));
    }

    public function create() {
        $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $category = new Category();
        $subheads = SubHead::where([['institute_id', PATWARY_STORE], ['head_id', PATWARY_HEAD_DEBTORS]])->get();
        return view('flour.sales_challan.create', compact('products', 'subheads', 'category'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'supplier_subhead' => 'required',
            'supplier_particular' => 'required',
        );
        $messages = array(
            'category.required' => 'Required',
            'supplier_particular.required' => 'Please select a Supplier.',
            'product.required' => 'Required',
            'scale_weight.required' => 'Required',
            'bag_quantity.required' => 'Required',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if (!empty($r->supplier_subhead)) {
            $supplier_head = SubHead::find($r->supplier_subhead)->head_id;
        } else {
            $supplier_head = NULL;
        }


        $model = new SalesChallan();
        $model->date = date_ymd($r->date);
        $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
        $model->voucher_no = $r->voucher_no;
        $model->challan_no = $r->challan_no;
        $model->supplier_head = $supplier_head;
        $model->supplier_subhead = $r->supplier_subhead;
        $model->supplier_particular = $r->supplier_particular;
        $model->truck_no = $r->truck_no;
        $model->comments = $r->comments;
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (empty($_POST['product'])) {
                throw new Exception("Please select atleast one Product.");
            }
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }
            $last_id = DB::getPdo()->lastInsertId();
            foreach ($_POST['product'] as $key => $value) {
                $_productName = Product::find($value)->name;
                if (empty($_POST['bag_quantity'][$value])) {
                    throw new Exception("Please Provide Bag Quantity for <b>{$_productName}</b>.");
                }
                if (empty($_POST['scale_weight'][$value])) {
                    throw new Exception("Please Provide Scale Weight for <b>{$_productName}</b>.");
                }

                $modelItem = new SalesChallanItem();
                $modelItem->sales_challan_id = $last_id;
                $modelItem->institute_id = $model->institute_id;
                $modelItem->date = $model->date;
                $modelItem->challan_no = $model->challan_no;
                $modelItem->voucher_no = $model->voucher_no;
                $modelItem->supplier_head = $model->supplier_head;
                $modelItem->supplier_subhead = $model->supplier_subhead;
                $modelItem->supplier_particular = $model->supplier_particular;
                $modelItem->category_id = $_POST['category_id'][$value];
                $modelItem->product_id = $_POST['product_id'][$value];
                $modelItem->scale_weight = $_POST['scale_weight'][$value];
                $modelItem->bag_quantity = $_POST['bag_quantity'][$value];
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Sale items.");
                }

                $modelStock = new ProductionStockItem();
                $modelStock->sales_challan_id = $modelItem->sales_challan_id;
                $modelItem->institute_id = $model->institute_id;
                $modelStock->date = $model->date;
                $modelStock->type = 'out';
                $modelStock->category_id = $modelItem->category_id;
                $modelStock->after_production_id = $modelItem->product_id;
                $modelStock->weight = $modelItem->scale_weight;
                $modelStock->quantity = $modelItem->bag_quantity;
                $modelStock->created_by = Auth::id();
                $modelStock->_key = uniqueKey() . $key;

                if (!$modelStock->save()) {
                    throw new Exception("Query Problem on Creating Production Stocks.");
                }
            }

            DB::commit();
            return redirect('/flour/sales-challan')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show($id) {
        $data = SalesChallan::find($id);
        $drawer = new Drawer();
        $products = new Product();
        $category = new Category();
        return view('flour.sales_challan.details', compact('data', 'category', 'products', 'drawer'));
    }

    public function edit($id) {
        $data = SalesChallan::find($id);
        $categories = Category::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $subheads = SubHead::where([['institute_id', PATWARY_STORE], ['head_id', PATWARY_HEAD_DEBTORS]])->get();
        $particulars = Particular::where('subhead_id', $data->supplier_subhead)->get();
        return view('flour.sales_challan.edit', compact('data', 'categories', 'products', 'subheads', 'particulars'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'supplier_subhead' => 'required',
            'supplier_particular' => 'required',
        );
        $messages = array(
            'category.required' => 'Required',
            'supplier_particular.required' => 'Please select a Supplier.',
            'product.required' => 'Required',
            'scale_weight.required' => 'Required',
            'bag_quantity.required' => 'Required',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if (!empty($r->supplier_subhead)) {
            $supplier_head = SubHead::find($r->supplier_subhead)->head_id;
        } else {
            $supplier_head = NULL;
        }

        DB::beginTransaction();
        try {
            if (empty($_POST['product'])) {
                throw new Exception("Please Select at least One Product!");
            }

            $model = SalesChallan::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->voucher_no = $r->voucher_no;
            $model->challan_no = $r->challan_no;
            $model->supplier_head = $supplier_head;
            $model->supplier_subhead = $r->supplier_subhead;
            $model->supplier_particular = $r->supplier_particular;
            $model->truck_no = $r->truck_no;
            $model->comments = $r->comments;
            $model->modified_by = Auth::id();

            if (!$model->save()) {
                throw new Exception("Error! while Updating Records.");
            }

            $existItem = SalesChallanItem::where('sales_challan_id', $id)->delete();
            $exisStock = ProductionStockItem::where('sales_challan_id', $id)->delete();

            foreach ($_POST['product'] as $key => $value) {
                $_productName = Product::find($_POST['product_id'][$value])->name;
                if (empty($_POST['scale_weight'][$value])) {
                    throw new Exception("Please Provide Scale Weight for <b>{$_productName}</b>.");
                }
                if (empty($_POST['bag_quantity'][$value])) {
                    throw new Exception("Please Provide Bag Quantity.");
                }

                $modelItem = new SalesChallanItem();
                $modelItem->sales_challan_id = $id;
                $modelItem->date = $model->date;
                $modelItem->challan_no = $model->challan_no;
                $modelItem->voucher_no = $model->voucher_no;
                $modelItem->supplier_head = $model->supplier_head;
                $modelItem->supplier_subhead = $model->supplier_subhead;
                $modelItem->supplier_particular = $model->supplier_particular;
                $modelItem->category_id = $_POST['category_id'][$value];
                $modelItem->product_id = $_POST['product_id'][$value];
                $modelItem->scale_weight = $_POST['scale_weight'][$value];
                $modelItem->bag_quantity = $_POST['bag_quantity'][$value];
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Sale items.");
                }

                $modelStock = new ProductionStockItem();
                $modelStock->sales_challan_id = $modelItem->sales_challan_id;
                $modelStock->date = $model->date;
                $modelStock->type = 'out';
                $modelStock->category_id = $modelItem->category_id;
                $modelStock->after_production_id = $modelItem->product_id;
                $modelStock->weight = $modelItem->scale_weight;
                $modelStock->quantity = $modelItem->bag_quantity;
                $modelStock->modified_by = Auth::id();

                if (!$modelStock->save()) {
                    throw new Exception("Query Problem on Creating Production Stocks.");
                }
            }


            DB::commit();
            return redirect('flour/sales-challan')->with('success', 'Sale Challan Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $challan = $r->input('challan_no');
        $voucher = $r->input('voucher_no');
        $supplier = $r->input('supplier');

        $query = SalesChallan::query();
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($challan)) {
            $query->where('challan_no', $challan);
        }
        if (!empty($voucher)) {
            $query->where('voucher_no', $voucher);
        }
        if (!empty($supplier)) {
            $headarr = [];
            $dr_head = Particular::where('name', 'like', '%' . $supplier . '%')->get();
            foreach ($dr_head as $head) {
                $headarr[] = $head->id;
            }
            $query->whereIn('supplier_subhead', $headarr);
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('flour.sales_challan._list', compact('dataset'));
    }

    public function search_items(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $challan = $r->input('challan_no');
        $voucher = $r->input('voucher_no');
        $supplier = $r->input('supplier');

        $query = SalesChallanItem::query();
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($challan)) {
            $query->where('challan_no', $challan);
        }
        if (!empty($voucher)) {
            $query->where('voucher_no', $voucher);
        }
        if (!empty($supplier)) {
            $headarr = [];
            $dr_head = Particular::where('name', 'like', '%' . $supplier . '%')->get();
            foreach ($dr_head as $head) {
                $headarr[] = $head->id;
            }
            $query->whereIn('supplier_subhead', $headarr);
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('flour.sales_challan.item_list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = SalesChallan::with('items', 'production_stocks')->find($id);
                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Items.");
                        }
                    }
                }
                if (!empty($data->production_stocks)) {
                    foreach ($data->production_stocks as $stock) {
                        if (!$stock->delete()) {
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
            $resp['message'] = 'Sales Challan has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
