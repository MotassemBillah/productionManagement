<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Transaction;
use App\Models\EmptyBag;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class ParticularController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = Particular::where('is_deleted', 0)->orderBy('name', 'ASC')->paginate($this->getSettings()->pagesize);
        $tmodel = new Transaction();
        $emptyBag = new EmptyBag();
        $subhead = SubHead::all();
        return view('Admin.particular.index', compact('dataset', 'tmodel', 'subhead', 'emptyBag'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $subhead_set = SubHead::all();
        return view('Admin.particular.create', compact('subhead_set'));
    }

    public function create_particular($id) {
        //check_user_access('supplier_create');
        $subhead_set = SubHead::all();
        $id = $id;
        return view('Admin.particular.create', compact('subhead_set', 'id'));
    }

    public function store(Request $r) {
        $input = $r->all();
        $rule = array(
            'subhead' => 'required',
            'name' => 'required',
        );
        $messages = array(
            'subhead.required' => 'Sub Head must be selected.',
            'name.required' => 'Name Should not be empty.',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $head = SubHead::find($r->subhead)->head->id;

        $model = new Particular();
        $model->head_id = $head;
        $model->subhead_id = $r->subhead;
        $model->name = $r->name;
        $model->company_name = $r->company_name;
        $model->mobile = $r->mobile;
        $model->mon = $r->mon;
        $model->commission = $r->commission;
        $model->address = $r->address;
        $model->code = time();
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            if (!empty($r->id)) {
                if ($r->id == 'p') {
                    return redirect('/purchases/create')->with('success', 'New Record Created Successfully.');
                } else if ($r->id == 'c') {
                    return redirect('/purchase-challan/create')->with('success', 'New Record Created Successfully.');
                } else {
                    return redirect('/sales/create')->with('success', 'New Record Created Successfully.');
                }
            } else {
                return redirect('/particular')->with('success', 'New Record Created Successfully.');
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Particular::find($id);
        $subhead_set = SubHead::all();
        return view('Admin.particular.edit', compact('data', 'subhead_set'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rule = array(
            'subhead' => 'required',
            'name' => 'required',
        );
        $messages = array(
            'subhead.required' => 'Sub Head must be selected.',
            'name.required' => 'Name Should not be empty.',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $head = SubHead::find($r->subhead)->head->id;

        $model = Particular::find($id);
        $model->head_id = $head;
        $model->subhead_id = $r->subhead;
        $model->name = $r->name;
        $model->company_name = $r->company_name;
        $model->mobile = $r->mobile;
        $model->mon = $r->mon;
        $model->commission = $r->commission;
        $model->address = $r->address;
        $model->modified_by = Auth::id();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }
            DB::commit();
            return redirect('particular')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $head_id = $r->input('subhead_id');
        $sort_by = 'name';
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = Particular::query();
        if (!empty($head_id)) {
            $query->where('subhead_id', '=', $head_id);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $dataset = $query->paginate($item_count);
        $subhead = SubHead::all();
        $tmodel = new Transaction();
        $emptyBag = new EmptyBag();
        return view('Admin.particular._list', compact('dataset', 'tmodel', 'subhead', 'emptyBag'));
    }

    public function delete() {
        $resp = array();
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

}
