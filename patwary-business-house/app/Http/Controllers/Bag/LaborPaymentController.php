<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Models\LaborPayment;
use App\Models\LaborPaymentItem;
use App\Models\Transaction;
use App\Models\SubHead;
use App\Models\Particular;
use Session;
use Illuminate\Http\Request;

class LaborPaymentController extends HomeController {

    public function index() {
        $dataset = LaborPayment::orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        $subheads = SubHead::where('head_id', HEAD_LABOR_EXPENSE)->get();
        return view('Admin.laborpayment.index', compact('dataset', 'subheads'));
    }

    public function details() {
        $dataset = LaborPaymentItem::orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        $subheads = SubHead::where('head_id', HEAD_LABOR_EXPENSE)->get();
        return view('Admin.laborpayment.ledger', compact('dataset', 'subheads'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $subheads = SubHead::where('head_id', HEAD_LABOR_EXPENSE)->get();
        return view('Admin.laborpayment.create', compact('subheads'));
    }

    public function store(Request $r) {
//        pr($_POST, false);
//        pr(count($_POST['labor']));
        $resp = [];
        DB::beginTransaction();
        try {
            if (empty($_POST['labor'])) {
                throw new Exception("No Labor has been selected. Please Select atleast one Labor.");
            }

            if (!empty($r->subhead_id)) {
                $head_id = SubHead::find($r->subhead_id)->head_id;
            } else {
                $head_id = NULL;
            }

            $model = new LaborPayment();
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->head_id = $head_id;
            $model->subhead_id = $r->subhead_id;
            $model->shift = $r->shift;
            $model->no_of_labor = count($_POST['labor']);
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating Record.");
            }

            $last_id = DB::getPdo()->lastInsertId();
            $total_price = [];
            if (!empty($_POST['labor'])) {
                foreach ($_POST['labor'] as $key => $value) {
                    if (!empty($_POST['labor'][$key])) {
                        $modelItem = new LaborPaymentItem();
                        $modelItem->labor_payment_id = $last_id;
                        $modelItem->date = $model->date;
                        $modelItem->head_id = $model->head_id;
                        $modelItem->subhead_id = $model->subhead_id;
                        $modelItem->particular_id = $_POST['particular_id'][$value];
                        $modelItem->net_price = $_POST['net_price'][$value];
                        $modelItem->created_by = $model->created_by;
                        $modelItem->_key = uniqueKey() + $key;
                        if (!$modelItem->save()) {
                            throw new Exception("Error! while creating Record items.");
                        }
                        $total_price[] = $modelItem->net_price;

                        $modelTrans = new Transaction();
                        $modelTrans->labor_payment_id = $last_id;
                        $modelTrans->pay_date = $model->date;
                        $modelTrans->voucher_type = DUE_VOUCHER;
                        $modelTrans->payment_method = PAYMENT_NO;
                        $modelTrans->dr_head_id = HEAD_ACCOUNT_PAYABLE;
                        $modelTrans->dr_subhead_id = NULL;
                        $modelTrans->dr_particular_id = NULL;
                        $modelTrans->cr_head_id = HEAD_LABOR_EXPENSE;
                        $modelTrans->cr_subhead_id = $r->subhead_id;
                        $modelTrans->cr_particular_id = $_POST['particular_id'][$value];
                        $modelTrans->by_whom = Auth::user()->name;
                        $modelTrans->description = "Payment on Credit";
                        $modelTrans->debit = $_POST['net_price'][$value];
                        $modelTrans->credit = $modelTrans->debit;
                        $modelTrans->amount = $modelTrans->debit;
                        $modelTrans->note = $modelTrans->description;
                        $modelTrans->created_by = $model->created_by;
                        $modelTrans->_key = uniqueKey() + $key;
                        if (!$modelTrans->save()) {
                            throw new Exception("Error! while creating Record items.");
                        }
                    }
                }
            }

            $model->total_price = array_sum($total_price);
            $model->save();

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record has been Inserted Successfully!';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function show($id) {
        $data = LaborPayment::find($id);
        return view('Admin.laborpayment.details', compact('data'));
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $subheads = SubHead::where('head_id', HEAD_LABOR_EXPENSE)->get();
        $data = LaborPayment::find($id);
        return view('Admin.laborpayment.edit', compact('data', 'subheads'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'date' => 'required',
            'subhead_id' => 'required',
            'shift' => 'required',
        );
        $messages = array(
            'shift.required' => 'Please Select Duty Shift.',
            'subhead_id' => 'Please Select Labor Type',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            if (empty($_POST['labor'])) {
                throw new Exception("No Labor has been selected. Please Select atleast one Labor.");
            }

            if (!empty($r->subhead_id)) {
                $head_id = SubHead::find($r->subhead_id)->head_id;
            } else {
                $head_id = NULL;
            }

            $model = LaborPayment::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->head_id = $head_id;
            $model->subhead_id = $r->subhead_id;
            $model->shift = $r->shift;
            $model->no_of_labor = count($_POST['labor']);
            $model->modified_by = Auth::id();
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            $total_price = [];
            $exist_payment = $model->items()->delete();
            $exist_trans = $model->transaction()->delete();
            if (!empty($_POST['labor'])) {
                foreach ($_POST['labor'] as $key => $value) {
                    if (!empty($_POST['labor'][$key])) {
                        $modelItem = new LaborPaymentItem ();
                        $modelItem->labor_payment_id = $id;
                        $modelItem->date = $model->date;
                        $modelItem->head_id = $model->head_id;
                        $modelItem->subhead_id = $model->subhead_id;
                        $modelItem->particular_id = $_POST['particular_id'][$value];
                        $modelItem->net_price = $_POST['net_price'][$value];
                        $modelItem->created_by = $model->modified_by;
                        $modelItem->_key = uniqueKey() + $key;
                        if (!$modelItem->save()) {
                            throw new Exception("Error! while creating Record items.");
                        }
                        $total_price[] = $modelItem->net_price;

                        $modelTrans = new Transaction ();
                        $modelTrans->labor_payment_id = $id;
                        $modelTrans->pay_date = $model->date;
                        $modelTrans->voucher_type = DUE_VOUCHER;
                        $modelTrans->payment_method = PAYMENT_NO;
                        $modelTrans->dr_head_id = HEAD_ACCOUNT_PAYABLE;
                        $modelTrans->dr_subhead_id = NULL;
                        $modelTrans->dr_particular_id = NULL;
                        $modelTrans->cr_head_id = HEAD_LABOR_EXPENSE;
                        $modelTrans->cr_subhead_id = $r->subhead_id;
                        $modelTrans->cr_particular_id = $_POST['particular_id'][$value];
                        $modelTrans->by_whom = Auth::user()->name;
                        $modelTrans->description = "Payment on Credit";
                        $modelTrans->debit = $_POST['net_price'][$value];
                        $modelTrans->credit = $modelTrans->debit;
                        $modelTrans->amount = $modelTrans->debit;
                        $modelTrans->note = $modelTrans->description;
                        $modelTrans->created_by = $model->modified_by;
                        $modelTrans->_key = uniqueKey() + $key;
                        if (!$modelTrans->save()) {
                            throw new Exception("Error! while creating Record items.");
                        }
                    }
                }
            }

            $model->total_price = array_sum($total_price);
            $model->save();

            DB::commit();
            return redirect('laborpayment')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $shift = $r->shift;
        $labor_type = $r->search_head;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');

        $query = LaborPayment::query();
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($shift)) {
            $query->where('shift', $shift);
        }
        if (!empty($labor_type)) {
            $query->where('subhead_id', $labor_type);
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('Admin.laborpayment._list', compact('dataset'));
    }

    public function details_search(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $shift = $r->shift;
        $labor_type = $r->search_head;
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');

        $query = LaborPaymentItem::query();
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($shift)) {
            $oid = LaborPayment::where('shift', $shift)->first();
            if (!empty($oid)) {
                $query->where('labor_payment_id', $oid->id);
            }
        }
        if (!empty($labor_type)) {
            $query->where('subhead_id', $labor_type);
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('Admin.laborpayment.ledger_search', compact('dataset'));
    }

    public function get_labor_list(Request $r) {
        $dataset = Particular::where('subhead_id', $r->id)->get();
        return view('Admin.laborpayment.labor_list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = LaborPayment::with('items', 'transaction')->find($id);

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
            $resp['message'] = 'Records deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
