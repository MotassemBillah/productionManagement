<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Models\FinishCategory;
use App\Models\FinishProduct;
use Session;
use Illuminate\Http\Request;

class FinishProductController extends HomeController {

    public function index() {
        $dataset = FinishProduct::all();
        $category = new FinishCategory();
        return view('Admin.finish_product.index', compact('dataset', 'category'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $category = new FinishCategory();
        return view('Admin.finish_product.create', compact('category'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'finish_category_id' => 'required',
            'name' => 'required',
            'unit' => 'required',
        );

        $messages = array(
            'finish_category_id.required' => 'FinishCategory is required.',
            'name.required' => 'Name is required.',
            'unit.required' => 'Unit is required.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new FinishProduct();
        $model->finish_category_id = $r->finish_category_id;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->size = $r->size;
        $model->sale_price = $r->sale_price;
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('finishproduct')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = FinishProduct::find($id);
        $category = new FinishCategory();
        return view('Admin.finish_product.edit', compact('data', 'category'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'finish_category_id' => 'required',
            'name' => 'required',
            'unit' => 'required',
        );

        $messages = array(
            'finish_category_id.required' => 'FinishCategory is required.',
            'name.required' => 'Name is required.',
            'unit.required' => 'Unit is required.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = FinishProduct::find($id);
        $model->finish_category_id = $r->finish_category_id;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->size = $r->size;
        $model->sale_price = $r->sale_price;
        $model->modified_by = Auth::id();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('finishproduct')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->item_count;
        $finish_category_id = $r->finish_category_id;
        $search = $r->search;
        $query = FinishProduct::query();
        if (!empty($finish_category_id)) {
            $query->where('finish_category_id', $finish_category_id);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->get();
        return view('Admin.finish_product._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = FinishProduct::find($id);
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
