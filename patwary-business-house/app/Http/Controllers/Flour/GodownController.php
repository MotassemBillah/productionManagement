<?php

namespace App\Http\Controllers\Flour;

use App\Http\Controllers\HomeController;
use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Models\Institute;
use App\Models\Flour\Godown;
use Session;
use Illuminate\Http\Request;

class GodownController extends HomeController {

    public function index() {
        $model = new Godown();
        $query = is_Admin() ? $model->where('is_deleted', 0) : $model->where([['institute_id', institute_id()], ['is_deleted', 0]]);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $insList = Institute::where([['type', 'institute'], ['business_type_id', FLOURMILL]])->get();
        return view('flour.godowns.index', compact('dataset', 'insList'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $insList = Institute::where([['type', 'institute'], ['business_type_id', FLOURMILL]])->get();
        return view('flour.godowns.create', compact('ins'));
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'name' => 'required',
            'capacity' => 'required',
        );
        $messages = array(
            'name.required' => 'Godown name is required.',
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
            $model = new Godown();
            $model->name = $r->name;
            $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
            $model->capacity = $r->capacity;
            $model->created_by = Auth::id();
            $model->created_at = cur_date_time();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error while Creating Godown.");
            }

            DB::commit();
            return redirect('flour/godowns')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Godown::find($id);
        return view('flour.godowns.edit', compact('data'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'name' => 'required',
            'capacity' => 'required',
        );
        $messages = array(
            'name.required' => 'Godown name is required.',
            'capacity.required' => 'Capacity is required.',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = Godown::find($id);
            $model->name = $r->name;
            $model->institute_id = institute_id();
            $model->capacity = $r->capacity;
            $model->modified_by = Auth::id();
            $model->modified_at = cur_date_time();

            if (!$model->save()) {
                throw new Exception("Error while Updating Godown.");
            }

            DB::commit();
            return redirect('flour/godowns')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $model = new Godown();
        $item_count = $r->input('item_count');
        $search = $r->input('search');
        $query = is_Admin() ? $model->where('is_deleted', 0) : $model->where([['is_deleted', 0], ['institute_id', institute_id()]]);
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('flour.godowns._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Godown::find($id);
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
