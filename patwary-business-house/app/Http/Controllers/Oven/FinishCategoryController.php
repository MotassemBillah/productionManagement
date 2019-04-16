<?php

namespace App\Http\Controllers\Oven;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\Models\Inv\Category;
use App\User;
use Session;
use DB;
use Validator;
use Illuminate\Http\Request;

class FinishCategoryController extends HomeController {

    public function index() {
        $model = new Category();
        $query = $model->where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]]);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('oven.finish_category.index', compact('dataset'));
    }

    public function create() {
        adminMsg();
        return view('oven.category.create');
    }

    public function store(Request $r) {
        adminMsg();
        $input = $r->all();
        $rules = array(
            'cat_name' => 'required',
            'cat_unit' => 'required',
        );

        $messages = array(
            'cat_name.required' => 'Please Provide Category Name.',
            'cat_unit.required' => 'Please Provide Category Unit.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new Category();
        $model->name = $r->cat_name;
        $model->unit = $r->cat_unit;
        $model->description = $r->cat_description;
        $model->created_by = Auth::id();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('oven/category')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        adminMsg();
        $data = Category::find($id);
        return view('oven.category.edit', compact('data'));
    }

    public function update(Request $r, $id) {
        adminMsg();
        $input = $r->all();
        $rules = array(
            'cat_name' => 'required',
            'cat_unit' => 'required',
        );

        $messages = array(
            'cat_name.required' => 'Please Provide Category Name.',
            'cat_unit.required' => 'Please Provide Category Unit.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Category::find($id);
        $model->name = $r->cat_name;
        $model->unit = $r->cat_unit;
        $model->description = $r->cat_description;
        $model->modified_by = Auth::id();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('oven/category')->with('success', 'Category Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $search = $r->input('search');

        $query = Category::query();
        $query->where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', OVENFACTORY]]);
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($item_count);
        return view('oven.finish_category._list', compact('dataset'));
    }

    public function delete() {
        adminMsg();
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Category::with('products', 'after_production')->find($id);
                //pr($data);
                if (!empty($data->products)) {
                    if (!empty($data->products->stocks)) {
                        foreach ($data->products->stocks as $stock) {
                            if (!$stock->delete()) {
                                throw new Exception("Error while deleting records from Stock.");
                            }
                        }
                    }
                    if (!empty($data->products->production_stocks)) {
                        foreach ($data->products->production_stocks as $pstock) {
                            if (!$pstock->delete()) {
                                throw new Exception("Error while deleting records from Production Stock.");
                            }
                        }
                    }
                    foreach ($data->products as $product) {
                        if (!$product->delete()) {
                            throw new Exception("Error while deleting records from Product.");
                        }
                    }
                }
                if (!empty($data->after_production)) {
                    foreach ($data->after_production as $aproduct) {
                        if (!$aproduct->delete()) {
                            throw new Exception("Error while deleting records from After Production.");
                        }
                    }
                }
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Category has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
