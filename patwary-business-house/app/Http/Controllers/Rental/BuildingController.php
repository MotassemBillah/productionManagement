<?php

namespace App\Http\Controllers\Rental;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\Models\Rental\Building;
use App\Models\Rental\Floor;
use App\User;
use Session;
use DB;
use Validator;
use Illuminate\Http\Request;

class BuildingController extends HomeController {

    public function index() {
        $model = new Building();
        $query = $model->where('is_deleted', 0);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.building.index', compact('dataset'));
    }

    public function create() {
        return view('rental.building.create');
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'building_type' => 'required',
            'building_name' => 'required',
            'building_no' => 'required',
            'mobile_no' => 'required',
        );

        $messages = array(
            'building_type.required' => 'Building Type is required',
            'building_name.required' => 'Building Name is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new Building();
        $model->building_type = $r->building_type;
        $model->building_name = $r->building_name;
        $model->building_no = $r->building_no;
        $model->mobile_no = $r->mobile_no;
        $model->address = $r->address;
        $model->created_by = Auth::id();
        $model->created_at = cur_date_time();
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('rental/building')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = Building::find($id);
        return view('rental.building.edit', compact('data'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'building_type' => 'required',
            'building_name' => 'required',
            'building_no' => 'required',
            'mobile_no' => 'required',
        );

        $messages = array(
            'building_type.required' => 'Building Type is required',
            'building_name.required' => 'Building Name is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Building::find($id);
        $model->building_type = $r->building_type;
        $model->building_name = $r->building_name;
        $model->building_no = $r->building_no;
        $model->mobile_no = $r->mobile_no;
        $model->address = $r->address;
        $model->modified_by = Auth::id();
        $model->modified_at = cur_date_time();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('rental/building')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function get_floor_list(Request $r) {
        $dataset = Floor::where([['building_id', $r->id],['is_deleted', 0]])->get();
        $str = ["<option value=''>Select Floor</option>"];
        if (!empty($dataset)) {
            foreach ($dataset as $data) {
                $str[] = "<option value='$data->id'>{$data->floor_name}</option>";
            }
            return $str;
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $_building_type = $r->input('building_type');
        $search = $r->input('search');

        $query = Building::query();
        $query->where('is_deleted', 0);
        if (!empty($_building_type)) {
            $query->where('building_type', $_building_type);
        }
        if (!empty($search)) {
            $query->where('building_name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.building._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Building::with('floor', 'flat', 'party')->find($id);
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
                if (!empty($data->flat)) {
                    foreach ($data->flat as $flat) {
                        $flat->is_deleted = 1;
                        $flat->deleted_by = Auth::id();
                        $flat->deleted_at = cur_date_time();
                        if (!$flat->save()) {
                            throw new Exception("Error while deleting records.");
                        }
                    }
                }
                if (!empty($data->party)) {
                    foreach ($data->party as $party) {
                        $party->is_deleted = 1;
                        $party->deleted_by = Auth::id();
                        $party->deleted_at = cur_date_time();
                        if (!$party->save()) {
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
