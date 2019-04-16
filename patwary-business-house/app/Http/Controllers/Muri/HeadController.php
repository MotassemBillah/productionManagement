<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Agent;
use App\Models\Head;
use App\Models\Transaction;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class HeadController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = Head::get();
        $tmodel = new Transaction();
        return view('Admin.head.index', compact('dataset', 'tmodel'));
    }

    public function create() {
        check_user_access('manage_head');
        return view('Admin.head.create');
    }

    public function store(Request $r) {
        check_user_access('manage_head');
        DB::beginTransaction();
        try {
            foreach ($_POST['name'] as $key => $value) {
                $model = new Head();
                if (empty($_POST['name'][$key])) {
                    throw new Exception("Head Name is Required");
                }
                $model->name = $value;
                $model->code = time() + $key;
                $model->_key = uniqueKey() . $key;

                if (!$model->save()) {
                    throw new Exception("Error while Creating Heads.");
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
        $dataset = Head::find($id);
        return view('Admin.head.ledger', compact('dataset'));
    }

    public function edit($id) {
         check_user_access('manage_head');
        $data = Head::find($id);
        return view('Admin.head.edit', compact('data'));
    }

    public function update(Request $r, $id) {
          check_user_access('manage_head');
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
        $item_count = $r->input('item_count');
        $sort_by = 'name';
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = Head::query();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $dataset = $query->get();
        $tmodel = new Transaction();
        return view('Admin.head._list', compact('dataset', 'tmodel'));
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

                        if (!empty($item->particular)) {
                            foreach ($item->particular as $pt) {
                                $existPartTrans = $tmodel->where('dr_particular_id', $pt->id)->orWhere('cr_particular_id', $pt->id)->first();
                                if (!empty($existPartTrans)) {
                                    throw new Exception("Warning! One or More Transaction Exist. Please Delete Transaction First.");
                                }
                                if (!$pt->delete()) {
                                    throw new Exception("Error while deleting records from Particular.");
                                }
                            }
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
