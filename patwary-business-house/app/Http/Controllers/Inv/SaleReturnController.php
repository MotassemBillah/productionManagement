<?php

namespace App\Http\Controllers\Inv;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\Models\User;
use App\Models\Institute;
use App\Models\BusinessType;
use App\Models\Inv\AvgPrice;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Inv\SaleReturn;
use App\Models\Inv\SaleReturnCart;
use App\Models\Inv\SaleReturnItem;
use App\Models\Inv\Stock;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Transaction;
use DB;
use Validator;
use Illuminate\Http\Request;

class SaleReturnController extends HomeController {

    public function index() {
        check_user_access('inv_sales');
        $model = new SaleReturn();
        $query = $model->where('is_deleted', 0)->orderBy("id", "DESC");
        $dataset = $query->paginate($this->getSettings()->pagesize);

        $this->model['breadcrumb_title'] = "Sale Return List";
        $this->model['dataset'] = $dataset;
        return view('inv.sale_return.index', $this->model);
    }

    public function create() {
        check_user_access('inv_sales_create');
        $product = new Product();
        $dataset = $product->getList();
        $institute_list = Institute::get();
        $business_types = BusinessType::get();
        $categories = Category::get();

        $this->model['breadcrumb_title'] = "Sale Return Information";
        $this->model['dataset'] = $dataset;
        $this->model['institute_list'] = $institute_list;
        $this->model['business_types'] = $business_types;
        $this->model['categories'] = $categories;
        return view('inv.sale_return.create', $this->model);
    }

    public function cart() {
        check_user_access('inv_sales_create');
        $_initituteID = institute_id();
        $_model = new SaleReturn();
        $dataset = SaleReturnCart::where('user_id', Auth::id())->get();
        $invoice_no = $_model->invoice_number();
        $from_subhead_list = SubHead::where([['institute_id', $_initituteID], ['is_deleted', 0]])->whereIn('head_id', [PATWARY_HEAD_DEBTORS, PATWARY_HEAD_CREDITORS])->get();
        $to_subhead_list = SubHead::where([['institute_id', $_initituteID], ['head_id', PATWARY_HEAD_PURCHASE], ['is_deleted', 0]])->get();

        $this->model['breadcrumb_title'] = "Sale Return Information";
        $this->model['dataset'] = $dataset;
        $this->model['invoice_no'] = $invoice_no;
        $this->model['from_subhead_list'] = $from_subhead_list;
        $this->model['to_subhead_list'] = $to_subhead_list;
        return view('inv.sale_return.cart_form', $this->model);
    }

    public function clear_cart() {
        check_user_access('inv_sales_create');
        DB::beginTransaction();
        try {
            $cart_dataset = SaleReturnCart::where('user_id', Auth::id())->get();
            //pr($cart_dataset);
            foreach ($cart_dataset as $cart_data) {
                if (!$cart_data->delete()) {
                    throw new Exception("Error while removing cart records.");
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Cart records removed successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            "invoice_number" => "required",
            "from_subhead" => "required",
            "from_particular" => "required",
            "to_subhead" => "required",
        );

        $messages = array(
            "invoice_number" => "Invoice number required",
            "from_subhead" => "Please select from subhead",
            "from_particular" => "Please select from particular",
            "to_subhead" => "Please select to subhead",
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $product = new Product();
            $_idArr = $r->key;

            $_note = "[";
            foreach ($_idArr as $_idkey => $_idval) {
                $_productName = $product->name($r->product_id[$_idval]);
                if (empty($r->quantity[$_idval])) {
                    throw new Exception("Quantity required for {$_productName}.");
                }

                if (empty($r->rate[$_idval])) {
                    throw new Exception("Rate required for {$_productName}.");
                }

                $_note .= "{{$_productName}:{$r->quantity[$_idval]}x{$r->rate[$_idval]}}, ";
            }
            $_note .= "]";

            //$_sum_total = !empty($r->subtotal) ? array_sum($r->subtotal) : 0;
            $_sum_total = $r->total;
            $_subhead = new SubHead();
            $frm_subhead = $r->from_subhead;
            $frm_head = $_subhead->find($frm_subhead)->head_id;
            $to_subhead = $r->to_subhead;
            $to_head = $_subhead->find($to_subhead)->head_id;

            $model = new SaleReturn();
            $model->invoice_date = date_ymd($r->invoice_date);
            $model->invoice_no = $r->invoice_number;
            $model->challan_no = $r->challan_number;
            $model->from_head_id = $frm_head;
            $model->from_subhead_id = $frm_subhead;
            $model->from_particular_id = $r->from_particular;
            $model->to_head_id = $to_head;
            $model->to_subhead_id = $to_subhead;
            $model->to_particular_id = $r->to_particular;
            $model->invoice_amount = round($_sum_total, 2);
            $model->transport_cost = round($r->transport_cost, 2);
            $model->labor_cost = round($r->labor_cost, 2);
            $model->other_cost = round($r->other_cost, 2);
            $_tqty = $r->tqty;
            $_otherCost = ($model->transport_cost + $model->labor_cost + $model->other_cost);
            $_avg_price = round(($_otherCost / $_tqty), 2);
            $model->avg_cost = $_avg_price;
            $model->total_amount = round(($model->invoice_amount + $_otherCost), 2);
            $model->net_amount = $model->total_amount;
            $model->due_amount = $model->total_amount;
            $model->note = str_replace(", ]", "]", $_note);
            $model->created_by = Auth::id();
            $model->created_at = cur_date_time();
            $model->_key = uniqueKey();
            if (!$model->save()) {
                throw new Exception("Error while saving purchase record.");
            }

            $lastId = DB::getPdo()->lastInsertId();
            foreach ($_idArr as $_idkey => $_idval) {
                $modelItem = new SaleReturnItem();
                $modelItem->institute_id = $r->inst_id[$_idval];
                $modelItem->business_type_id = $r->btype_id[$_idval];
                $modelItem->sale_return_id = $lastId;
                $modelItem->invoice_date = date_ymd($r->invoice_date);
                $modelItem->category_id = $r->category_id[$_idval];
                $modelItem->product_id = $r->product_id[$_idval];
                $modelItem->quantity = $r->quantity[$_idval];
                $modelItem->rate = round($r->rate[$_idval], 2);
                $modelItem->amount = round(($modelItem->quantity * $modelItem->rate), 2);
                $modelItem->avg_price = round(($modelItem->rate + $_avg_price), 2);
                if (!$modelItem->save()) {
                    throw new Exception("Error while saving purchase item record.");
                }
            }

            $cart_dataset = SaleReturnCart::where('user_id', Auth::id())->get();
            foreach ($cart_dataset as $cart_data) {
                if (!$cart_data->delete()) {
                    throw new Exception("Error while removing cart records.");
                }
            }

            DB::commit();
            return redirect('inv/sale-return')->with('success', 'New record created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        check_user_access('inv_sales_edit');
        $_initituteID = institute_id();
        $model = SaleReturn::where('_key', $id)->first();

        $institute_list = Institute::get();
        $from_subhead_list = SubHead::where([['institute_id', $_initituteID], ['is_deleted', 0]])->whereIn('head_id', [PATWARY_HEAD_DEBTORS, PATWARY_HEAD_CREDITORS])->get();
        $from_particular_list = Particular::where([['institute_id', $_initituteID], ['subhead_id', $model->from_subhead_id], ['is_deleted', 0]])->get();
        $to_subhead_list = SubHead::where([['institute_id', $_initituteID], ['head_id', $model->to_head_id], ['is_deleted', 0]])->get();
        $to_particular_list = Particular::where([['institute_id', $_initituteID], ['subhead_id', $model->to_subhead_id], ['is_deleted', 0]])->get();

        $this->model['breadcrumb_title'] = "Sale Return Information";
        $this->model['model'] = $model;
        $this->model['institute_list'] = $institute_list;
        $this->model['from_subhead_list'] = $from_subhead_list;
        $this->model['from_particular_list'] = $from_particular_list;
        $this->model['to_subhead_list'] = $to_subhead_list;
        $this->model['to_particular_list'] = $to_particular_list;
        return view('inv.sale_return.edit', $this->model);
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            "invoice_number" => "required",
            "from_subhead" => "required",
            "from_particular" => "required",
            "to_subhead" => "required",
        );

        $messages = array(
            "invoice_number" => "Invoice number required",
            "from_subhead" => "Please select from subhead",
            "from_particular" => "Please select from particular",
            "to_subhead" => "Please select to subhead",
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        //$_sum_total = !empty($r->subtotal) ? array_sum($r->subtotal) : 0;
        $_sum_total = $r->total;
        $_subhead = new SubHead();
        $frm_subhead = $r->from_subhead;
        $frm_head = $_subhead->find($frm_subhead)->head_id;
        $to_subhead = $r->to_subhead;
        $to_head = $_subhead->find($to_subhead)->head_id;

        DB::beginTransaction();
        try {
            $model = SaleReturn::where('_key', $id)->first();
            $model->invoice_date = date_ymd($r->invoice_date);
            $model->invoice_no = $r->invoice_number;
            $model->challan_no = $r->challan_number;
            $model->from_head_id = $frm_head;
            $model->from_subhead_id = $frm_subhead;
            $model->from_particular_id = $r->from_particular;
            $model->to_head_id = $to_head;
            $model->to_subhead_id = $to_subhead;
            $model->to_particular_id = $r->to_particular;
            $model->invoice_amount = round($_sum_total, 2);
            $model->transport_cost = round($r->transport_cost, 2);
            $model->labor_cost = round($r->labor_cost, 2);
            $model->other_cost = round($r->other_cost, 2);
            $_tqty = $r->tqty;
            $_otherCost = ($model->transport_cost + $model->labor_cost + $model->other_cost);
            $_avg_price = round(($_otherCost / $_tqty), 2);
            $model->avg_cost = $_avg_price;
            $model->total_amount = round(($model->invoice_amount + $_otherCost), 2);
            $model->net_amount = $model->total_amount;
            $model->due_amount = $model->total_amount;
            $model->note = $r->note;
            $model->modified_by = Auth::id();
            $model->modified_at = cur_date_time();
            if (!$model->save()) {
                throw new Exception("Error while updating record.");
            }

            $_idArr = $r->key;
            foreach ($_idArr as $_idkey => $_idval) {
                $modelItem = SaleReturnItem::find($_idval);
                $modelItem->institute_id = $r->inst_id[$_idval];
                $modelItem->business_type_id = $r->btype_id[$_idval];
                //$modelItem->sale_retutn_id = $model->id;
                $modelItem->invoice_date = date_ymd($r->invoice_date);
                $modelItem->category_id = $r->category_id[$_idval];
                $modelItem->product_id = $r->product_id[$_idval];
                $modelItem->quantity = $r->quantity[$_idval];
                $modelItem->rate = round($r->rate[$_idval], 2);
                $modelItem->amount = round(($modelItem->quantity * $modelItem->rate), 2);
                $modelItem->avg_price = round(($modelItem->rate + $_avg_price), 2);
                if (!$modelItem->save()) {
                    throw new Exception("Error while updating purchase item record.");
                }
            }

            DB::commit();
            return redirect('inv/sale-return')->with('success', 'Record updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show() {
        pr("Silence is the best.");
    }

    public function detail($id) {
        check_user_access('inv_detail');
        $model = SaleReturn::where('_key', $id)->first();
        if ($model->is_deleted == 1) {
            return redirect("inv/sale-retutn")->with("danger", "You are trying to access an invalid url.");
        }

        $_modelTrn = new Transaction();
        $particular_net_balance = $_modelTrn->sumPartBalance($model->from_particular_id);

        $this->model['breadcrumb_title'] = "Sale Return Information";
        $this->model['model'] = $model;
        $this->model['particular_net_balance'] = $particular_net_balance;
        return view('inv.sale_return.detail', $this->model);
    }

    public function payment($id) {
        check_user_access('inv_payment');
        $_initituteID = institute_id();
        $model = SaleReturn::where('_key', $id)->first();

        if ($model->process_status == ORDER_PENDING) {
            return redirect("inv/sale-return/detail/{$id}")->with("danger", "You are trying to access an invalid url.");
        }

        $_modelTrn = new Transaction();
        $payment = $_modelTrn->where([['institute_id', $_initituteID], ['pst_type', 'inv'], ['purchase_id', $model->id], ['is_dbl', 1]])->first();
        //$payment = !empty($_payment) ? $_payment : $_modelTrn;

        if (isset($_POST['submit_form'])) {
            $_subhead = new SubHead();
            $frm_subhead = $_POST['from_subhead'];
            $frm_head = $_subhead->find($frm_subhead)->head_id;
            $to_subhead = $_POST['to_subhead'];
            $to_head = $_subhead->find($to_subhead)->head_id;
            //pr($_POST);

            DB::beginTransaction();
            try {
                $ex_payments = $_modelTrn->where([['institute_id', $_initituteID], ['pst_type', 'inv'], ['purchase_id', $model->id], ['is_dbl', 1]])->get();
                if (!empty($ex_payments)) {
                    foreach ($ex_payments as $epays) {
                        if (!$epays->delete()) {
                            throw new Exception("Error while updating existing record.");
                        }
                    }
                }

                $modelTrn = new Transaction();
                $modelTrn->institute_id = $_initituteID;
                $modelTrn->pst_type = "inv";
                $modelTrn->purchase_id = $_POST['purchase_id'];
                $modelTrn->date = date("Y-m-d", strtotime($_POST['pay_date']));
                $modelTrn->cr_head_id = $frm_head;
                $modelTrn->cr_subhead_id = $_POST['from_subhead'];
                $modelTrn->cr_particular_id = $_POST['from_particular'];
                $modelTrn->dr_head_id = $to_head;
                $modelTrn->dr_subhead_id = $_POST['to_subhead'];
                $modelTrn->dr_particular_id = $_POST['to_particular'];
                $modelTrn->type = "C";
                $modelTrn->voucher_type = PAYMENT_VOUCHER;
                $modelTrn->payment_method = PAYMENT_CASH;
                $modelTrn->description = $_POST['note'];
                $modelTrn->note = $_POST['note'];
                $modelTrn->by_whom = User::get_user_info_by_id(Auth::id())->name;
                $modelTrn->amount = round($_POST['amount'], 2);
                $modelTrn->debit = $modelTrn->amount;
                $modelTrn->credit = $modelTrn->amount;
                $modelTrn->is_dbl = 1;
                $modelTrn->created = cur_date_time();
                $modelTrn->created_by = Auth::id();
                $modelTrn->_key = $model->_key;
                if (!$modelTrn->save()) {
                    throw new Exception("Error while updating transaction record.");
                }

                $model->paid_amount = $modelTrn->amount;
                $model->due_amount = round(($model->net_amount - $model->paid_amount), 2);
                $model->payment_status = 'Not Paid';
                if ($model->due_amount == 0) {
                    $model->payment_status = 'Paid';
                }
                if (($model->due_amount > 0) && ($model->due_amount < $model->net_amount)) {
                    $model->payment_status = 'Partial Paid';
                }
                if (!$model->save()) {
                    throw new Exception("Error while updating record.");
                }

                DB::commit();
                return redirect()->back()->with('success', 'Record update successfull.');
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }

        $subhead_list = SubHead::where([['is_deleted', 0], ['institute_id', $_initituteID]])->get();
        $particular_list = Particular::where([['is_deleted', 0], ['institute_id', $_initituteID]])->get();

        $this->model['breadcrumb_title'] = "Sale Return Payment";
        $this->model['model'] = $model;
        $this->model['payment'] = $payment;
        $this->model['subhead_list'] = $subhead_list;
        $this->model['particular_list'] = $particular_list;
        return view('inv.sale_return.payment', $this->model);
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = $r->input('item_count');
        $_status = $r->input('process_status');
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $search = $r->input('srch');
        $_invoice = $r->input('invoice');

        $query = SaleReturn::query();
        $query->where('is_deleted', 0);
        if (!empty($_status)) {
            $query->where('process_status', $_status);
        }
        if (!empty($from_date)) {
            $query->whereBetween('invoice_date', [$from_date, $end_date]);
        }
        if (!empty($search)) {
            $partyQuery = Particular::query();
            $partyQuery->where('is_deleted', 0);
            $partyQuery->where('name', 'like', '%' . trim($search) . '%');
            $partyList = $partyQuery->get();
            $partyID = [];
            foreach ($partyList as $party) {
                $partyID[] = $party->id;
            }
            $query->whereIn('to_particular_id', $partyID);
        }
        if (!empty($_invoice)) {
            $query->where('invoice_no', 'like', '%' . to_eng($_invoice) . '%');
        }
        $query->limit($item_count);
        $query->orderBy("id", "DESC");
        $dataset = $query->paginate($item_count);
        return view('inv.sale_return._list', compact('dataset'));
    }

    public function delete() {
        $resp = array();

        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = SaleReturn::find($id);

                $modelTrn = Transaction::where([['institute_id', institute_id()], ['pst_type', 'inv'], ['sale_return_id', $data->id]])->get();
                if (!empty($modelTrn)) {
                    foreach ($modelTrn as $trn) {
                        //$trn->is_deleted = 1;
                        //$trn->deleted_by = Auth::id();
                        //$trn->deleted_at = cur_date_time();
                        if (!$trn->delete()) {
                            throw new Exception("Error while deliting transaction record.");
                        }
                    }
                }

                $data->process_status = ORDER_PENDING;
                $data->is_deleted = 1;
                $data->deleted_by = Auth::id();
                $data->deleted_at = cur_date_time();
                if (!$data->save()) {
                    throw new Exception("Error while deleting record.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record delete successfull.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    public function delete_cart_item(Request $r) {
        $resp = array();
        $_itemID = $_POST['itemid'];

        DB::beginTransaction();
        try {
            $data = SaleReturnCart::find($_itemID);
            if (!$data->delete()) {
                throw new Exception("Error while deleting record.");
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record delete successfull.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    public function delete_item(Request $r) {
        $resp = array();
        $_itemID = $_POST['itemid'];

        DB::beginTransaction();
        try {
            $data = SaleReturnItem::find($_itemID);
            $data->is_deleted = 1;
            //$data->deleted_by = Auth::id();
            //$data->deleted_at = cur_date_time();
            if (!$data->save()) {
                throw new Exception("Error while deleting record.");
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record delete successfull.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    public function search_product(Request $r) {
        //$this->is_ajax_request(Request $request);
        $_business_type = $r->input('business_type_id');
        $_category = $r->input('category_id');

        $query = Product::query();
        $query->where('is_deleted', 0);
        if (!empty($_business_type)) {
            $query->where('business_type_id', $_business_type);
        }
        if (!empty($_category)) {
            $query->where('category_id', $_category);
        }
        $dataset = $query->get();
        return view('inv.sale_return._product_list', compact('dataset'));
    }

    public function add_to_cart(Request $r) {
        //$this->is_ajax_request(Request $request);
        $resp = array();
        $model = new SaleReturnCart();

        $_dataExists = $model->where([['category_id', $_POST['catid']], ['product_id', $_POST['pid']], ['user_id', Auth::id()]])->first();

        DB::beginTransaction();
        try {
            if ($_dataExists) {
                throw new Exception("This item already exists in cart.");
            }

            $model->institute_id = $_POST['inst_id'];
            $model->business_type_id = $_POST['btid'];
            $model->category_id = $_POST['catid'];
            $model->product_id = $_POST['pid'];
            $model->quantity = $_POST['qty'];
            $model->rate = round($_POST['rate'], 2);
            $model->amount = round($_POST['amount'], 2);
            $model->user_id = Auth::id();
            if (!$model->save()) {
                throw new Exception("Error while adding record to cart.");
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record added to cart successfully.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    public function process(Request $r) {
        //$this->is_ajax_request(Request $request);
        $resp = array();
        $model = SaleReturn::where('_key', $r->_id)->first();

        DB::beginTransaction();
        try {
            foreach ($model->items as $item) {
                $_stock = new Stock();
                $_stock->subhead_id = $model->from_subhead_id;
                $_stock->particular_id = $model->from_particular_id;
                $_stock->stock_type = STOCK_PURCHASE;
                $_stock->sale_return_id = $model->id;
                $_stock->invoice_date = $item->invoice_date;
                $_stock->product_id = $item->product_id;
                $_stock->quantity = $item->quantity;
                if (!$_stock->save()) {
                    throw new Exception("Error while processing stock record.");
                }

                $_stockId = DB::getPdo()->lastInsertId();
                $_avgPriceModel = new AvgPrice();
                $_avgPriceModel->sale_return_id = $model->id;
                $_avgPriceModel->stock_id = $_stockId;
                $_avgPriceModel->product_id = $item->product_id;
                $_avgPriceModel->invoice_date = date("Y-m-d");
                $_avgPriceModel->quantity = $item->quantity;
                $_avgPriceModel->avg_price = round($item->avg_price, 2);
                $_avgPriceModel->total_price = round(($_avgPriceModel->quantity * $_avgPriceModel->avg_price), 2);
                if (!$_avgPriceModel->save()) {
                    throw new Exception("Error while processing avg price record.");
                }

                $_avgTotalPrice = $_avgPriceModel->sum_total_price($item->product_id);
                $_avgTotalQty = $_avgPriceModel->sum_total_qty($item->product_id);
                $_avg_price = round(($_avgTotalPrice / $_avgTotalQty), 2);

                $_product = Product::find($item->product_id);
                $_product->pavg_price = $_avg_price;
                if (!$_product->save()) {
                    throw new Exception("Error while updating product avg price.");
                }
            }

            $modelTrn = new Transaction();
            $modelTrn->institute_id = institute_id();
            $modelTrn->pst_type = "inv";
            $modelTrn->sale_return_id = $model->id;
            $modelTrn->date = $model->invoice_date;
            $modelTrn->cr_head_id = $model->from_head_id;
            $modelTrn->cr_subhead_id = $model->from_subhead_id;
            $modelTrn->cr_particular_id = $model->from_particular_id;
            $modelTrn->dr_head_id = $model->to_head_id;
            $modelTrn->dr_subhead_id = $model->to_subhead_id;
            $modelTrn->dr_particular_id = $model->to_particular_id;
            $modelTrn->type = "D";
            $modelTrn->voucher_type = PURCHASE_VOUCHER;
            $modelTrn->payment_method = PAYMENT_NO;
            $modelTrn->description = $model->note;
            $modelTrn->note = $model->note;
            $modelTrn->by_whom = User::get_user_info_by_id(Auth::id())->name;
            $modelTrn->amount = round($model->total_amount, 2);
            $modelTrn->debit = $modelTrn->amount;
            $modelTrn->credit = $modelTrn->amount;
            $modelTrn->created = cur_date_time();
            $modelTrn->created_by = Auth::id();
            $modelTrn->_key = $model->_key;
            if (!$modelTrn->save()) {
                throw new Exception("Error while processing transaction record.");
            }

            $model->process_status = ORDER_PROCESSED;
            if (!$model->save()) {
                throw new Exception("Error while processing record.");
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record process successfull.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    public function reset(Request $r) {
        //$this->is_ajax_request(Request $request);
        $resp = array();
        $_avgPriceModel = new AvgPrice();

        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $_obj = SaleReturn::find($id);

                if (!empty($_obj->stocks)) {
                    foreach ($_obj->stocks as $_stock) {
                        if (!$_stock->delete()) {
                            throw new Exception("Error while reseting stocks record.");
                        }
                    }
                }

                if (!empty($_obj->avg_price_list)) {
                    foreach ($_obj->avg_price_list as $_avgPrice) {
                        if (!$_avgPrice->delete()) {
                            throw new Exception("Error while reseting avg price list record.");
                        }
                    }
                }

                if (!empty($_obj->items)) {
                    foreach ($_obj->items as $_item) {
                        $_lastAvgPrice = $_avgPriceModel->last_avg_price($_item->product_id);
                        $_product = Product::find($_item->product_id);
                        $_product->pavg_price = !empty($_lastAvgPrice) ? $_lastAvgPrice : NULL;
                        if (!$_product->save()) {
                            throw new Exception("Error while reseting stocks record.");
                        }
                    }
                }

                $modelTrn = Transaction::where([['institute_id', institute_id()], ['pst_type', 'inv'], ['sale_return_id', $_obj->id]])->get();
                if (!empty($modelTrn)) {
                    foreach ($modelTrn as $trn) {
                        if (!$trn->delete()) {
                            throw new Exception("Error while deliting transaction record.");
                        }
                    }
                }

                $_obj->process_status = ORDER_PENDING;
                if (!$_obj->save()) {
                    throw new Exception("Error while reseting record.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record reset successfull.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    // update functions
    public function create_stock() {
        $dataset = SaleReturn::where('process_status', ORDER_PROCESSED)->get();
        pr(count($dataset), false);

        $counter = 0;
        foreach ($dataset as $data) {
            $counter++;
            $_oldStocks = Stock::where('sale_return_id', $data->id)->get();
            //pr($_oldStocks, false);
            if (!empty($_oldStocks)) {
                foreach ($_oldStocks as $_oldStock) {
                    if (!$_oldStock->delete()) {
                        throw new Exception("Error while deliting stock record.");
                    }
                }
            }

            foreach ($data->items as $item) {
                $_stock = new Stock();
                $_stock->subhead_id = $data->from_subhead_id;
                $_stock->particular_id = $data->from_particular_id;
                $_stock->stock_type = STOCK_PURCHASE;
                $_stock->sale_return_id = $data->id;
                $_stock->invoice_date = $item->invoice_date;
                $_stock->product_id = $item->product_id;
                $_stock->quantity = $item->quantity;
                if ($_stock->save()) {
                    echo "{$counter} - ID {$data->id} - new record save success <br>";
                } else {
                    echo "{$counter} - Failed <br>";
                }
            }
        }
        exit;
    }

    public function update_stock() {
        $dataset = SaleReturn::where('process_status', ORDER_PROCESSED)->get();
        pr(count($dataset), false);

        $counter = 0;
        foreach ($dataset as $data) {
            $counter++;
            $_stocks = Stock::where('sale_return_id', $data->id)->get();
            //pr($_stocks, false);
            if (!empty($_stocks)) {
                foreach ($_stocks as $_stock) {
                    $_stock->subhead_id = !empty($data->from_subhead_id) ? $data->from_subhead_id : NULL;
                    $_stock->particular_id = !empty($data->from_particular_id) ? $data->from_particular_id : NULL;
                    if ($_stock->save()) {
                        echo "{$counter} - Success <br>";
                    } else {
                        echo "{$counter} - Failed <br>";
                    }
                }
            } else {
                echo "{$counter}. ID {$data->id} is not found in stock<br>";
            }
        }
        exit;
    }

    public function update_invoice_no() {
        $dataset = SaleReturn::orderBy("id", "asc")->get();
        pr(count($dataset), false);

        $counter = 0;
        foreach ($dataset as $data) {
            $counter++;
            $data->invoice_no = $data->id;
            if ($data->save()) {
                echo "{$counter} - Success <br>";
            } else {
                echo "{$counter} - Failed <br>";
            }
        }
        exit;
    }

}
