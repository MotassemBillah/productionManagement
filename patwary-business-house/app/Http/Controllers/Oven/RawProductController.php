<?php

namespace App\Http\Controllers\Oven;

use App\Http\Controllers\HomeController;
use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use Session;
use Illuminate\Http\Request;

class RawProductController extends HomeController {

    public function index() {
        $model = new Product();
        $query = $model->where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]]);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $categories = Category::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]])->get();
        return view('oven.raw_products.index', compact('dataset', 'categories'));
    }

    public function create() {
        adminMsg();
        $category = new Category();
        return view('oven.raw_products.create', compact('category'));
    }

    public function store(Request $r) {
        adminMsg();
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
        adminMsg();
        //check_user_access('supplier_edit');
        $category = new Category();
        $data = Product::find($id);
        return view('oven.products.edit', compact('data', 'category'));
    }

    public function update(Request $r, $id) {
        adminMsg();
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
        $search = $r->input('search');
        $category_id = $r->input('category_id');
        $query = Product::query();
        $query->where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]]);
        if (!empty($sort_by)) {
            $query->where('inv_category_id', $sort_by);
        }
        if (!empty($category_id)) {
            $query->where('category_id',$category_id);
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $categories = Category::where([['is_deleted', 0], ['business_type_id', OVENFACTORY]])->get();
        return view('oven.raw_products._list', compact('dataset', 'categories'));
    }

    public function delete() {
        adminMsg();
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
