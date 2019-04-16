<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Category;
use App\AfterProduction;
use App\Product;
use App\Weight;
use App\WeightItem;
use App\Models\Transaction;
use App\ProductionStock;
use App\ProductionStockItem;
use Validator;
use Illuminate\Http\Request;
use DB;
use Session;
use Auth;

class SalesController extends HomeController {

    public function index() {
        check_user_access('manage_sales');
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = Weight::where('weight_type', 'out')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('Admin.sales.index', compact('dataset', 'subhead', 'particular'));
    }

    public function create() {
        check_user_access('manage_sales');
        $heads = SubHead::where('head_id', HEAD_DEBTORS)->get();
        $category = new Category();
        $products = AfterProduction::get();
        $stock = new ProductionStockItem();
        return view('Admin.sales.create', compact('products', 'category', 'heads', 'stock'));
    }

    public function store(Request $r) {
        $resp = [];
        $invoice = $r->invoice_no;

        DB::beginTransaction();
        try {
            $inv = Weight::where('invoice_no', $invoice)->first();
            if (!empty($inv)) {
                throw new Exception("Invoice already exist.");
            }
            if (empty($r->head)) {
                throw new Exception("You Must Select a Head.");
            }

            $model = new Weight();
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->invoice_no = $r->invoice_no;
            $model->challan_no = $r->challan_no;
            $model->weight_type = 'out';
            $model->head_id = $r->head;
            $model->subhead_id = $r->subhead;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Sale.");
            }

            $weight_id = DB::getPdo()->lastInsertId();

            if (empty($_POST['product'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            $total_price = 0;
            $total_weight = 0;
            $total_quantity = 0;

            if (!empty($_POST['product'])) {
                foreach ($_POST['product'] as $key => $value) {
                    if (!empty($_POST['product'][$key])) {
                        $_productName = AfterProduction::find($value)->name;
                        if (empty($_POST['quantity'][$value])) {
                            throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
                        }
                        if (empty($_POST['net_weight'][$value])) {
                            throw new Exception("Please Provide Net Weight for <b>{$_productName}</b>.");
                        }

                        if (empty($_POST['per_bag_price'][$value])) {
                            throw new Exception("Please Provide Per Bag Price.");
                        }

                        $modelWi = new WeightItem();
                        $modelWi->weight_id = $weight_id;
                        $modelWi->weight_type = $model->weight_type;
                        $modelWi->head_id = $model->head_id;
                        $modelWi->subhead_id = $model->subhead_id;
                        $modelWi->date = $model->date;
                        $modelWi->category_id = $_POST['category_id'][$value];
                        $modelWi->after_production_id = $_POST['product_id'][$value];
                        $modelWi->weight = $_POST['net_weight'][$value];
                        $modelWi->quantity = $_POST['quantity'][$value];
                        $modelWi->per_bag_price = $_POST['per_bag_price'][$value];
                        $modelWi->net_price = $_POST['net_price'][$value];
                        $modelWi->created_by = Auth::id();
                        $modelWi->_key = uniqueKey() . $key;
                        $total_quantity += $_POST['quantity'][$value];
                        $total_weight += $_POST['net_weight'][$value];
                        $total_price += $_POST['net_price'][$value];
                        if (!$modelWi->save()) {
                            throw new Exception("Error! while creating Sale items.");
                        }
                    }
                }
            }

            $model->quantity = $total_quantity;
            $model->weight = $total_weight;
            $model->invoice_amount = $total_price;
            $model->save();

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Product has been Sales Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    public function show($id) {
        $data = Weight::find($id);
        return view('Admin.sales.details', compact('data'));
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Weight::find($id);
        $heads = SubHead::where('head_id', HEAD_DEBTORS)->get();
        $subheads = new Particular();
        $category = new Category();
        $stock = new ProductionStockItem();
        $products = new AfterProduction();
        return view('Admin.sales.edit', compact('data', 'heads', 'subheads', 'category', 'products', 'stock'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'invoice_no' => 'required|unique:weights,invoice_no,' . $id,
            'head' => 'required',
        );

        $messages = array(
            'invoice_no.required' => 'Please insert invoice no',
            'head.required' => 'You Must select a head',
        );

        $valid = Validator::make($input, $rule, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = Weight::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->invoice_no = $r->invoice_no;
            $model->challan_no = $r->challan_no;
            $model->weight_type = 'out';
            $model->head_id = $r->head;
            $model->subhead_id = $r->subhead;
            $model->modified_by = Auth::id();
            if (!$model->save()) {
                throw new Exception("Error! while updating Sale.");
            }

            $total_price = 0;
            $total_weight = 0;
            $total_quantity = 0;

            foreach ($_POST['hid'] as $key => $value) {
                if (!empty($_POST['hid'][$key])) {
                    if (empty($_POST['quantity'][$value])) {
                        throw new Exception("Please Provide Quantity");
                    }
                    if (empty($_POST['net_weight'][$value])) {
                        throw new Exception("Please Provide Net Weight");
                    }

                    if (empty($_POST['per_bag_price'][$value])) {
                        throw new Exception("Please Provide Per Bag Price.");
                    }

                    $modelWi = WeightItem::find($value);
                    $modelWi->head_id = $model->head_id;
                    $modelWi->subhead_id = $model->subhead_id;
                    $modelWi->date = $model->date;
                    $modelWi->weight = $_POST['net_weight'][$value];
                    $modelWi->quantity = $_POST['quantity'][$value];
                    $modelWi->per_bag_price = $_POST['per_bag_price'][$value];
                    $modelWi->net_price = $_POST['net_price'][$value];
                    $modelWi->modified_by = Auth::id();
                    $total_quantity += $_POST['quantity'][$value];
                    $total_weight += $_POST['net_weight'][$value];
                    $total_price += $_POST['net_price'][$value];
                    if (!$modelWi->save()) {
                        throw new Exception("Error! while updating Sale items.");
                    }
                }
            }
            $model->quantity = $total_quantity;
            $model->weight = $total_weight;
            $model->invoice_amount = $total_price;
            $model->save();
            DB::commit();
            return redirect('sales')->with('success', 'Sales Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function confirm($id) {
//pr($id);
        $data = Weight::find($id);
        DB::beginTransaction();
        try {
            foreach ($data->items as $key => $value) {
                $modelStock = new ProductionStockItem();
                $modelStock->invoice_no = $data->invoice_no;
                $modelStock->weight_id = $data->id;
                $modelStock->date = $data->date;
                $modelStock->type = 'out';
                $modelStock->category_id = $value->category_id;
                $modelStock->after_production_id = $value->after_production_id;
                $modelStock->weight = $value->weight;
                $modelStock->quantity = $value->quantity;
                $modelStock->created_by = Auth::id();
                $modelStock->_key = uniqueKey() . $key;

                if (!$modelStock->save()) {
                    throw new Exception("Query Problem on Creating Production Stocks.");
                }
            }

            $data->process_status = 1;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }

            $totalSum = $data->invoice_amount;
            $transaction = new Transaction();

            $transaction->sale_id = $data->id;
            $transaction->type = 'C';
            $transaction->voucher_type = SALES_VOUCHER;
            $transaction->payment_method = PAYMENT_NO;
            $transaction->pay_date = $modelStock->date;
            $transaction->dr_head_id = HEAD_DEBTORS;
            $transaction->dr_subhead_id = $data->head_id;
            $transaction->dr_particular_id = $data->subhead_id;
            $transaction->cr_head_id = HEAD_SALES;
            $transaction->cr_subhead_id = NULL;
            $transaction->cr_particular_id = NULL;
            $transaction->by_whom = Auth::user()->name;
            $transaction->description = "Credit Sale";
            $transaction->debit = $totalSum;
            $transaction->credit = $totalSum;
            $transaction->amount = $totalSum;
            $transaction->note = $transaction->description;
            $transaction->created_by = Auth::id();
            $transaction->_key = uniqueKey();
            if (!$transaction->save()) {
                throw new Exception("Error while saving data in Transaction.");
            }

            DB::commit();
            return redirect('sales')->with('success', 'Sales Order Processed Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('sales')->with('danger', $e->getMessage());
        }
    }

    public function reset($id) {
        $data = Weight::find($id);
        DB::beginTransaction();
        try {

            if (!empty($data->production_stocks)) {
                foreach ($data->production_stocks as $stock) {
                    if (!$stock->delete()) {
                        throw new Exception("Error while deleting records from Production Stocks.");
                    }
                }
            }

            if (!empty($data->sale_transaction)) {
                foreach ($data->sale_transaction as $transaction) {
                    if (!$transaction->delete()) {
                        throw new Exception("Error while deleting records from Transaction.");
                    }
                }
            }

            $data->process_status = 0;
            $data->payment_status = 0;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }

            DB::commit();
            return redirect('sales')->with('success', 'Sales Order Reset Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('sales')->with('danger', $e->getMessage());
        }
    }

    public function payment_form($id) {
        $model = Weight::find($id);
        $subhead = new SubHead();
        $transaction = new Transaction();
        $payment_info = $transaction->where([['sale_id', $id], ['is_dbl', 1]])->first();
        $payment = !empty($payment_info) ? $payment_info : $transaction;
        $particular = new Particular();
        return view('Admin.sales.payment_form', compact('model', 'subhead', 'payment', 'particular'));
    }

    public function payment_update(Request $r) {
        //pr($_POST);
        $response = array();
        $sale_id = $r->sale_id;
        $date = $r->transaction_date;
        $amount = $r->amount;

        DB::beginTransaction();
        try {
            if (empty($amount)) {
                throw new Exception("Amount must not be empty");
            }

            $mSubhead = new SubHead();
            $cr_subhead = $r->frm_subhead;

            if (empty($cr_subhead)) {
                throw new Exception("Please select from head");
            }

            $cr_head = $mSubhead->find($cr_subhead)->head_id;
            $cr_particular = $r->frm_particular;
            $dr_subhead = $r->to_subhead;

            if (empty($dr_subhead)) {
                throw new Exception("Please select To head");
            }

            $dr_head = $mSubhead->find($dr_subhead)->head_id;
            $dr_particular = $r->to_particular;



            $_data = Weight::find($sale_id);

            if ($amount > $_data->invoice_amount) {
                throw new Exception("Amount must be less than Invoice Amount!");
            }

            $_data->paid_amount = $amount;
            $_data->payment_status = 1;
            if ($amount < $_data->invoice_amount) {
                $_data->due_amount = doubleval($_data->invoice_amount - $amount);
            } else {
                $_data->due_amount = NULL;
            }
            if (!$_data->save()) {
                throw new Exception("Error while saving data.");
            }

            $_modelTransaction = new Transaction();

            $tdata = $_modelTransaction->where([['sale_id', $sale_id], ['is_dbl', 1]])->first();
            if (!empty($tdata)) {
                if (!$tdata->delete()) {
                    throw new Exception("Error! while deleting Previous Transaction.");
                }
            }

            $_modelTransaction->sale_id = $sale_id;
            $_modelTransaction->type = 'D';
            $_modelTransaction->voucher_type = RECEIVE_VOUCHER;
            $_modelTransaction->pay_date = date_ymd($date);
            $_modelTransaction->dr_head_id = $dr_head;
            $_modelTransaction->dr_subhead_id = $dr_subhead;
            $_modelTransaction->dr_particular_id = $dr_particular;
            $_modelTransaction->cr_head_id = $cr_head;
            $_modelTransaction->cr_subhead_id = $cr_subhead;
            $_modelTransaction->cr_particular_id = $cr_particular;
            $_modelTransaction->by_whom = $r->by_whom;
            $_modelTransaction->description = $r->description;
            $_modelTransaction->debit = $amount;
            $_modelTransaction->credit = $amount;
            $_modelTransaction->amount = $amount;
            $_modelTransaction->note = $r->description;
            $_modelTransaction->is_dbl = 1;
            $_modelTransaction->created_by = Auth::id();
            $_modelTransaction->_key = uniqueKey();

            if (!$_modelTransaction->save()) {
                throw new Exception("Error while saving data.");
            }


            DB::commit();
            $response['success'] = true;
            $response['message'] = "Record saved successfully. Redirecting.....";
        } catch (Exception $e) {
            DB::rollback();
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function sales_ledger() {
        $product = new AfterProduction();
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = WeightItem::where('weight_type', 'out')->paginate($this->getSettings()->pagesize);
        return view('Admin.sales.sales_ledger', compact('dataset', 'subhead', 'particular', 'product'));
    }

    public function gatepass($id) {
        $data = Weight::find($id);
        return view('Admin.sales.gatepass', compact('data'));
    }

// Ajax Functions
    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $order_type = 'out';
        $search_by = $r->input('search_by');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = Weight::where('weight_type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                $query->where('weight_type', '=', $order_type);
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('invoice_no', 'like', '%' . $search . '%');
        }
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = $query->paginate($item_count);
        return view('Admin.sales._list', compact('dataset', 'subhead', 'particular'));
    }

    public function sales_ledger_search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $order_type = 'out';
        $search_by_customer = $r->input('search_by_customer');
        $search_by_product = $r->input('search_by_product');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');

        $query = WeightItem::where('weight_type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by_customer)) {
            $query->where('subhead_id', 'like', '%' . $search_by_customer . '%');
        }
        if (!empty($search_by_product)) {
            $query->where('after_production_id', 'like', '%' . $search_by_product . '%');
        }
        $product = new AfterProduction();
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = $query->paginate($item_count);
        return view('Admin.sales.sales_ledger_search', compact('dataset', 'subhead', 'particular', 'product'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Weight::with('items', 'production_stocks', 'sale_transaction')->find($id);
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

                if (!empty($data->sale_transaction)) {
                    foreach ($data->sale_transaction as $transaction) {
                        if (!$transaction->delete()) {
                            throw new Exception("Error while deleting records from Transaction.");
                        }
                    }
                }

                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Sale Order has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
