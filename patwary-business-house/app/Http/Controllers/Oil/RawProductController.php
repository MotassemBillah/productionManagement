<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Models\RawCategory;
use App\Models\RawProduct;
use Session;
use Illuminate\Http\Request;

class RawProductController extends HomeController {

    public function index() {
        $dataset = RawProduct::all();
        $category = new RawCategory();
        return view('Admin.raw_product.index', compact('dataset', 'category'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $category = new RawCategory();
        return view('Admin.raw_product.create', compact('category'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'raw_category_id' => 'required',
            'name' => 'required',
            'unit' => 'required',
        );

        $messages = array(
            'raw_category_id.required' => 'RawCategory is required.',
            'name.required' => 'Name is required.',
            'unit.required' => 'Unit is required.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new RawProduct();
        $model->raw_category_id = $r->raw_category_id;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->size = $r->size;
        $model->buy_price = $r->buy_price;
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('rawproduct')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = RawProduct::find($id);
        $category = new RawCategory();
        return view('Admin.raw_product.edit', compact('data', 'category'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'raw_category_id' => 'required',
            'name' => 'required',
            'unit' => 'required',
        );

        $messages = array(
            'raw_category_id.required' => 'RawCategory is required.',
            'name.required' => 'Name is required.',
            'unit.required' => 'Unit is required.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = RawProduct::find($id);
        $model->raw_category_id = $r->raw_category_id;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->size = $r->size;
        $model->buy_price = $r->buy_price;
        $model->modified_by = Auth::id();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('rawproduct')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->item_count;
        $raw_category_id = $r->raw_category_id;
        $search = $r->search;
        $query = RawProduct::query();
        if (!empty($raw_category_id)) {
            $query->where('raw_category_id', $raw_category_id);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->get();
        return view('Admin.raw_product._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = RawProduct::find($id);
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
