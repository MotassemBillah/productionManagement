<?php

namespace App\Http\Controllers\Rice;

use App\Http\Controllers\HomeController;
use App\Http\Controllers;
use Validator;
use Exception;
use DB;
use Auth;
use App\Models\Institute;
use App\Models\Rice\EmptyBagSetting;
use Session;
use Illuminate\Http\Request;

class EmptybagSettingController extends HomeController {

    public function index() {
        $model = new EmptyBagSetting();
        $query = is_Admin() ? $model->where('is_deleted', 0) : $model->where([['institute_id', institute_id()],['is_deleted', 0]]);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        $insList = Institute::where([['type', 'institute'], ['business_type_id', RICEMILL]])->get();
        return view('rice.emptybag_setting.index', compact('dataset', 'insList'));
    }

    public function create() {
        //check_user_access('supplier_create');
        $insList = Institute::where([['type', 'institute'], ['business_type_id', RICEMILL]])->get();
        return view('rice.emptybag_setting.create', compact('insList'));
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'weight' => 'required',
        );
        $messages = array(
            'weight.required' => 'EmptyBagSetting Weight is required.',
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
            $model = new EmptyBagSetting();
            $model->institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
            $model->weight = $r->weight;
            $model->created_by = Auth::id();
            $model->created_at = cur_date_time();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error while Creating EmptyBagSetting.");
            }

            DB::commit();
            return redirect('rice/emptybag-setting')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        //check_user_access('supplier_edit');
        $data = EmptyBagSetting::find($id);
        return view('rice.emptybag_setting.edit', compact('data'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'weight' => 'required',
        );
        $messages = array(
            'weight.required' => 'EmptyBagSetting Weight is required.',
        );
        $valid = Validator::make($input, $rules, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = EmptyBagSetting::find($id);
            $model->weight = $r->weight;
            $model->modified_by = Auth::id();
            $model->modified_at = cur_date_time();

            if (!$model->save()) {
                throw new Exception("Error while Updating EmptyBagSetting.");
            }

            DB::commit();
            return redirect('rice/emptybag-setting')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $model = new EmptyBagSetting();
        $item_count = $r->input('item_count');
        $search = $r->input('search');
        $query = is_Admin() ? $model->where('is_deleted', 0) : $model->where([['is_deleted', 0],['institute_id', institute_id()]]); 
//        if (!empty($search)) {
//            $query->where('name', 'like', '%' . $search . '%');
//        }
        $query->limit($item_count);
        $dataset = $query->paginate($this->getSettings()->pagesize);
        return view('rice.emptybag_setting._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = EmptyBagSetting::find($id);
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
