<?php

namespace App\Http\Controllers\Inv;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\Models\BusinessType;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use DB;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends HomeController {

    public function index() {
        //check_user_access('category_list');
        $model = new Category();
        $query = $model->where('is_deleted', 0);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $business_types = BusinessType::get();
        $types = type_list();

        $this->model['breadcrumb_title'] = "Category List";
        $this->model['dataset'] = $dataset;
        $this->model['business_types'] = $business_types;
        $this->model['types'] = $types;
        return view('inv.category.index', $this->model);
    }

    public function create() {
        //check_user_access('category_create');
        $business_types = BusinessType::get();
        $types = type_list();

        $this->model['breadcrumb_title'] = "Category Information";
        $this->model['business_types'] = $business_types;
        $this->model['types'] = $types;
        return view('inv.category.create', $this->model);
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'business_type_id' => 'required',
            'name' => 'required',
        );

        $messages = array(
            'business_type_id.required' => 'Please select business type.',
            'name.required' => 'Name required.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new Category();
        $model->business_type_id = $r->business_type_id;
        $model->type = $r->type;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->description = $r->description;
        $model->created_by = Auth::id();
        $model->created_at = cur_date_time();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query problem on creating record.");
            }

            DB::commit();
            return redirect('inv/category')->with('success', 'New record created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('category_edit');
        $business_types = BusinessType::get();
        $types = type_list();
        $data = Category::find($id);

        $this->model['breadcrumb_title'] = "Category Information";
        $this->model['business_types'] = $business_types;
        $this->model['types'] = $types;
        $this->model['data'] = $data;
        return view('inv.category.edit', $this->model);
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'business_type_id' => 'required',
            'name' => 'required',
        );

        $messages = array(
            'business_type_id.required' => 'Please select business type.',
            'name.required' => 'Please provide category name.',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Category::find($id);
        $model->business_type_id = $r->business_type_id;
        $model->type = $r->type;
        $model->name = $r->name;
        $model->unit = $r->unit;
        $model->description = $r->description;
        $model->modified_by = Auth::id();
        $model->modified_at = cur_date_time();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query problem on updating record.");
            }

            DB::commit();
            return redirect('inv/category')->with('success', 'Record updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function show() {
        pr("Silence is the best.");
    }

    public function setting() {
        $model = new Category();

        $_data = "";
        if (isset($_POST['submitSetting'])) {
            pr($_POST, false);
            if (isset($_POST['data'])) {
                $_data .= json_encode($_POST['data']);
            }
            pr($_data);
        }

        $this->model['breadcrumb_title'] = "Category Report Setting";
        $this->model['model'] = 'Category';
        $this->model['labels'] = $model->custom_labels();
        return view('inv.category.setting', $this->model);
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = $r->input('item_count');
        $_business_type = $r->input('business_type_id');
        $_type = $r->input('type');
        $search = $r->input('srch');

        $query = Category::query();
        $query->where('is_deleted', 0);
        if (!empty($_business_type)) {
            $query->where('business_type_id', $_business_type);
        }
        if (!empty($_type)) {
            $query->where('type', 'like', '%' . trim($_type) . '%');
        }
        if (!empty($search)) {
            $query->where('name', 'like', '%' . trim($search) . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($item_count);
        return view('inv.category._list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Category::find($id);
                $data->is_deleted = 1;
                $data->deleted_by = Auth::id();
                $data->deleted_at = cur_date_time();
                if (!$data->save()) {
                    throw new Exception("Error while deleting records.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record has been deleted successfully.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function list_category_by_buisness(Request $r) {
        $dataset = Category::where([['is_deleted', 0], ['business_type_id', $r->business_type]])->get();
        $str = "";
        if (!empty($dataset)) {
            $str .= "<option value=''>Select Category</option>";
            foreach ($dataset as $data) {
                $str .= "<option value='{$data->id}'>{$data->name}</option>";
            }
        } else {
            $str .= "<option value=''>No Category Found</option>";
        }

        return $str;
    }

    public function list_product_by_category(Request $r) {
        $query = Product::where([['is_deleted', 0], ['category_id', $r->category]]);
        if (!empty($r->type)) {
            $query->where('type', $r->type);
        }
        $dataset = $query->get();
        $str = "";
        if (!empty($dataset)) {
            $str .= "<option value=''>Select Product</option>";
            foreach ($dataset as $data) {
                $str .= "<option value='{$data->id}'>{$data->name}</option>";
            }
        } else {
            $str .= "<option value=''>No Product Found</option>";
        }

        return $str;
    }

}
