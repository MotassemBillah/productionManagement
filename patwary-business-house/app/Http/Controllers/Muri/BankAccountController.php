<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\AccountBalance;
use App\Models\LedgerHead;
use App\Models\LedgerSubHead;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class BankAccountController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = BankAccount::get();
        $bank = new Bank();
        return view('Admin.bank_account.index', compact('dataset', 'bank'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $banks = Bank::all();
        $batypes = bank_account_type_list();
        return view('Admin.bank_account.create', compact('banks', 'batypes'));
    }

    public function store(Request $r) {
        //check_user_access('supplier_create');
        $input = $r->all();
        $rule = array(
            'bank_id' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
        );
        $messages = array(
            'bank_id.required' => 'Please Select a Bank',
            'account_name.required' => 'Account Name is Required',
            'account_no.required' => 'Account No is Required',
            'account_type.required' => 'Please Select a Account Type',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new BankAccount();
        $model->bank_id = $r->bank_id;
        $model->manager_mobile = $r->manager_no;
        $model->account_name = $r->account_name;
        $model->account_number = $r->account_no;
        $model->account_type = $r->account_type;
        $model->address = $r->address;
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('/bank-account')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = BankAccount::find($id);
        $banks = Bank::all();
        $batypes = bank_account_type_list();
        return view('Admin.bank_account.edit', compact('data', 'banks', 'batypes'));
    }
    
    public function ledger($id) {
        //pr($id);
        $bank_info = BankAccount::find($id);
        $head = new LedgerHead();
        $subhead = new LedgerSubHead();
        $dataset = $bank_info->balances;
        $ac_balance = new AccountBalance();
        return view('Admin.bank_account.ledger', compact('dataset', 'bank_info', 'ac_balance','head','subhead'));
    }

    public function update(Request $r, $id) {
        // check_user_access('supplier_update');
        $input = $r->all();
        $rule = array(
            'bank_id' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
        );
        $messages = array(
            'bank_id.required' => 'Please Select a Bank',
            'account_name.required' => 'Account Name is Required',
            'account_no.required' => 'Account No is Required',
            'account_type.required' => 'Please Select a Account Type',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = BankAccount::find($id);
        $model->bank_id = $r->bank_id;
        $model->manager_mobile = $r->manager_no;
        $model->account_name = $r->account_name;
        $model->account_number = $r->account_no;
        $model->account_type = $r->account_type;
        $model->address = $r->address;
        $model->modified_by = Auth::id();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('/bank-account')->with('success', 'Record Updated Successfully.');
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
