<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Transaction;
use App\Models\Institute;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class ParticularController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $insList = Institute::get();
        $model = new Particular();
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $tmodel = new Transaction();
        $subheads = SubHead::where('institute_id', institute_id())->get();
        return view('institute.particular.index', compact('dataset', 'subheads', 'tmodel', 'insList'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $insList = Institute::get();
        $subheads = SubHead::where('institute_id', institute_id())->get();
        return view('institute.particular.create', compact('subheads', 'insList'));
    }

    public function store(Request $r) {
        //check_user_access('supplier_create');
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'subhead_id' => 'required',
            'name' => 'required',
        );
        $messages = array(
            'subhead_id.required' => 'Sub Head must be selected.',
            'name.required' => 'Name Should not be empty.',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $head = SubHead::find($r->subhead_id)->head_id;
        $model = new Particular();
        $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
        $model->head_id = $head;
        $model->subhead_id = $r->subhead_id;
        $model->name = $r->name;
        $model->company_name = $r->company_name;
        $model->mobile = $r->mobile;
        $model->account_type = $r->account_type;
        $model->cc_loan_amount = $r->cc_loan_amount;
        $model->address = $r->address;
        $model->code = time();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (is_Admin()) {
                if (empty($r->institute_id)) {
                    throw new Exception("Please select a Branch");
                }
            }
            if (!$model->save()) {
                throw new Exception("Error while Creating Records.");
            }

            DB::commit();
            return redirect('/particulars')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Particular::where('_key', $id)->first();
        $heads = SubHead::all();
        return view('institute.particular.edit', compact('data', 'heads'));
    }

    public function update(Request $r, $id) {
        // check_user_access('supplier_update');
        $input = $r->all();
        $rule = array(
            'name' => 'required',
            'subhead_id' => 'required',
        );
        $messages = array(
            'name.required' => 'Name Should not be empty.',
            'subhead_id.required' => 'Please select a subhead.',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = Particular::find($id);
        $data->name = $r->name;
        $data->subhead_id = $r->subhead_id;
        $data->company_name = $r->company_name;
        $data->mobile = $r->mobile;
        $data->account_type = $r->account_type;
        $data->cc_loan_amount = $r->cc_loan_amount;
        $data->address = $r->address;

        DB::beginTransaction();
        try {
            if (!$data->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('particulars')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $model = new Particular();
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $subhead = $r->subhead_id;
        $institute = $r->institute_id;
        $search = $r->input('search');
        //$sort_by = 'name';
        $sort_type = $r->sort_type;
        $query = is_Admin() ? $model->where('id', '!=', 0) : $model->where('institute_id', institute_id());
        if (!empty($institute)) {
            $query->where('institute_id', $institute);
        }
        if (!empty($subhead)) {
            $query->where('subhead_id', $subhead);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        // $query->orderBy($sort_by, $sort_type);
        $dataset = $query->paginate($item_count);
        $tmodel = new Transaction();
        return view('institute.particular._list', compact('dataset', 'tmodel'));
    }

    public function delete() {
        $resp = array();
        $tmodel = new Transaction();

        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $existTrans = Transaction::where('dr_particular_id', $id)->orWhere('cr_particular_id', $id)->first();
                if (!empty($existTrans)) {
                    throw new Exception("Warning! One or More Transaction Exist. Please Delete Transaction First.");
                }
                $data = Particular::find($id);
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Particular has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }

        return $resp;
    }

    public function get_sub_head(Request $r) {
        $dataset = SubHead::where('head_id', $r->head)->get();
        $str = ["<option value=''>Select Sub Head</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->name}</option>";
            }
            return $str;
        }
    }

    public function get_particular(Request $r) {
        $dataset = Particular::where('subhead_id', $r->head)->get();
        $str = ["<option value=''>Select Particular</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->name} ({$data->address})</option>";
            }
            return $str;
        }
    }

}
