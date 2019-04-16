<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use App\Models\RawCategory;
use App\Models\RawProduct;
use App\User;
use Session;
use DB;
use Validator;
use Illuminate\Http\Request;

class RawCategoryController extends HomeController {

    public function index() {
        $dataset = RawCategory::get();
        return view('Admin.raw_category.index', compact('dataset'));
    }

    public function create() {
        //check_user_access('supplier_create');
        return view('Admin.raw_category.create');
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'cat_name' => 'required',
        );

        $messages = array(
            'cat_name.required' => 'Please Provide RawCategory Name.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new RawCategory();
        $model->name = $r->cat_name;
        $model->description = $r->cat_description;
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('rawcategory')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = RawCategory::find($id);
        return view('Admin.raw_category.edit', compact('data'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'cat_name' => 'required',
        );

        $messages = array(
            'cat_name.required' => 'Please Provide RawCategory Name.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = RawCategory::find($id);
        $model->name = $r->cat_name;
        $model->description = $r->cat_description;
        $model->modified_by = Auth::id();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('rawcategory')->with('success', 'RawCategory Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = $r->input('item_count');
        $search = $r->input('search');
        $query = RawCategory::query();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->get();
        return view('Admin.raw_category._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = RawCategory::with('items')->find($id);
                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records.");
                        }
                    }
                }
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'RawCategory has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function get_raw_product(Request $r) {
        $dataset = RawProduct::where('raw_category_id', $r->category)->get();
        $str = ["<option value=''>Select Product</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->name}</option>";
            }
            return $str;
        }
    }

}
