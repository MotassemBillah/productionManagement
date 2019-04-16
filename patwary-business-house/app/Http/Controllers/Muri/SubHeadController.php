<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Transaction;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class SubHeadController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = SubHead::where('is_deleted', 0)->orderBy('name', 'ASC')->paginate($this->getSettings()->pagesize);
        $head_set = Head::all();
        $tmodel = new Transaction();
        return view('Admin.subhead.index', compact('dataset', 'head_set', 'tmodel'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $head_set = Head::all();
        return view('Admin.subhead.create', compact('head_set'));
    }

    public function store(Request $r) {
        //check_user_access('supplier_create');
        $head_id = $r->head_id;
        DB::beginTransaction();
        try {
            foreach ($_POST['name'] as $key => $value) {
                $model = new SubHead();

                if (empty($_POST['head_id'])) {
                    throw new Exception("Head is Required");
                }
                if (empty($_POST['name'][$key])) {
                    throw new Exception("Sub Head Name is Required");
                }
                $model->head_id = $head_id;
                $model->name = $value;
                $model->code = time() + $key;
                $model->is_edible = 1;
                $model->_key = uniqueKey() . $key;

                if (!$model->save()) {
                    throw new Exception("Error while Creating Sub Heads.");
                }
            }

            DB::commit();
            return redirect('/subhead')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = SubHead::find($id);
        $head_set = Head::all();
        return view('Admin.subhead.edit', compact('data', 'head_set'));
    }

    public function update(Request $r, $id) {
        // check_user_access('supplier_update');
        $input = $r->all();
        $rule = array(
            'head_id' => 'required',
            'name' => 'required',
        );
        $messages = array(
            'head_id.required' => 'Head must be selected.',
            'name.required' => 'Name Should not be empty.',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = SubHead::find($id);
        $data->head_id = $r->input('head_id');
        $data->name = $r->input('name');

        DB::beginTransaction();
        try {
            if (!$data->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('subhead')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $head_id = $r->input('head_id');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = SubHead::where('is_deleted', 0);
        if (!empty($head_id)) {
            $query->where('head_id', '=', $head_id);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy('name', 'ASC');
        $dataset = $query->paginate($item_count);
        $tmodel = new Transaction();
        return view('Admin.subhead._list', compact('dataset', 'tmodel'));
    }

    public function delete() {
        $resp = array();
        $tmodel = new Transaction();
        
        DB::beginTransaction();        
        try {
            foreach ($_POST['data'] as $id) {
                $existTrans = $tmodel->where('dr_subhead_id', $id)->orWhere('cr_subhead_id', $id)->first();
                if (!empty($existTrans)) {
                    throw new Exception("Warning! One or More Transaction Exist. Please Delete Transaction First.");
                }
                
                $data = SubHead::with('particular')->find($id);
                if (!empty($data->particular)) {
                    foreach ($data->particular as $item) {
                        $existpartTrans = $tmodel->where('dr_particular_id', $item->id)->orWhere('cr_particular_id', $item->id)->first();
                        if (!empty($existpartTrans)) {
                            throw new Exception("Warning! One or More Transaction Exist. Please Delete Transaction First.");
                        }
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Particular.");
                        }
                    }
                }
                
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'SubHead has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        
        return $resp;
    }

    public function get_sub_head(Request $r) {
        $dataset = SubHead::where('head_id', $r->head)->get();
        $str = [];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value=''>'Select '</option>";
                $str[] = "<option value='$data->id'>{$data->name}</option>";
            }
            return $str;
        }
    }

    public function get_particular(Request $r) {
        $dataset = Particular::where('subhead_id', $r->head)->get();
        $str = ["<option value=''>Select sub head</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id' data-mon='$data->mon'>{$data->name}</option>";
            }
            return $str;
        }
    }

}
