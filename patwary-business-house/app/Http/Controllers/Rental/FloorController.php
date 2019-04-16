<?php

namespace App\Http\Controllers\Rental;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\Models\Rental\Building;
use App\Models\Rental\Floor;
use App\Models\Rental\Flat;
use App\User;
use Session;
use DB;
use Validator;
use Illuminate\Http\Request;

class FloorController extends HomeController {

    public function index() {
        $model = new Floor();
        $query = $model->where('is_deleted', 0);
        $buildings = Building::where('is_deleted', 0)->get();
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.floor.index', compact('dataset', 'buildings'));
    }

    public function create() {
        $buildings = Building::where('is_deleted', 0)->get();
        return view('rental.floor.create', compact('dataset', 'buildings'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'building_id' => 'required',
            'floor_name' => 'required',
        );

        $messages = array(
            'building_id.required' => 'Building is required',
            'floor_name.required' => 'Floor Name is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new Floor();
        $model->building_id = $r->building_id;
        $model->floor_name = $r->floor_name;
        $model->description = $r->description;
        $model->created_by = Auth::id();
        $model->created_at = cur_date_time();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('rental/floor')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $buildings = Building::where('is_deleted', 0)->get();
        $data = Floor::find($id);
        return view('rental.floor.edit', compact('data', 'buildings'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'building_id' => 'required',
            'floor_name' => 'required',
        );

        $messages = array(
            'building_id.required' => 'Building is required',
            'floor_name.required' => 'Floor Name is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Floor::find($id);
        $model->building_id = $r->building_id;
        $model->floor_name = $r->floor_name;
        $model->description = $r->description;
        $model->modified_by = Auth::id();
        $model->modified_at = cur_date_time();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('rental/floor')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function get_flat_list(Request $r) {
        $dataset = Flat::where([['floor_id', $r->id], ['is_deleted', 0]])->get();
        $str = ["<option value=''>Select Flat</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->flat_name}</option>";
            }
            return $str;
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $_building_id = $r->input('building_id');
        $search = $r->input('search');

        $query = Floor::query();
        $query->where('is_deleted', 0);
        if (!empty($_building_id)) {
            $query->where('building_id', $_building_id);
        }
        if (!empty($search)) {
            $query->where('floor_name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.floor._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Floor::with('floor')->find($id);
                if (!empty($data->floor)) {
                    foreach ($data->floor as $fl) {
                        $fl->is_deleted = 1;
                        $fl->deleted_by = Auth::id();
                        $fl->deleted_at = cur_date_time();
                        if (!$fl->save()) {
                            throw new Exception("Error while deleting records.");
                        }
                    }
                }
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
