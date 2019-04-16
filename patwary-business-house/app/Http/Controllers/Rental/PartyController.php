<?php

namespace App\Http\Controllers\Rental;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\Models\Rental\Building;
use App\Models\Rental\Floor;
use App\Models\Rental\Flat;
use App\Models\Rental\Party;
use App\User;
use Session;
use DB;
use Validator;
use Illuminate\Http\Request;

class PartyController extends HomeController {

    public function index() {
        $model = new Party();
        $buildings = Building::where('is_deleted', 0)->get();
        $floors = Floor::where('is_deleted', 0)->get();
        $flats = Flat::where('is_deleted', 0)->get();
        $query = $model->where('is_deleted', 0);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.party.index', compact('dataset', 'buildings', 'floors', 'flats'));
    }

    public function create() {
        $buildings = Building::where('is_deleted', 0)->get();
        $floors = Floor::where('is_deleted', 0)->get();
        return view('rental.party.create', compact('buildings', 'floors'));
    }

    public function store(Request $r) {
        // pr($_POST);
        $input = $r->all();
        $rules = array(
            'rental_date' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_id' => 'required',
            'party_name' => 'required',
            'monthly_rent' => 'required',
        );

        $messages = array(
            'building_id.required' => 'Building is required',
            'floor_id.required' => 'Floor is required',
            'flat_id.required' => 'Flat is required',
            'party_name.required' => 'Party Name is required',
            'monthly_rent.required' => 'Monthly Rent is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = new Party();
        $model->rental_date = !empty($r->rental_date) ? date_ymd($r->rental_date) : date('Y-m-d');
        $model->building_id = $r->building_id;
        $model->floor_id = $r->floor_id;
        $model->flat_id = $r->flat_id;
        $model->party_name = $r->party_name;
        $model->mobile_no = $r->mobile_no;
        $model->monthly_rent = $r->monthly_rent;
        $model->address = $r->address;
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
            return redirect('rental/party')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $buildings = Building::where('is_deleted', 0)->get();
        $data = Party::find($id);
        $floors = Floor::where('building_id', $data->building_id)->get();
        $flats = Flat::where('floor_id', $data->floor_id)->get();
        return view('rental.party.edit', compact('data', 'buildings', 'floors', 'flats'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rules = array(
            'rental_date' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_id' => 'required',
            'party_name' => 'required',
            'monthly_rent' => 'required',
        );

        $messages = array(
            'building_id.required' => 'Building is required',
            'floor_id.required' => 'Floor is required',
            'flat_id.required' => 'Flat is required',
            'party_name.required' => 'Party Name is required',
            'monthly_rent.required' => 'Monthly Rent is required',
        );

        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $model = Party::find($id);
        $model->rental_date = !empty($r->rental_date) ? date_ymd($r->rental_date) : date('Y-m-d');
        $model->building_id = $r->building_id;
        $model->floor_id = $r->floor_id;
        $model->flat_id = $r->flat_id;
        $model->party_name = $r->party_name;
        $model->mobile_no = $r->mobile_no;
        $model->monthly_rent = $r->monthly_rent;
        $model->address = $r->address;
        $model->description = $r->description;
        $model->modified_by = Auth::id();
        $model->modified_at = cur_date_time();
        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('rental/party')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $_building_id = $r->input('building_id');
        $_floor_id = $r->input('floor_id');
        $_flat_id = $r->input('flat_id');
        $search = $r->input('search');

        $query = Party::query();
        $query->where('is_deleted', 0);
        if (!empty($_building_id)) {
            $query->where('building_id', $_building_id);
        }
        if (!empty($_floor_id)) {
            $query->where('floor_id', $_floor_id);
        }
        if (!empty($_flat_id)) {
            $query->where('flat_id', $_flat_id);
        }
        if (!empty($search)) {
            $query->where('party_name', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rental.party._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Party::find($id);
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
