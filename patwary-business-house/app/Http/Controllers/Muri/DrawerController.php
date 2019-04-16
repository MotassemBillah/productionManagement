<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Drawer;
use App\Category;
use App\Product;
use Session;
use Illuminate\Http\Request;

class DrawerController extends HomeController {

    public function index() {
        $dataset = Drawer::all();
        return view('Admin.drawers.index', compact('dataset'));
    }

    public function create() {
        //check_user_access('supplier_create');
        return view('Admin.drawers.create');
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'name' => 'required',
            'capacity' => 'required',
        );
        $messages = array(
            'name.required' => 'Drawer name is required.',
            'capacity.required' => 'Capacity is required.',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = new Drawer();
            $model->name = $r->name;
            $model->capacity = $r->capacity;
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error while Creating Drawer.");
            }

            DB::commit();
            return redirect('drawers')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Drawer::find($id);
        return view('Admin.drawers.edit', compact('data'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'name' => 'required',
            'capacity' => 'required',
        );
        $messages = array(
            'name.required' => 'Drawer name is required.',
            'capacity.required' => 'Capacity is required.',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = Drawer::find($id);
            $model->name = $r->name;
            $model->capacity = $r->capacity;
            $model->modified_by = Auth::id();
            
            if (!$model->save()) {
                throw new Exception("Error while Updating Drawer.");
            }

            DB::commit();
            return redirect('drawers')->with('success', 'Record Updated Successfully.');
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
        $query = Drawer::query();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $dataset = $query->get();
        return view('Admin.drawers._list', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Drawer::find($id);
                if (!empty($data)) {
                    if (!$data->delete()) {
                        throw new Exception("Error while deleting records.");
                    }
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Drawer has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
