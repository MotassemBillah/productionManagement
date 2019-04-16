<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\LedgerHead;
use App\Models\LedgerSubHead;
use App\Models\Transactions;
use App\Models\AccountBalance;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class AccountBalanceController extends HomeController {

    public function index() {
        $dataset = BankAccount::get();
        $bank = new Bank();
        return view('Admin.bank_account.index', compact('dataset', 'bank'));
    }

    public function create($id) {
        $heads = LedgerHead::all();
        $data = BankAccount::where('bank_id', $id)->first();
        return view('Admin.bank_account.ledger_create', compact('heads', 'data'));
    }

    public function store(Request $r) {
        $input = $r->all();
        $rule = array(
            'transaction_date' => 'required',
            'transaction_type' => 'required',
            'check_no' => 'required',
            'head' => 'required',
            'amount' => 'required',
        );
        $messages = array(
            'transaction_type.required' => 'Select a Transaction Type',
            'check_no.required' => 'Check No is Required',
            'head.required' => 'Account No is Required',
            'amount.required' => 'Amount is Requred',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if ($r->transaction_type == 'D') {
            $trans_type = 'C';
            $ac_type = $r->transaction_type;
            $trans_debit = NULL;
            $ac_debit = $r->amount;
            $trans_credit = $r->amount;
            $ac_credit = NULL;
            $voucher_type = PAYMENT_VOUCHER;
        } else {
            $trans_type = 'D';
            $ac_type = 'C';
            $trans_debit = $r->amount;
            $ac_debit = NULL;
            $trans_credit = NULL;
            $ac_credit = $r->amount;
            $voucher_type = RECEIVE_VOUCHER;
        }

        $model = new Transactions();
        $model->type = $trans_type;
        $model->voucher_type = $voucher_type;
        $model->pay_date = date_ymd($r->transaction_date);
        $model->payment_method = 'Bank Payment';
        $model->ledger_head_id = $r->head;
        $model->sub_head_id = $r->subhead;
        $model->bank_account_id = $r->bank_id;
        $model->check_no = $r->check_no;
        $model->by_whom = $r->by_whom;
        $model->description = $r->description;
        $model->debit = $trans_debit;
        $model->credit = $trans_credit;
        $model->amount = $r->amount;
        $model->note = $r->description;
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }
            $transaction_id = DB::getPdo()->lastInsertId();
            $ac_blance = new AccountBalance();
            $ac_blance->transaction_id = $transaction_id;
            $ac_blance->bank_account_id = $model->bank_account_id;
            $ac_blance->head_id = $model->ledger_head_id;
            $ac_blance->subhead_id = $model->sub_head_id;
            $ac_blance->check_no = $model->check_no;
            $ac_blance->type = $ac_type;
            $ac_blance->transaction_date = $model->pay_date;
            $ac_blance->purpose = $model->description;
            $ac_blance->by_whom = $model->by_whom;
            $ac_blance->amount = $model->amount;
            $ac_blance->debit = $ac_debit;
            $ac_blance->credit = $ac_credit;
            $ac_blance->is_edible = 1;
            $ac_blance->created_by = $model->created_by;
            $ac_blance->_key = $model->_key;

            if (!$ac_blance->save()) {
                throw new Exception("Query Problem on Creating Account Balance.");
            }

            DB::commit();
            return redirect("bank-account")->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        $data = AccountBalance::find($id);
        $heads = LedgerHead::all();
        $subheads = new LedgerSubHead();
        return view('Admin.bank_account.ledger_edit', compact('data', 'heads', 'subheads'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rule = array(
            'transaction_date' => 'required',
            'transaction_type' => 'required',
            'check_no' => 'required',
            'head' => 'required',
            'amount' => 'required',
        );
        $messages = array(
            'transaction_type.required' => 'Select a Transaction Type',
            'check_no.required' => 'Check No is Required',
            'head.required' => 'Account No is Required',
            'amount.required' => 'Amount is Requred',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if ($r->transaction_type == 'D') {
            $trans_type = 'C';
            $ac_type = $r->transaction_type;
            $trans_debit = NULL;
            $ac_debit = $r->amount;
            $trans_credit = $r->amount;
            $ac_credit = NULL;
            $voucher_type = PAYMENT_VOUCHER;
        } else {
            $trans_type = 'D';
            $ac_type = 'C';
            $trans_debit = $r->amount;
            $ac_debit = NULL;
            $trans_credit = NULL;
            $ac_credit = $r->amount;
            $voucher_type = RECEIVE_VOUCHER;
        }

        $ac_blance = AccountBalance::find($id);
        $ac_blance->bank_account_id = $r->bank_id;
        $ac_blance->head_id = $r->head;
        $ac_blance->subhead_id = $r->subhead;
        $ac_blance->check_no = $r->check_no;
        $ac_blance->type = $ac_type;
        $ac_blance->transaction_date = date_ymd($r->transaction_date);
        $ac_blance->purpose = $r->description;
        $ac_blance->by_whom = $r->by_whom;
        $ac_blance->amount = $r->amount;
        $ac_blance->debit = $ac_debit;
        $ac_blance->credit = $ac_credit;
        $ac_blance->is_edible = 1;
        $ac_blance->modified_by = Auth::id();

        $model = Transactions::where('id',$ac_blance->transaction_id)->first();
        $model->type = $trans_type;
        $model->voucher_type = $voucher_type;
        $model->pay_date = date_ymd($r->transaction_date);
        $model->payment_method = 'Bank Payment';
        $model->ledger_head_id = $r->head;
        $model->sub_head_id = $r->subhead;
        $model->bank_account_id = $r->bank_id;
        $model->check_no = $r->check_no;
        $model->by_whom = $r->by_whom;
        $model->description = $r->description;
        $model->debit = $trans_debit;
        $model->credit = $trans_credit;
        $model->amount = $r->amount;
        $model->note = $r->description;
        $model->modified_by = Auth::id();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }
            if (!$ac_blance->save()) {
                throw new Exception("Query Problem on Updating Account Balance.");
            }

            DB::commit();
            return redirect("bank-account")->with('success', 'New Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = $r->input('item_count');
        $account_name = $r->input('account_name');
        $account_no = $r->input('account_no');
        $query = BankAccount::query();
        if (!empty($account_name)) {
            $query->where('account_name', 'like', '%' . $account_name . '%');
        }
        if (!empty($account_no)) {
            $query->where('account_number', 'like', '%' . $account_no . '%');
        }
        $query->limit($item_count);
        $dataset = $query->get();
        $bank = new Bank();
        return view('Admin.bank_account._list', compact('dataset', 'bank'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = BankAccount::find($id);
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
