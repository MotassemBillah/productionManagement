<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\Head;
use App\Models\Field;
use App\Models\SubHead;
use App\Models\BusinessType;
use App\Models\UnloadingCart;
use App\Models\Mill;
use App\Models\Stock;
use App\Models\RawBrick;
use App\Models\Category;
use App\Models\Chamber;
use App\Models\RawBrickField;
use App\Models\AccCustomer;
use App\Models\RawBrickItem;
use App\Models\ChapterLoading;
use App\Models\Transaction;
use App\Models\Unloading;
use Validator;
use Auth;
use DB;

class InstituteController extends Controller {

    public function index() {
        $model = new Institute();
        //$dataset = $model->where('id', '!=', institute_id())->get();
        $dataset = $model->get();
        return view('institute.institute.index', compact('dataset'));
    }

    public function create() {
        $business_type = BusinessType::all();
        return view('institute.institute.create', compact('business_type'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'name' => 'required',
            'business_type' => 'required',
            'email' => 'required|string|email|max:255|unique:institutes',
        );

        $messages = array(
            'name.required' => 'Please Provide Institute Name.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $insert_data = array(
            'name' => $r->input('name'),
            'business_type_id' => $r->input('business_type'),
            'address' => $r->input('address'),
            'phone' => $r->input('phone'),
            'mobile' => $r->input('mobile'),
            'email' => $r->input('email'),
            'website' => $r->input('website'),
            'created_by' => Auth::id(),
            '_key' => uniqueKey(),
        );

        $default_institute_access_items = default_institute_access_items();
        $items = json_encode($default_institute_access_items);

        $institute_permissiion = array(
            'permissions' => $items,
            '_key' => $insert_data['_key'],
        );

        $setting = array(
            'title' => $insert_data['name'],
            'address' => $insert_data['address'],
            'email' => $insert_data['email'],
            'mobile' => $insert_data['mobile'],
            'phone' => $insert_data['phone'],
            'copyright' => "Copyright © " . date('Y') . " Protected. All Rights Reserved," . $insert_data['name'],
            'created_by' => Auth::id(),
            '_key' => $insert_data['_key'],
        );

        DB::beginTransaction();
        try {
            $create_institute = DB::table('institutes')->insert($insert_data);
            if (!$create_institute) {
                throw new Exception("Query Problem on Creating Institute");
            }

            $institute_id = DB::getPdo()->lastInsertId();

            $institute_permissiion ['institute_id'] = $institute_id;
            $create_permission = DB::table('institute_permissions')->insert($institute_permissiion);
            if (!$create_permission) {
                throw new Exception("Query Problem on Creating Permission");
            }

            $setting ['institute_id'] = $institute_id;
            $create_setting = DB::table('general_settings')->insert($setting);
            if (!$create_setting) {
                throw new Exception("Query Problem on Creating Settings");
            }

            DB::commit();
            return redirect('institute')->with('success', 'New Institute has been Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        $business_type = BusinessType::all();
        $data = Institute::where('_key', $id)->first();
        return view('institute.institute.edit', compact('data', 'business_type'));
    }

    public function update(Request $r, $id) {
        //pr($_POST,false);
        $input = $r->all();
        $rules = array(
            'name' => 'required',
            'business_type' => 'required',
            'email' => 'required|unique:institutes,email,' . $id,
        );

        $messages = array(
            'name.required' => 'Please Provide Institute Name.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $update_data = array(
            'name' => $r->input('name'),
            'address' => $r->input('address'),
            'business_type_id' => $r->input('business_type'),
            'phone' => $r->input('phone'),
            'mobile' => $r->input('mobile'),
            'email' => $r->input('email'),
            'website' => $r->input('website'),
            'created_by' => Auth::id()
        );

        $update_institute = DB::table('institutes')->where('id', $id)->update($update_data);

        return redirect('institute')->with('success', 'Institute Information Updated Successfully.');
    }

    public function show($id) {
        $data = Institute::where('_key', $id)->first();
        return view('institute.institute.view', compact('data'));
    }

    public function institute_access_by_id($id) {
        check_user_access('institute_access');
        $data = Institute::where('_key', $id)->first();
        return view('institute.institute.access', compact('data'));
    }

    public function get_institute_by_type(Request $r) {
        $type = $r->type;
        $dataset = Institute::where([['type', $type], ['status', 1]])->get();
        $str = [];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->name}</option>";
            }
            return $str;
        }
    }

//    public function update_institute_access_by_id(Request $r) {
//        pr($_POST);
//        check_user_access('institute_access');
//        $institute_id = $r->input('institute_id');
//        $new_access = $r->input('access');
//        $access_item = json_encode($new_access);
//        $items = array(
//            'permissions' => $access_item,
//        );
//        $update_access_item = DB::table('institute_permissions')->where('institute_id', '=', $institute_id)->update($items);
//        return redirect('institute')->with('success', 'Institute Permission has been Updated Successfully.');
//    }

    public function update_institute_access_by_id(Request $r) {
        //pr($_POST);
        check_user_access('institute_access');
        $institute_id = $r->input('institute_id');
        $new_access = $r->input('access');
        $access_item = json_encode($new_access);
        $items = array(
            'permissions' => $access_item,
        );
        $update_access_item = DB::table('institute_permissions')->where('institute_id', '=', $institute_id)->update($items);
        return redirect('institute')->with('success', 'Institute Permission has been Updated Successfully.');
    }

    public function get_head(Request $r) {
        $dataset = Head::where('institute_id', $r->institute)->get();
        $str = ["<option value=''>Select Head</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->name}</option>";
            }
            return $str;
        }
    }

    public function get_subhead(Request $r) {
        $dataset = SubHead::where('institute_id', $r->institute)->get();
        $str = ["<option value=''>Select Sub Head</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->name}</option>";
            }
            return $str;
        }
    }

    public function get_ledger(Request $r) {
        $institute_id = $r->institute;
        $dataset = Head::where('institute_id', $institute_id)->get();
        $tmodel = new Transaction();
        return view('institute.ledger._ledger', compact('dataset', 'institute_id', 'tmodel'));
    }

    /*
     * Function added by "Rakib Hasan"
     * loading head, subhead, particular,
     * bank, bank branch, bank account,
     * customer, supplier, employee, party
     * according to @institute_id
     */

    public function get_all_component(Request $r) {
        $_data = [];
        $_headSet = \App\Models\AccHead::where('institute_id', $r->institute)->get();
        $_data['heads'] = ["<option value=''>Select Head</option>"];
        if (!empty($_headSet)) {
            foreach ($_headSet as $_head) {
                $_data['heads'][] = "<option value='{$_head->id}'>{$_head->name}</option>";
            }
        }

        $_subheadSet = \App\Models\AccSubhead::where('institute_id', $r->institute)->get();
        $_data['subheads'] = ["<option value=''>Select Subhead</option>"];
        if (!empty($_subheadSet)) {
            foreach ($_subheadSet as $_subhead) {
                $_data['subheads'][] = "<option value='{$_subhead->id}'>{$_subhead->name}</option>";
            }
        }

        $_particularSet = \App\Models\AccParticular::where('institute_id', $r->institute)->get();
        $_data['particulars'] = ["<option value=''>Select Particular</option>"];
        if (!empty($_particularSet)) {
            foreach ($_particularSet as $_particular) {
                $_data['particulars'][] = "<option value='{$_particular->id}'>{$_particular->name}</option>";
            }
        }

        $_bankSet = \App\Models\AccBank::where('institute_id', $r->institute)->get();
        $_data['banks'] = ["<option value=''>Select Bank</option>"];
        if (!empty($_bankSet)) {
            foreach ($_bankSet as $_bank) {
                $_data['banks'][] = "<option value='{$_bank->id}'>{$_bank->name}</option>";
            }
        }

        $_branchSet = \App\Models\AccBankBranch::where('institute_id', $r->institute)->get();
        $_data['branches'] = ["<option value=''>Select Branch</option>"];
        if (!empty($_branchSet)) {
            foreach ($_branchSet as $_branch) {
                $_data['branches'][] = "<option value='{$_branch->id}'>{$_branch->name}</option>";
            }
        }

        $_accountSet = \App\Models\AccBankAccount::where('institute_id', $r->institute)->get();
        $_data['accounts'] = ["<option value=''>Select Account</option>"];
        if (!empty($_accountSet)) {
            foreach ($_accountSet as $_account) {
                $_data['accounts'][] = "<option value='{$_account->id}'>{$_account->name} - {$_account->account_number}</option>";
            }
        }

        $_customerSet = \App\Models\AccCustomer::where('institute_id', $r->institute)->get();
        $_data['customers'] = ["<option value=''>Select Customer</option>"];
        if (!empty($_customerSet)) {
            foreach ($_customerSet as $_customer) {
                if ($_customer->is_deleted == 0) {
                    $_data['customers'][] = "<option value='{$_customer->id}'>{$_customer->name}</option>";
                }
            }
        }

        $_supplierSet = \App\Models\AccSupplier::where('institute_id', $r->institute)->get();
        $_data['suppliers'] = ["<option value=''>Select Supplier</option>"];
        if (!empty($_supplierSet)) {
            foreach ($_supplierSet as $_supplier) {
                if ($_supplier->is_deleted == 0) {
                    $_data['suppliers'][] = "<option value='{$_supplier->id}'>{$_supplier->name}</option>";
                }
            }
        }

        $_employeeSet = \App\Models\AccEmployee::where('institute_id', $r->institute)->get();
        $_data['employees'] = ["<option value=''>Select Employee</option>"];
        if (!empty($_employeeSet)) {
            foreach ($_employeeSet as $_employee) {
                if ($_employee->is_deleted == 0) {
                    $_data['employees'][] = "<option value='{$_employee->id}'>{$_employee->name}</option>";
                }
            }
        }

        $_partySet = \App\Models\AccParty::where('institute_id', $r->institute)->get();
        $_data['parties'] = ["<option value=''>Select Party</option>"];
        if (!empty($_partySet)) {
            foreach ($_partySet as $_party) {
                if ($_party->is_deleted == 0) {
                    $_data['parties'][] = "<option value='{$_party->id}'>{$_party->name}</option>";
                }
            }
        }

        return $_data;
    }

}
