<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\PriceSetting;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Session;

class PriceSettingController extends HomeController
{


    public function index() {
        return view( 'Admin.Price Setting.purchase_price_setting_list' );
    }

    public function new_purchase_price_setting() {
        return view( 'Admin.Price Setting.purchase_price_create', compact( 'purchase_price_setting'));
    }

    public function create_new_purchase_price_setting(Request $request) {

        $rules = array(
            'product_category'=> 'required',
            'product_name'      => 'required',
            'product_number' => 'required',
            'per_bag_weight' => 'required',
            'per_bag_price' => 'required',
            'per_kg_price' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('new-purchase-price-setting')
            ->withErrors($validator)
            ->withInput();
        } else {
            // store
            $purchase= new PriceSetting;
            $purchase->type='purchase_price';
            $purchase->category_id=$request->input('product_category');
            $purchase->product_id=$request->input('product_name');
            $purchase->product_no_id=$request->input('product_number');
            $purchase->per_bag_weight=$request->input('per_bag_weight');
            $purchase->per_bag_price=$request->input('per_bag_price');
            $purchase->per_kg_price=$request->input('per_kg_price');
            $purchase->created_by=Auth::user()->id;
            $purchase->save();

            // redirect
            Session::flash('success', 'New Purchase Price Setting Inserted Successfully.');
            return Redirect('purchase-price-setting');
        }

    }


    public function edit_purchase_price_setting($id) {
        $purchase=PriceSetting::find($id);
        //pr($purchase_price_setting);
        return view('Admin.Price Setting.purchase_price_update', compact('purchase'));
    }




    public function update_purchase_price_setting(Request $request) {

        //pr($_POST);

        $rules = array(
            'per_bag_weight' => 'required',
            'per_bag_price' => 'required',
            'per_kg_price' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator)
            ->withInput();
        } else {
            // store
            $purchase=PriceSetting::find($request->input('hid'));
            $purchase->per_bag_weight=$request->input('per_bag_weight');
            $purchase->per_bag_price=$request->input('per_bag_price');
            $purchase->per_kg_price=$request->input('per_kg_price');
            $purchase->created_by=Auth::user()->id;
            $purchase->update();

            // redirect
            Session::flash('success', 'Purchase Price Setting Updated Successfully.');
            return Redirect('purchase-price-setting');
        }

    }

    public function delete_purchase_price_setting($id) {
        $purchase=PriceSetting::find($id);
        $purchase->delete();
        Session::flash('success', 'Purchase Price Setting Deleted Successfully.');
        return Redirect('purchase-price-setting');
    }



    //Sale Price Setting


    public function sale_price_setting() {
        return view('Admin.Price Setting.sale_price_setting_list');
    }

    public function new_sale_price_setting() {
        return view('Admin.Price Setting.sale_price_create');
    }

    public function create_new_sale_price_setting(Request $request) {

        $rules = array(
            'product_category'=> 'required',
            'product_name'      => 'required',
            'product_number' => 'required',
            'per_bag_weight' => 'required',
            'per_bag_price' => 'required',
            'per_kg_price' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('new-sale-price-setting')
            ->withErrors($validator)
            ->withInput();
        } else {
            // store
            $purchase= new PriceSetting;
            $purchase->type='sale_price';
            $purchase->category_id=$request->input('product_category');
            $purchase->product_id=$request->input('product_name');
            $purchase->product_no_id=$request->input('product_number');
            $purchase->per_bag_weight=$request->input('per_bag_weight');
            $purchase->per_bag_price=$request->input('per_bag_price');
            $purchase->per_kg_price=$request->input('per_kg_price');
            $purchase->created_by=Auth::user()->id;
            $purchase->save();

            // redirect
            Session::flash('success', 'New Sale Price Setting Inserted Successfully.');
            return Redirect('sale-price-setting');
        }

    }


    public function edit_sale_price_setting($id) {
        $purchase=PriceSetting::find($id);
        //pr($purchase_price_setting);
        return view('Admin.Price Setting.sale_price_update', compact('purchase'));
    }




    public function update_sale_price_setting(Request $request) {

        //pr($_POST);

        $rules = array(
            'per_bag_weight' => 'required',
            'per_bag_price' => 'required',
            'per_kg_price' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $purchase=PriceSetting::find($request->input('hid'));
            $purchase->per_bag_weight=$request->input('per_bag_weight');
            $purchase->per_bag_price=$request->input('per_bag_price');
            $purchase->per_kg_price=$request->input('per_kg_price');
            $purchase->created_by=Auth::user()->id;
            $purchase->update();

            // redirect
            Session::flash('success', 'Sale Price Setting Updated Successfully.');
            return Redirect('sale-price-setting');
        }

    }

    public function delete_sale_price_setting($id) {
        $purchase=PriceSetting::find($id);
        $purchase->delete();
        Session::flash('success', 'Sale Price Setting Deleted Successfully.');
        return Redirect('sale-price-sssetting');
    }














}
