<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;
use DB;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\RawCategory;
use App\Models\RawProduct;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Transaction;

class PurchaseController extends HomeController {

    public function index() {
        check_user_access('manage_purchase');
        $dataset = Purchase::where('type', 'in')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('Admin.purchases.index', compact('dataset'));
    }

    public function create() {
        check_user_access('purchase_create');
        $subheads = SubHead::where('head_id', HEAD_CREDITORS)->get();
        $products = RawProduct::orderBy('raw_category_id')->get();
        return view('Admin.purchases.create', compact('products', 'subheads'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $resp = [];
        $invoice = $r->invoice_no;

        DB::beginTransaction();
        try {
            $inv = Purchase::where('invoice_no', $invoice)->first();
            if (!empty($inv)) {
                throw new Exception("Invoice already exist.");
            }

            if (empty($_POST['product'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            if (!empty($r->subhead)) {
                $head_id = SubHead::find($r->subhead)->head_id;
            } else {
                $head_id = NULL;
            }

            $model = new Purchase();

            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->invoice_no = $r->invoice_no;
            $model->challan_no = $r->challan_no;
            $model->type = 'in';
            $model->head_id = $head_id;
            $model->subhead_id = $r->subhead;
            $model->particular_id = $r->particular;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating purchase.");
            }

            $last_id = DB::getPdo()->lastInsertId();

            $total_price = [];
            if (!empty($_POST['product'])) {
                foreach ($_POST['product'] as $key => $value) {
                    if (!empty($_POST['product'][$key])) {
                        $_productName = RawProduct::find($value)->name;
                        if (empty($_POST['quantity'][$value])) {
                            throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
                        }

                        if (empty($_POST['per_qty_price'][$value])) {
                            throw new Exception("Please Provide Per Qty Price.");
                        }

                        $modelItem = new PurchaseItem();
                        $modelItem->purchase_id = $last_id;
                        $modelItem->type = $model->type;
                        $modelItem->head_id = $model->head_id;
                        $modelItem->subhead_id = $model->subhead_id;
                        $modelItem->particular_id = $model->particular_id;
                        $modelItem->date = $model->date;
                        $modelItem->raw_category_id = $_POST['category_id'][$value];
                        $modelItem->raw_product_id = $_POST['product_id'][$value];
                        $modelItem->quantity = $_POST['quantity'][$value];
                        $modelItem->per_qty_price = $_POST['per_qty_price'][$value];
                        $modelItem->total_price = $_POST['total_price'][$value];
                        $modelItem->created_by = $model->created_by;
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
            $resp['message'] = 'Product has been Purchased Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function show($id) {
        $data = Purchase::find($id);
        return view('Admin.purchases.details', compact('data'));
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Purchase::find($id);
        $subheads = SubHead::where('head_id', HEAD_CREDITORS)->get();
        $particulars = new Particular();
        $products = RawProduct::orderBy('raw_category_id')->get();
        return view('Admin.purchases.edit', compact('data', 'subheads', 'products', 'particulars'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'invoice_no' => 'required|unique:purchase,invoice_no,' . $id,
            'subhead' => 'required',
        );

        $messages = array(
            'invoice_no.required' => 'Please insert invoice no',
        );

        $valid = Validator::make($input, $rule, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if (!empty($r->subhead)) {
            $head_id = SubHead::find($r->subhead)->head_id;
        } else {
            $head_id = NULL;
        }

        DB::beginTransaction();
        try {
            $model = Purchase::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->invoice_no = $r->invoice_no;
            $model->challan_no = $r->challan_no;
            $model->head_id = $head_id;
            $model->subhead_id = $r->subhead;
            $model->particular_id = $r->particular;
            $model->modified_by = Auth::id();
            if (!$model->save()) {
                throw new Exception("Error! while updating purchase.");
            }

            $total_price = [];
            foreach ($_POST['hid'] as $key => $value) {
                if (!empty($_POST['hid'][$key])) {
                    if (empty($_POST['quantity'][$value])) {
                        throw new Exception("Please Provide Quantity");
                    }

                    if (empty($_POST['per_qty_price'][$value])) {
                        throw new Exception("Please Provide Per Bag Price.");
                    }

                    $modelItem = PurchaseItem::find($value);
                    $modelItem->head_id = $model->head_id;
                    $modelItem->subhead_id = $model->subhead_id;
                    $modelItem->particular_id = $model->particular_id;
                    $modelItem->date = $model->date;
                    $modelItem->quantity = $_POST['quantity'][$value];
                    $modelItem->per_qty_price = $_POST['per_qty_price'][$value];
                    $modelItem->total_price = $_POST['total_price'][$value];
                    $modelItem->modified_by = $model->modified_by;

                    if (!$modelItem->save()) {
                        throw new Exception("Error! while updating purchase items.");
                    }
                }
            }
            $model->invoice_amount = array_sum($_POST['total_price']);
            $model->save();
            DB::commit();
            return redirect('purchases')->with('success', 'Purchases Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function confirm($id) {
        $data = Purchase::find($id);
        DB::beginTransaction();
        try {
            $data->process_status = 1;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }
            //$head_id = SubHead::find($data->head_id)->head->head_id;

            $totalSum = $data->invoice_amount;
            $transaction = new Transaction();

            $transaction->purchase_id = $data->id;
            $transaction->type = 'D';
            $transaction->voucher_type = PURCHASE_VOUCHER;
            $transaction->payment_method = PAYMENT_NO;
            $transaction->pay_date = $data->date;
            $transaction->dr_head_id = HEAD_PURCHASE;
            $transaction->dr_subhead_id = NULL;
            $transaction->dr_particular_id = NULL;
            $transaction->cr_head_id = HEAD_CREDITORS;
            $transaction->cr_subhead_id = $data->subhead_id;
            $transaction->cr_particular_id = $data->particular_id;
            $transaction->by_whom = Auth::user()->name;
            $transaction->description = "Purchase on Credit";
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
            return redirect('purchases')->with('success', 'Purchase Order Processed Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('purchases')->with('danger', $e->getMessage());
        }
    }

    public function reset($id) {
        $data = Purchase::find($id);
        DB::beginTransaction();
        try {
            if (!empty($data->transaction)) {
                foreach ($data->transaction as $transaction) {
                    if (!$transaction->delete()) {
                        throw new Exception("Error while deleting records from Transaction.");
                    }
                }
            }

            $data->process_status = 0;
            $data->payment_status = 0;
            $data->paid_amount = NULL;
            $data->due_amount = NULL;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }

            DB::commit();
            return redirect('purchases')->with('success', 'Purchase Order Reset Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('purchases')->with('danger', $e->getMessage());
        }
    }

    public function payment_form($id) {
        $model = Purchase::find($id);
        $subhead = new SubHead();
        $transaction = new Transaction();
        $payment_info = $transaction->where([['purchase_id', $id], ['is_dbl', 1]])->first();
        $payment = !empty($payment_info) ? $payment_info : $transaction;
        $particular = new Particular();
        return view('Admin.purchases.payment_form', compact('model', 'subhead', 'payment', 'particular'));
    }

    public function payment_update(Request $r) {
        //pr($_POST);
        $response = array();
        $purchase_id = $r->purchase_id;
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



            $_data = Purchase::find($purchase_id);

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

            $tdata = $_modelTransaction->where([['purchase_id', $purchase_id], ['is_dbl', 1]])->first();
            if (!empty($tdata)) {
                if (!$tdata->delete()) {
                    throw new Exception("Error! while deleting Previous Transaction.");
                }
            }

            $_modelTransaction->purchase_id = $purchase_id;
            $_modelTransaction->type = 'C';
            $_modelTransaction->voucher_type = PAYMENT_VOUCHER;
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

    public function ledger() {
        $category = new RawCategory();
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = PurchaseItem::where('type', 'in')->paginate($this->getSettings()->pagesize);
        return view('Admin.purchases.ledger', compact('dataset', 'subhead', 'particular', 'category'));
    }

    public function stocks() {
        $dataset = RawProduct::orderBy('raw_category_id', 'DESC')->get();
        $category = new RawCategory();
        $product = new RawProduct();
        return view('Admin.purchases.stocks', compact('dataset', 'category', 'product', 'stock'));
    }

    public function stocks_search(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $category = $r->category;
        $product = $r->product;
        $query = RawProduct::query();
        if (!empty($category)) {
            $query->where('raw_category_id', $category);
        }
        if (!empty($product)) {
            $query->where('id', $product);
        }
        $query->orderBy('raw_category_id', 'DESC');
        $dataset = $query->paginate($item_count);
        $category = new RawCategory();
        $product = new RawProduct();
        return view('Admin.purchases.stocks_search', compact('dataset', 'category', 'product'));
    }

// Ajax Functions
    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $order_type = 'in';
        $search_by = $r->input('search_by');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = Purchase::where('type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                $query->where('type', '=', $order_type);
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('invoice_no', 'like', '%' . $search . '%');
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('Admin.purchases._list', compact('dataset'));
    }

    public function ledger_search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $order_type = 'in';
        $search_by_customer = $r->input('search_by_customer');
        $search_by_category = $r->input('search_by_category');
        $search_by_product = $r->input('search_by_product');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $order = $r->input('order');

        $query = PurchaseItem::where('type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by_customer)) {
            $query->where('particular_id', 'like', '%' . $search_by_customer . '%');
        }
        if (!empty($search_by_category)) {
            $query->where('raw_category_id', $search_by_category);
        }
        if (!empty($search_by_product)) {
            $query->where('raw_product_id', $search_by_product);
        }
        if (!empty($order)) {
            $oid = Purchase::where('challan_no', $order)->first();
            if (!empty($oid)) {
                $query->where('purchase_id', $oid->id);
            }
        }
        $product = new RawProduct();
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = $query->paginate($item_count);
        return view('Admin.purchases.ledger_search', compact('dataset', 'subhead', 'particular', 'product'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Purchase::with('items', 'transaction')->find($id);

                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Items.");
                        }
                    }
                }
                if (!empty($data->transaction)) {
                    foreach ($data->transaction as $transaction) {
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
            $resp['message'] = 'Purchase Order has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }


}
