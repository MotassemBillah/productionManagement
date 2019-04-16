<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Category;
use App\Product;
use App\Weight;
use App\WeightItem;
use App\Models\Transaction;
use App\Stock;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Auth;

class PurchaseController extends HomeController {

    public function index() {
        check_user_access('manage_purchase');
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = Weight::where('weight_type', 'in')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('Admin.purchases.index', compact('dataset', 'subhead', 'particular'));
    }

    public function create() {
        check_user_access('purchase_create');
        $heads = SubHead::where('head_id', HEAD_CREDITORS)->get();
        $subheads = new SubHead();
        $category = new Category();
        $products = new Product();
        return view('Admin.purchases.create', compact('products', 'category', 'heads'));
    }

    public function store(Request $r) {
        // pr($_POST);
        $resp = [];
        $invoice = $r->invoice_no;

        DB::beginTransaction();
        try {
            $inv = Weight::where('invoice_no', $invoice)->first();
            if (!empty($inv)) {
                throw new Exception("Invoice already exist.");
            }

            $model = new Weight();

            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->invoice_no = $r->invoice_no;
            $model->challan_no = $r->challan_no;
            $model->weight_type = 'in';
            $model->head_id = $r->head;
            $model->subhead_id = $r->subhead;
            $model->quantity = $r->total_quantity;
            $model->weight = $r->total_net_weight;
            $model->mon = $r->mon;
            $model->weight_per_qty = $r->wpq;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating purchase.");
            }

            $weight_id = DB::getPdo()->lastInsertId();

            if (empty($_POST['product'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            $total_price = 0;
            if (!empty($_POST['product'])) {
                foreach ($_POST['product'] as $key => $value) {
                    if (!empty($_POST['product'][$key])) {
                        $_productName = Product::find($value)->name;
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
                        $modelWi->product_id = $_POST['product_id'][$value];
                        $modelWi->weight = $_POST['net_weight'][$value];
                        $modelWi->quantity = $_POST['quantity'][$value];
                        $modelWi->mon = $_POST['net_mon'][$value];
                        $modelWi->per_bag_price = $_POST['per_bag_price'][$value];
                        $modelWi->net_price = $_POST['net_price'][$value];
                        $modelWi->created_by = Auth::id();
                        $modelWi->_key = uniqueKey() + $key;
                        $total_price += $_POST['net_price'][$value];
                        if (!$modelWi->save()) {
                            throw new Exception("Error! while creating purchase items.");
                        }
                    }
                }
            }

            $model->invoice_amount = $total_price;
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
        $data = Weight::find($id);
        return view('Admin.purchases.details', compact('data'));
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Weight::find($id);
        $heads = SubHead::where('head_id', HEAD_CREDITORS)->get();
        $subheads = new Particular();
        $category = new Category();
        $products = new Product();
        return view('Admin.purchases.edit', compact('data', 'heads', 'subheads', 'category', 'products'));
    }

    public function update(Request $r, $id) {
        //pr($_POST, false);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'invoice_no' => 'required|unique:weights,invoice_no,' . $id,
            'total_quantity' => 'required',
            'total_net_weight' => 'required',
            'head' => 'required',
        );

        $messages = array(
            'invoice_no.required' => 'Please insert invoice no',
            'total_quantity.required' => 'Please insert quantity',
            'total_net_weight.required' => 'Please insert net weight',
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
            $model->weight_type = 'in';
            $model->head_id = $r->head;
            $model->subhead_id = $r->subhead;
            $model->quantity = $r->total_quantity;
            $model->mon = $r->mon;
            $model->weight = $r->total_net_weight;
            $model->weight_per_qty = $r->wpq;
            $model->modified_by = Auth::id();
            if (!$model->save()) {
                throw new Exception("Error! while updating purchase.");
            }

            $total_price = 0;
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
                    $modelWi->mon = $_POST['net_mon'][$value];
                    $modelWi->per_bag_price = $_POST['per_bag_price'][$value];
                    $modelWi->net_price = $_POST['net_price'][$value];
                    $modelWi->modified_by = Auth::id();
                    $total_price += $_POST['net_price'][$value];
                    if (!$modelWi->save()) {
                        throw new Exception("Error! while updating purchase items.");
                    }
                }
            }
            $model->invoice_amount = $total_price;
            $model->save();
            DB::commit();
            return redirect('purchases')->with('success', 'Purchases Updated Successfully.');
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
                $modelStock = new Stock();
                $modelStock->invoice_no = $data->invoice_no;
                $modelStock->weight_id = $data->id;
                $modelStock->date = $data->date;
                $modelStock->weight_type = 'in';
                $modelStock->category_id = $value->category_id;
                $modelStock->product_id = $value->product_id;
                $modelStock->weight = $value->weight;
                $modelStock->quantity = $value->quantity;
                $modelStock->created_by = Auth::id();
                $modelStock->_key = uniqueKey() . $key;

                if (!$modelStock->save()) {
                    throw new Exception("Query Problem on Creating Stocks.");
                }
            }

            $data->process_status = 1;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }
            $head_id = SubHead::find($data->head_id)->head->head_id;

            $totalSum = $data->invoice_amount;
            $transaction = new Transaction();

            $transaction->purchase_id = $data->id;
            $transaction->type = 'D';
            $transaction->voucher_type = PURCHASE_VOUCHER;
            $transaction->payment_method = PAYMENT_NO;
            $transaction->pay_date = $modelStock->date;
            $transaction->dr_head_id = HEAD_PURCHASE;
            $transaction->dr_subhead_id = NULL;
            $transaction->dr_particular_id = NULL;
            $transaction->cr_head_id = HEAD_CREDITORS;
            $transaction->cr_subhead_id = $data->head_id;
            $transaction->cr_particular_id = $data->subhead_id;
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
        $data = Weight::find($id);
        DB::beginTransaction();
        try {

            if (!empty($data->stocks)) {
                foreach ($data->stocks as $stock) {
                    if (!$stock->delete()) {
                        throw new Exception("Error while deleting records from Stocks.");
                    }
                }
            }

            if (!empty($data->purchase_transaction)) {
                foreach ($data->purchase_transaction as $transaction) {
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
            return redirect('purchases')->with('success', 'Purchase Order Reset Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('purchases')->with('danger', $e->getMessage());
        }
    }

    public function payment_form($id) {
        $model = Weight::find($id);
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



            $_data = Weight::find($purchase_id);

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

    public function purchase_ledger() {
        $product = new Product();
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = WeightItem::where('weight_type', 'in')->paginate($this->getSettings()->pagesize);
        return view('Admin.purchases.purchase_ledger', compact('dataset', 'subhead', 'particular', 'product'));
    }

    public function purchase_stocks() {
        $dataset = Product::orderBy('category_id', 'DESC')->get();
        $category = new Category();
        $product = new Product();
        $stock = new Stock();
        return view('Admin.purchase_stocks.index', compact('dataset', 'category', 'product', 'stock'));
    }

    public function purchase_stocks_search(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = Product::query();
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
        $query->orderBy('category_id', 'DESC');
        $dataset = $query->paginate($item_count);
        $category = new Category();
        $product = new Product();
        $stock = new Stock();
        return view('Admin.purchase_stocks._list', compact('dataset', 'category', 'product', 'stock'));
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
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('Admin.purchases._list', compact('dataset', 'subhead', 'particular'));
    }

    public function purchase_ledger_search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $order_type = 'in';
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
            $query->where('product_id', 'like', '%' . $search_by_product . '%');
        }
        $product = new Product();
        $subhead = new SubHead();
        $particular = new Particular();
        $dataset = $query->paginate($item_count);
        return view('Admin.purchases.purchase_ledger_search', compact('dataset', 'subhead', 'particular', 'product'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Weight::with('items', 'stocks', 'purchase_transaction')->find($id);

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

                if (!empty($data->purchase_transaction)) {
                    foreach ($data->purchase_transaction as $transaction) {
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

    public function manage_stocks() {
        check_user_access('manage_stocks');
        $dataset = Stock::orderBy('product_id', 'desc')->groupBy('product_no_id')->get();
        $category = new Category();
        $product = new Product();
        $product_no = new ProductItem();
        return view('Admin.Stocks.index', compact('dataset', 'category', 'product', 'product_no'));
    }

//Manage Purchase Invoice Payment
    public function purchase_invoice_payment($id) {
        $model = new Weight();
        $_data = $model->find($id);
        if (!empty($_data->agent_id)) {
            $modelPayment = new SupplierTransaction();
        } else {
            $modelPayment = new CustomerTransaction();
        }
        $payment = $modelPayment->where('purchase_id', '=', $id)->first();
        $banklist = Bank::all();
        $agents = new Agent();
        $customers = new Customer();
        return view('Admin.Manage Order.payment', compact('banklist', 'payment', '_data', 'agents', 'customers'));
    }

    public function update_payment(Request $r) {
        $response = array();
        $customer_type = $r->customer_type;
        if ($customer_type == 'customer') {
            $model = new CustomerTransaction();
            $cond = 'customer_transaction_id';
        } else {
            $model = new SupplierTransaction();
            $cond = 'supplier_transaction_id';
        }
        $paymentID = $r->paymentID;
        $payment = $model->where('purchase_id', $paymentID)->first();

        $payment_mode = $r->payment_mode;
        $transportCost = $r->txtTransportCost;
        $laborCost = $r->txtLaborCost;
        $otherCost = $transportCost + $laborCost;
        $invoiceAmount = $r->txtInvoiceAmount;
        $vat = $r->txtVat;
        $netTotal = $r->txtNetTotal;
        $lessType = $r->lessType;
        $lessAmount = $r->txtLess;
        $netPayable = $r->txtNetPayable;
        $paidAmount = $r->txtPaid;
        $invoicePaid = $r->txtInvoicePaid;
        $invoiceDue = $r->txtInvoiceDue;
        $invoiceAdv = $r->txtInvoiceAdv;

        DB::beginTransaction();
        try {
            if (empty($payment_mode)) {
                throw new Exception("You must select Payment mode.");
            }

            $payment->payment_method = isset($payment_mode) ? $payment_mode : PAYMENT_NO;
            $payment->transport_cost = !empty($transportCost) ? $transportCost : NULL;
            $payment->labor_cost = !empty($laborCost) ? $laborCost : NULL;
            $payment->invoice_amount = !empty($invoiceAmount) ? $invoiceAmount : NULL;
            $payment->vat = !empty($vat) ? $vat : NULL;
            $payment->net_amount = !empty($netTotal) ? $netTotal : NULL;
            $payment->discount_type = isset($lessType) ? $lessType : NULL;
            $payment->discount_amount = isset($lessAmount) ? $lessAmount : NULL;
            $payment->net_payable = !empty($netPayable) ? $netPayable : NULL;
            $payment->paid_amount = !empty($paidAmount) ? $paidAmount : NULL;
            $payment->invoice_paid = !empty($invoicePaid) ? $invoicePaid : NULL;
            $payment_head = NULL;

            if ($payment_mode == PAYMENT_CASH) {
                if (empty($paidAmount)) {
                    throw new Exception("You must enter paid amount.");
                }

                $payment->bank_setting_id = NULL;
                $payment->check_no = NULL;
                $payment_head = HEAD_SUB_CASH;

                if ($paidAmount > $netPayable) {
                    $payment->invoice_due = NULL;
                    $payment->invoice_advance = ($paidAmount - $netPayable);
                } elseif ($paidAmount < $netPayable) {
                    $payment->invoice_due = ($netPayable - $paidAmount);
                    $payment->invoice_advance = NULL;
                } else {
                    $payment->invoice_due = NULL;
                    $payment->invoice_advance = NULL;
                }
            } elseif ($payment_mode == PAYMENT_BANK) {
                if (empty($paidAmount)) {
                    throw new Exception("You must enter paid amount.");
                }
                $payment_head = HEAD_SUB_BANK;

                $bank_name = isset($_POST['CompanyTransaction']['bank_setting_id']) ? $_POST['CompanyTransaction']['bank_setting_id'] : "";
                $check_no = isset($_POST['CompanyTransaction']['check_no']) ? $_POST['CompanyTransaction']['check_no'] : "";

                if (empty($bank_name)) {
                    throw new Exception("You must select a bank.");
                }
                if (empty($check_no)) {
                    throw new Exception("You must provide a cheque number.");
                }
                $payment->bank_setting_id = $bank_name;
                $payment->check_no = $check_no;

                if ($paidAmount > $netPayable) {
                    $payment->invoice_due = NULL;
                    $payment->invoice_advance = ($paidAmount - $netPayable);
                } elseif ($paidAmount < $netPayable) {
                    $payment->invoice_due = ($netPayable - $paidAmount);
                    $payment->invoice_advance = NULL;
                } else {
                    $payment->invoice_due = NULL;
                    $payment->invoice_advance = NULL;
                }
            } else {
                $payment->bank_setting_id = NULL;
                $payment->check_no = NULL;
                $payment->paid_amount = $paidAmount;
                $payment->invoice_paid = NULL;
                $payment->invoice_due = $netPayable;
                $payment->invoice_advance = NULL;
                $payment_head = PAYMENT_NO;
            }

            $payment->modified_by = Auth::id();
            if (!$payment->save()) {
                throw new Exception("Error while updating payment info.");
            }

            $_head_array[0] = ["dr_head_id" => HEAD_ASSET, "dr_subhead_id" => HEAD_SUB_PURCHASE, "debit" => $netPayable, "cr_head_id" => HEAD_LIAIBILITY, "cr_subhead_id" => HEAD_SUB_CREDITORS, 'credit' => $netPayable, 'amount' => $netPayable, 'purpose' => 'Purchase Transaction'];
            $_head_array[1] = ["dr_head_id" => HEAD_LIAIBILITY, "dr_subhead_id" => HEAD_SUB_CREDITORS, "debit" => $invoicePaid, "cr_head_id" => HEAD_ASSET, "cr_subhead_id" => $payment_head, 'credit' => $invoicePaid, 'amount' => $invoicePaid, 'purpose' => 'Purchase Transaction'];

            Transaction::where($cond, $payment->id)->delete();

            foreach ($_head_array as $_key => $value) {
                $model_transaction = new Transaction();
                $model_transaction->$cond = $payment->id;
                $model_transaction->voucher_type = INVOICE_VOUCHER;
                $model_transaction->transaction_type = TRANSACTION_INVOICE;
                $model_transaction->transaction_date = $payment->pay_date;
                $model_transaction->bank_setting_id = isset($_POST['CompanyTransaction']['bank_setting_id']) ? $_POST['CompanyTransaction']['bank_setting_id'] : NULL;
                $model_transaction->check_no = isset($_POST['CompanyTransaction']['check_no']) ? $_POST['CompanyTransaction']['check_no'] : NULL;
                $model_transaction->payment_method = $payment_mode;
                $model_transaction->dr_ledger_head_id = $value['dr_head_id'];
                $model_transaction->dr_subhead_id = $value['dr_subhead_id'];
                $model_transaction->cr_ledger_head_id = $value['cr_head_id'];
                $model_transaction->cr_subhead_id = $value['cr_subhead_id'];
                $model_transaction->by_whom = Auth::user()->name;
                $model_transaction->purpose = $value['purpose'];
                $model_transaction->debit = $value['debit'];
                $model_transaction->credit = $value['credit'];
                $model_transaction->amount = $value['amount'];
                $model_transaction->note = $model_transaction->purpose;
                $model_transaction->is_paid = 1;
                $model_transaction->created_by = Auth::id();
                $model_transaction->_key = uniqueKey() . $_key;
                if (!$model_transaction->save()) {
                    throw new Exception("Error while updating transaction info.");
                }
            }

            $purchaseModel = Weight::find($paymentID);
            $purchaseModel->payment_status = 1;
            if (!$purchaseModel->save()) {
                throw new Exception("Error while updating payments status in Weights");
            }

            DB::commit();
            $response['success'] = true;
            $response['message'] = "Record saved successfully. Redirecting.....";
            $response['goto'] = url('manage-order');
        } catch (Exception $e) {
            DB::rollback();
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
        return json_encode($response);
    }

}
