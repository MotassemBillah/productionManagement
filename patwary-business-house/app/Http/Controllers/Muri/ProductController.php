<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Category;
use App\Product;
use Session;
use Illuminate\Http\Request;

class ProductController extends HomeController {

    public function index() {
        $dataset = Product::all();
        $category = new Category();
        return view('Admin.products.index', compact('dataset', 'category'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $category = new Category();
        return view('Admin.products.create', compact('category'));
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'product_category' => 'required',
        );
        $messages = array(
            'product_category.required' => 'Please Select Product Category.',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($_POST['product_name'] as $key => $value) {
                $model = new Product();
                if (empty($_POST['product_name'][$key])) {
                    throw new Exception("Product Field is required");
                }

                $model->category_id = $r->product_category;
                $model->name = $value;
                $model->created_by = Auth::id();
                $model->_key = uniqueKey() . $key;

                if (!$model->save()) {
                    throw new Exception("Error while Creating Product.");
                }
            }

            DB::commit();
            return redirect('products')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $category = new Category();
        $data = Product::find($id);
        return view('Admin.products.edit', compact('data', 'category'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'product_category' => 'required',
        );
        $messages = array(
            'product_category.required' => 'Please Select Product Category.',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Product::find($id);
        $model->category_id = $r->product_category;
        $model->name = $r->product_name;
        $model->modified_by = Auth::id();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('products')->with('success', 'Products Updated Successfully.');
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
        $query = Product::query();
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
        return view('Admin.products._list', compact('dataset', 'category'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Product::with('stocks', 'production_stocks')->find($id);
                if (!empty($data->stocks)) {
                    foreach ($data->stocks as $stock) {
                        if (!$stock->delete()) {
                            throw new Exception("Error while deleting records from Stocks.");
                        }
                    }
                }
                if (!empty($data->production_stocks)) {
                    foreach ($data->production_stocks as $pstock) {
                        if (!$pstock->delete()) {
                            throw new Exception("Error while deleting records from Production Stocks.");
                        }
                    }
                }
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Product has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
