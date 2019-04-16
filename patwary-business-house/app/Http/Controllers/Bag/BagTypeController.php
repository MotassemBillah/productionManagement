<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\BagType;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class BagTypeController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = BagType::get();
        return view('Admin.bagtype.index', compact('dataset'));
    }

    public function create() {
        return view('Admin.bagtype.create');
    }

    public function store(Request $r) {
        DB::beginTransaction();
        try {
            foreach ($_POST['name'] as $key => $value) {
                $model = new BagType();
                if (empty($_POST['name'][$key])) {
                    throw new Exception("BagType Name is Required");
                }
                $model->name = $value;

                if (!$model->save()) {
                    throw new Exception("Error while Creating BagTypes.");
                }
            }

            DB::commit();
            return redirect('/bagtype')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show($id) {
       
    }

    public function edit($id) {
        $data = BagType::find($id);
        return view('Admin.bagtype.edit', compact('data'));
    }

    public function update(Request $r, $id) {
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

        $data = BagType::find($id);
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
        $item_count = $r->input('item_count');
        $sort_by = 'name';
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = BagType::query();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $dataset = $query->get();
        return view('Admin.bagtype._list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();

        try {
            foreach ($_POST['data'] as $id) {
                $data = BagType::find($id);
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Bag Size has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
