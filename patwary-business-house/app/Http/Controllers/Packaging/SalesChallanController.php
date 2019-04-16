<?php

namespace App\Http\Controllers\Packaging;

use App\Http\Controllers\HomeController;
use Exception;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Packaging\SalesChallan;
use App\Models\Packaging\SalesChallanItem;
use App\Models\SubHead;
use App\Models\Particular;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Auth;

class SalesChallanController extends HomeController {

    public function index() {
        $dataset = SalesChallan::where('type', 'out')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('packaging.sales_challan.index', compact('dataset'));
    }

    public function details() {
        $dataset = SalesChallanItem::where('type', 'out')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('packaging.sales_challan.items', compact('dataset'));
    }

    public function create() {
        $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', PACKAGING]])->get();
        $category = new Category();
        $subheads = SubHead::where([['institute_id', PATWARY_STORE], ['head_id', PATWARY_HEAD_DEBTORS]])->get();
        return view('packaging.sales_challan.create', compact('products', 'subheads', 'category'));
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
        $model->order_no = $r->order_no;
        $model->challan_no = $r->challan_no;
        $model->truck_no = $r->truck_no;
        $model->transport_info = $r->transport_info;
        $model->type = 'out';
        $model->supplier_head = $supplier_head;
        $model->supplier_subhead = $r->supplier_subhead;
        $model->supplier_particular = $r->supplier_particular;
        $model->total_quantity = array_sum($_POST['bag_quantity']);
        $model->total_price = array_sum($_POST['total_price']);
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

                $modelItem = new SalesChallanItem();
                $modelItem->sales_challan_id = $last_id;
                $modelItem->date = $model->date;
                $modelItem->order_no = $model->order_no;
                $modelItem->challan_no = $model->challan_no;
                $modelItem->type = $model->type;
                $modelItem->supplier_head = $model->supplier_head;
                $modelItem->supplier_subhead = $model->supplier_subhead;
                $modelItem->supplier_particular = $model->supplier_particular;
                $modelItem->category_id = $_POST['category_id'][$value];
                $modelItem->product_id = $_POST['product_id'][$value];
                $modelItem->quantity = $_POST['bag_quantity'][$value];
                $modelItem->per_qty_price = $_POST['per_qty_price'][$value];
                $modelItem->total_price = $_POST['total_price'][$value];
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Sale items.");
                }
            }

            DB::commit();
            return redirect('/packaging/sales-challan')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show($id) {
        $data = SalesChallan::find($id);
        return view('packaging.sales_challan.details', compact('data'));
    }

    public function edit($id) {
        $data = SalesChallan::find($id);
        $categories = Category::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', PACKAGING]])->get();
        $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', PACKAGING]])->get();
        $subheads = SubHead::where([['institute_id', PATWARY_STORE], ['head_id', PATWARY_HEAD_DEBTORS]])->get();
        $particulars = Particular::where('subhead_id', $data->supplier_subhead)->get();
        return view('packaging.sales_challan.edit', compact('data', 'categories', 'products', 'subheads', 'particulars'));
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
            $model->date = date_ymd($r->date);
            $model->order_no = $r->order_no;
            $model->challan_no = $r->challan_no;
            $model->truck_no = $r->truck_no;
            $model->transport_info = $r->transport_info;
            $model->supplier_head = $supplier_head;
            $model->supplier_subhead = $r->supplier_subhead;
            $model->supplier_particular = $r->supplier_particular;
            $model->total_quantity = array_sum($_POST['bag_quantity']);
            $model->total_price = array_sum($_POST['total_price']);
            $model->modified_by = Auth::id();

            if (!$model->save()) {
                throw new Exception("Error! while Updating Records.");
            }

            $existItem = SalesChallanItem::where('sales_challan_id', $id)->delete();

            foreach ($_POST['product'] as $key => $value) {
                $_productName = Product::find($_POST['product_id'][$value])->name;
                if (empty($_POST['bag_quantity'][$value])) {
                    throw new Exception("Please Provide Bag Quantity.");
                }

                $modelItem = new SalesChallanItem();
                $modelItem->sales_challan_id = $id;
                $modelItem->date = $model->date;
                $modelItem->challan_no = $model->challan_no;
                $modelItem->order_no = $model->order_no;
                $modelItem->type = $model->type;
                $modelItem->supplier_head = $model->supplier_head;
                $modelItem->supplier_subhead = $model->supplier_subhead;
                $modelItem->supplier_particular = $model->supplier_particular;
                $modelItem->category_id = $_POST['category_id'][$value];
                $modelItem->product_id = $_POST['product_id'][$value];
                $modelItem->quantity = $_POST['bag_quantity'][$value];
                $modelItem->per_qty_price = $_POST['per_qty_price'][$value];
                $modelItem->total_price = $_POST['total_price'][$value];
                if (!$modelItem->save()) {
                    throw new Exception("Error! while creating Sale items.");
                }
            }


            DB::commit();
            return redirect('packaging/sales-challan')->with('success', 'Sales Challan Updated Successfully.');
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
        $order = $r->input('order_no');
        $supplier = $r->input('supplier');

        $query = SalesChallan::where('type', 'out');
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($challan)) {
            $query->where('challan_no', $challan);
        }
        if (!empty($order)) {
            $query->where('order_no', $order);
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
        return view('packaging.sales_challan._list', compact('dataset'));
    }

    public function search_items(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $challan = $r->input('challan_no');
        $order = $r->input('order_no');
        $supplier = $r->input('supplier');

        $query = SalesChallanItem::query();
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($challan)) {
            $query->where('challan_no', $challan);
        }
        if (!empty($order)) {
            $query->where('order_no', $order);
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
        return view('packaging.sales_challan.item_list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = SalesChallan::with('items')->find($id);
                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Items.");
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
