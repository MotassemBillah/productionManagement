<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Head;
use App\Models\Transaction;
use App\Models\Institute;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class HeadController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $insList = Institute::get();
        $model = new Head();
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $tmodel = new Transaction();
        return view('institute.head.index', compact('dataset', 'tmodel', 'insList'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $insList = Institute::get();
        return view('institute.head.create', compact('insList'));
    }

    public function store(Request $r) {

        DB::beginTransaction();
        try {
            foreach ($_POST['name'] as $key => $value) {
                $model = new Head();
                if (is_Admin()) {
                    if (empty($r->institute_id)) {
                        throw new Exception("Please select a Branch");
                    }
                }
                if (empty($_POST['name'][$key])) {
                    throw new Exception("Head Name is Required");
                }
                $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
                $model->name = $value;
                $model->code = time() + $key;
                $model->_key = uniqueKey() . $key;

                if (!$model->save()) {
                    throw new Exception("Error while Creating Records.");
                }
            }

            DB::commit();
            return redirect('/head')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show($id) {
        $dataset = Head::where('_key', $id)->first();
        return view('Admin.head.ledger', compact('dataset'));
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Head::where('_key', $id)->first();
        return view('institute.head.edit', compact('data'));
    }

    public function update(Request $r, $id) {
        // check_user_access('supplier_update');
        $input = $r->all();
        $rule = array(
            'name' => 'required',
        );
        $messages = array(
            'name.required' => 'Name Should not be empty.',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = Head::find($id);
        $data->name = $r->input('name');

        DB::beginTransaction();
        try {
            if (!$data->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect()->back()->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $model = new Head();
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $institute = $r->institute_id;
        $search = $r->input('search');
        $sort_by = 'name';
        $sort_type = $r->sort_type;
        $query = is_Admin() ? $model->where('id', '!=', 0) : $model->where('institute_id', institute_id());
        if (!empty($institute)) {
            $query->where('institute_id', $institute);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $dataset = $query->paginate($item_count);
        $tmodel = new Transaction();
        return view('institute.head._list', compact('dataset', 'tmodel'));
    }

    public function delete() {
        $resp = array();
        $tmodel = new Transaction();
        DB::beginTransaction();

        try {
            foreach ($_POST['data'] as $id) {
                $existHeadTrans = $tmodel->where('dr_head_id', $id)->orWhere('cr_head_id', $id)->first();
                if (!empty($existHeadTrans)) {
                    throw new Exception("Warning! One or More Transaction Exist. Please Delete Transaction First.");
                }
                $data = Head::with('subhead')->find($id);
                if (!empty($data->subhead)) {
                    foreach ($data->subhead as $item) {
                       $existsubHeadTrans = $tmodel->where('dr_subhead_id', $item->id)->orWhere('cr_subhead_id', $item->id)->first();
                        if (!empty($existsubHeadTrans)) {
                            throw new Exception("Warning! One or More Transaction Exist. Please Delete Transaction First.");
                        }
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from subhead.");
                        }
                    }
                }

                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Head has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
