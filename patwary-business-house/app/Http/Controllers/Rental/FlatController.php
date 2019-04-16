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

class FlatController extends HomeController {

    public function index() {
        $model = new Flat();
        $buildings = Building::where('is_deleted', 0)->get();
        $floors = Floor::where('is_deleted', 0)->get();
        $query = $model->where('is_deleted', 0);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.flat.index', compact('dataset', 'buildings', 'floors'));
    }

    public function create() {
        $buildings = Building::where('is_deleted', 0)->get();
        $floors = Floor::where('is_deleted', 0)->get();
        return view('rental.flat.create', compact('buildings', 'floors'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_name' => 'required',
        );

        $messages = array(
            'building_id.required' => 'Building is required',
            'floor_id.required' => 'Floor is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new Flat();
        $model->building_id = $r->building_id;
        $model->floor_id = $r->floor_id;
        $model->flat_name = $r->flat_name;
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
            return redirect('rental/flat')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $buildings = Building::where('is_deleted', 0)->get();
        $data = Flat::find($id);
        $floors = Floor::where('building_id', $data->building_id)->get();
        return view('rental.flat.edit', compact('data', 'buildings', 'floors'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_name' => 'required',
        );

        $messages = array(
            'building_id.required' => 'Building is required',
            'floor_id.required' => 'Floor is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Flat::find($id);
        $model->building_id = $r->building_id;
        $model->floor_id = $r->floor_id;
        $model->flat_name = $r->flat_name;
        $model->description = $r->description;
        $model->modified_by = Auth::id();
        $model->modified_at = cur_date_time();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('rental/flat')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $_building_id = $r->input('building_id');
        $_flat_id = $r->input('flat_id');
        $search = $r->input('search');

        $query = Flat::query();
        $query->where('is_deleted', 0);
        if (!empty($_building_id)) {
            $query->where('building_id', $_building_id);
        }
        if (!empty($_flat_id)) {
            $query->where('building_id', $_flat_id);
        }
        if (!empty($search)) {
            $query->where('flat_name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.flat._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Flat::find($id);
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
