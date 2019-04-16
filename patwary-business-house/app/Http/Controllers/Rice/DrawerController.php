<?php

namespace App\Http\Controllers\Rice;

use App\Http\Controllers\HomeController;
use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Models\Institute;
use App\Models\Rice\Drawer;
use App\Models\Rice\Category;
use App\Models\Rice\Product;
use Session;
use Illuminate\Http\Request;

class DrawerController extends HomeController {

    public function index() {
        $model = new Drawer();
        $query = is_Admin() ? $model->where('is_deleted', 0) : $model->where([['institute_id', institute_id()], ['is_deleted', 0]]);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $insList = Institute::where([['type', 'institute'], ['business_type_id', RICEMILL]])->get();
        return view('rice.drawers.index', compact('dataset', 'insList'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $insList = Institute::where([['type', 'institute'], ['business_type_id', RICEMILL]])->get();
        return view('rice.drawers.create', compact('ins'));
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
            if (is_Admin()) {
                if (empty($r->institute_id)) {
                    throw new Exception("Please select a Branch");
                }
            }
            $model = new Drawer();
            $model->name = $r->name;
            $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
            $model->capacity = $r->capacity;
            $model->created_by = Auth::id();
            $model->created_at = cur_date_time();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error while Creating Drawer.");
            }

            DB::commit();
            return redirect('rice/drawers')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Drawer::find($id);
        return view('rice.drawers.edit', compact('data'));
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
            $model->institute_id = institute_id();
            $model->capacity = $r->capacity;
            $model->modified_by = Auth::id();
            $model->modified_at = cur_date_time();

            if (!$model->save()) {
                throw new Exception("Error while Updating Drawer.");
            }

            DB::commit();
            return redirect('rice/drawers')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $model = new Drawer();
        $item_count = $r->input('item_count');
        $search = $r->input('search');
        $query = is_Admin() ? $model->where('is_deleted', 0) : $model->where([['is_deleted', 0], ['institute_id', institute_id()]]);
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rice.drawers._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Drawer::find($id);
                $data->is_deleted = 1;
                $data->deleted_by = Auth::id();
                $data->deleted_at = cur_date_time();
                if (!$data->save()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Records has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
