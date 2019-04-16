<?php

namespace App\Http\Controllers\Flour;

use App\Http\Controllers\HomeController;
use Exception;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Flour\PurchaseChallan;
use App\Models\Flour\EmptybagSetting;
use App\Models\Flour\Stock;
use App\Models\SubHead;
use App\Models\Particular;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Auth;

class PurchaseChallanController extends HomeController {

    public function index() {
        $model = new PurchaseChallan();
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        $dataset = $query->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('flour.purchase_challan.index', compact('dataset'));
    }

    public function order_list() {
        check_user_access('production_order');
        $product = new Product();
        $drawer = new Drawer();
        $dataset = PurchaseChallan::get();
        return view('flour.purchase_challan.order_list', compact('dataset', 'product', 'drawer'));
    }

    public function create() {
        $empty_bag_model = EmptybagSetting::where('institute_id', institute_id())->first();
        $empty_bag_weight = !empty($empty_bag_model) ? $empty_bag_model->weight : 1;
        $categories = Category::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $subheads = SubHead::where([['institute_id', PATWARY_STORE], ['head_id', PATWARY_HEAD_CREDITORS]])->get();
        return view('flour.purchase_challan.create', compact('categories', 'subheads', 'empty_bag_weight'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'supplier_subhead' => 'required',
            'supplier_particular' => 'required',
            'category' => 'required',
            'product' => 'required',
            'scale_weight' => 'required',
            'bag_quantity' => 'required',
            'net_weight' => 'required',
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

        $model = new PurchaseChallan();
        $model->date = date_ymd($r->date);
        $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
        $model->challan_no = $r->challan_no;
        $model->slip_no = $r->slip_no;
        $model->truck_no = $r->truck_no;
        $model->truck_rent = $r->net_weight;
        $model->transport_agency = $r->transport_agency;
        $model->comments = $r->comments;
        $model->category_id = $r->category;
        $model->product_id = $r->product;
        $model->supplier_head = $supplier_head;
        $model->supplier_subhead = $r->supplier_subhead;
        $model->supplier_particular = $r->supplier_particular;
        $model->challan_weight = $r->challan_weight;
        $model->scale_weight = $r->scale_weight;
        $model->bag_quantity = $r->bag_quantity;
        $model->empty_bag_weight = $r->empty_bag_weight;
        $model->net_weight = $r->net_weight;
        $model->per_kg_price = $r->per_kg_price;
        $model->total_price = $r->total_price;
        $model->created_by = Auth::id();
        $model->created_at = cur_date_time();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }
            $last_id = DB::getPdo()->lastInsertId();

            $modelStock = new Stock();
            $modelStock->purchase_challan_id = $last_id;
            $modelStock->date = $model->date;
            $modelStock->type = 'in';
            $modelStock->category_id = $model->category_id;
            $modelStock->institute_id = $model->institute_id;
            $modelStock->product_id = $model->product_id;
            $modelStock->weight = $model->net_weight;
            $modelStock->quantity = $model->bag_quantity;
            $modelStock->created_by = $model->created_by;
            $modelStock->_key = uniqueKey();

            if (!$modelStock->save()) {
                throw new Exception("Query Problem on Creating Stocks.");
            }

            DB::commit();
            return redirect('/flour/purchase-challan')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show($id) {
        $data = PurchaseChallan::find($id);
        return view('flour.purchase_challan.details', compact('data'));
    }

    public function edit($id) {
        $empty_bag_model = EmptybagSetting::where('institute_id', institute_id())->first();
        $empty_bag_weight = !empty($empty_bag_model) ? $empty_bag_model->weight : 1;
        $data = PurchaseChallan::find($id);
        $categories = Category::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $products = Product::where('category_id', $data->category_id)->get();
        $subheads = SubHead::where([['institute_id', PATWARY_STORE], ['head_id', PATWARY_HEAD_CREDITORS]])->get();
        $particulars = Particular::where('subhead_id', $data->supplier_subhead)->get();
        return view('flour.purchase_challan.edit', compact('data', 'categories', 'subheads', 'products', 'particulars', 'empty_bag_weight'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'supplier_subhead' => 'required',
            'supplier_particular' => 'required',
            'category' => 'required',
            'product' => 'required',
            'scale_weight' => 'required',
            'bag_quantity' => 'required',
            'net_weight' => 'required',
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
            $model = PurchaseChallan::find($id);
            $model->date = date_ymd($r->date);
            $model->challan_no = $r->challan_no;
            $model->slip_no = $r->slip_no;
            $model->truck_no = $r->truck_no;
            $model->truck_rent = $r->net_weight;
            $model->transport_agency = $r->transport_agency;
            $model->comments = $r->comments;
            $model->category_id = $r->category;
            $model->product_id = $r->product;
            $model->supplier_head = $supplier_head;
            $model->supplier_subhead = $r->supplier_subhead;
            $model->supplier_particular = $r->supplier_particular;
            $model->challan_weight = $r->challan_weight;
            $model->scale_weight = $r->scale_weight;
            $model->bag_quantity = $r->bag_quantity;
            $model->empty_bag_weight = $r->empty_bag_weight;
            $model->net_weight = $r->net_weight;
            $model->per_kg_price = $r->per_kg_price;
            $model->total_price = $r->total_price;
            $model->modified_by = Auth::id();
            $model->modified_at = cur_date_time();

            if (!$model->save()) {
                throw new Exception("Error! while updating Record.");
            }

            $modelStock = $model->stocks;
            $modelStock->date = $model->date;
            $modelStock->category_id = $model->category_id;
            $modelStock->product_id = $model->product_id;
            $modelStock->weight = $model->net_weight;
            $modelStock->quantity = $model->bag_quantity;
            $modelStock->modified_by = $model->modified_by;

            if (!$modelStock->save()) {
                throw new Exception("Query Problem on Creating Stocks.");
            }

            DB::commit();
            return redirect('flour/purchase-challan')->with('success', 'Purchase Challan Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function search(Request $r) {
        //pr($_POST);
        $model = new PurchaseChallan();
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $challan = $r->input('search');
        $product = $r->input('product');

        $query = is_Admin() ? $model->query() : $model->where('institute_id', institute_id());
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($challan)) {
            $query->where('challan_no', $challan);
        }
        if (!empty($product)) {
            $parray = [];
            $pr = Product::where('name', 'like', '%' . $product . '%')->get();
            foreach ($pr as $p) {
                $parray[] = $p->id;
            }
            $query->whereIn('product_id', $parray);
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('flour.purchase_challan._list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = PurchaseChallan::with('stocks')->find($id);
                if (!empty($data->stocks)) {
                    if (!$data->stocks->delete()) {
                        throw new Exception("Error while deleting records from Stocks.");
                    }
                }
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Purchase Challan has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
