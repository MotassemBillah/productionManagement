<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\BagSize;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class BagSizeController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = BagSize::get();
        return view('Admin.bagsize.index', compact('dataset'));
    }

    public function create() {
        return view('Admin.bagsize.create');
    }

    public function store(Request $r) {
        DB::beginTransaction();
        try {
            foreach ($_POST['name'] as $key => $value) {
                $model = new BagSize();
                if (empty($_POST['name'][$key])) {
                    throw new Exception("BagSize Name is Required");
                }
                $model->name = $value;

                if (!$model->save()) {
                    throw new Exception("Error while Creating BagSizes.");
                }
            }

            DB::commit();
            return redirect('/bagsize')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show($id) {
       
    }

    public function edit($id) {
        $data = BagSize::find($id);
        return view('Admin.bagsize.edit', compact('data'));
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

        $data = BagSize::find($id);
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
        $query = BagSize::query();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $dataset = $query->get();
        return view('Admin.bagsize._list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();

        try {
            foreach ($_POST['data'] as $id) {
                $data = BagSize::find($id);
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
