<?php
namespace App\Http\Controllers;

use App\ProductionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Exception;
use Auth;
use Session;
use DB;
class ProductionSettingController extends HomeController
{
	public function index() {
		return view( 'Admin.Production Setting.production_setting_list' );
	}
	public function new_production_setting() {
		return view( 'Admin.Production Setting.production_create', compact( 'purchase_price_setting'));
	}

	public function create_new_production_setting(Request $r) {
		//pr($_POST);
		$input = $r->all();
		$rules = array(
			'product_category'=> 'required',
			'product_name'      => 'required',
			'product_number' => 'required',
			'total_weight' => 'required',
		);
		$messages = array(
		    'product_category.required' => 'Please Select Category.',
		    'product_name.required' => 'Please Select Product Name.',
		);

		$valid = Validator::make($input, $rules, $messages);

		if ($valid->fails()) {
		    return redirect()->back()->withErrors($valid)->withInput();
		}

		$insert_data = array();
		$user_id = Auth::user()->id;
		$insert_data['category_id'] = $r->input('product_category');
		$insert_data['product_id'] = $r->input('product_name');
		$insert_data['product_no_id'] = $r->input('product_number');
		$insert_data['total_weight'] = $r->input('total_weight');
		$insert_data['created_by'] = $user_id;

		DB::beginTransaction();
		try {
		    foreach ($_POST['net_weight'] as $key => $value) {

		        if (empty($_POST['bag_weight'][$key])) {
		            throw new Exception("Select Required Field");
		        }
		        if (empty($_POST['net_weight'][$key])) {
		            throw new Exception("Select Required Field");
		        }
		        if (empty($_POST['ratio'][$key])) {
		            throw new Exception("Select Required Field");
		        }

		        $insert_data['bag_weight'] = $_POST['bag_weight'][$key];
		        $insert_data['after_production_id'] = $_POST['after_production'][$key];
		        $insert_data['net_weight'] = $_POST['net_weight'][$key];
		        $insert_data['production_ratio'] = $_POST['ratio'][$key];

		        $data_exist = DB::table('production_settings')->where ([['product_no_id','=',$r->input('product_number')],['after_production_id','=',$_POST['after_production'][$key]]])->count();
		      	
		      	if ( $data_exist>0 ) {
		      		throw new Exception("Production Setting has already Done for this Product. Please Select another One.");
		      	}

		        $result = DB::table('production_settings')->insert($insert_data);

		        if (!$result) {
		            throw new Exception("Error while Inserting Records.");
		        }
		    }
		    DB::commit();
		    return redirect('production-setting')->with('success', 'Production Setting has been Inserted Successfully.');
		} catch (Exception $e) {
		    DB::rollback();
		    return redirect()->back()->with('danger', $e->getMessage());
		}
	}

	public function edit_production_setting($id) {
		$production=ProductionSetting::find($id);
		return view('Admin.Production Setting.production_update', compact('production'));
	}
	public function update_production_setting(Request $request) {
		//pr($_POST);
		$rules = array(
			'total_weight' => 'required',
			'net_weight' => 'required',
			'bag_weight' => 'required',
			'ratio' => 'required',
		);
		$update_data = array();
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		} else {
			$update_data['total_weight'] = $request->input('total_weight');
			$update_data['net_weight'] = $request->input('net_weight');
			$update_data['bag_weight'] = $request->input('bag_weight');
			$update_data['production_ratio'] = $request->input('ratio');
			$update_data['modified_by'] = Auth::user()->id;

			$updates = DB::table('production_settings')->where('id','=',$request->input('hid'))->update($update_data);
			// redirect
			Session::flash('success', 'Production Setting Updated Successfully.');
			return Redirect('production-setting');
		}
	}
	public function delete_production_setting($id) {
		$purchase=ProductionSetting::find($id);
		$purchase->delete();
		Session::flash('success', 'Production Setting Deleted Successfully.');
		return Redirect('production-setting');
	}
}
