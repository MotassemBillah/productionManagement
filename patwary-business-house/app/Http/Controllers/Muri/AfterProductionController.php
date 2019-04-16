<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\AfterProduction;
use App\Category;
use App\Product;
use Session;
use Illuminate\Http\Request;

class AfterProductionController extends HomeController {

    public function index() {
        $dataset = AfterProduction::all();
        $category = new Category();
        $product = new Product();
        return view('Admin.after_production.index', compact('dataset', 'category', 'product'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $category = new Category();
        return view('Admin.after_production.create', compact('category'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'product_category' => 'required',
            'after_product_name' => 'required',
        );
        $messages = array(
            'product_category.required' => 'Please Select Product Category.',
            'after_product_name' => 'Please Provide After Product Name',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = new AfterProduction();
            $model->category_id = $r->product_category;
            $model->name = $r->after_product_name;
            $model->weight = $r->bag_weight;
            $model->sale_price = $r->sale_price;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error while Creating After Product.");
            }

            DB::commit();
            return redirect('after-production')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $category = new Category();
        $data = AfterProduction::find($id);
        return view('Admin.after_production.edit', compact('data', 'category'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'product_category' => 'required',
            'after_product_name' => 'required',
        );
        $messages = array(
            'product_category.required' => 'Please Select Product Category.',
            'after_product_name.required' => 'Please Provide After Product Name',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = AfterProduction::find($id);
        $model->category_id = $r->product_category;
        $model->name = $r->after_product_name;
        $model->weight = $r->bag_weight;
        $model->sale_price = $r->sale_price;
        $model->modified_by = Auth::id();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('after-production')->with('success', 'After Product Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $sort_by = $r->category_id;
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = AfterProduction::query();
        if (!empty($sort_by)) {
            $query->where('category_id', $sort_by);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy('category_id', $sort_type);
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new Category();
        return view('Admin.after_production._list', compact('dataset', 'category'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = AfterProduction::find($id);
                if (!empty($data)) {
                    if (!$data->delete()) {
                        throw new Exception("Error while deleting records.");
                    }
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'After Product has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
