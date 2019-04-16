<?php

namespace App;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';
    public $timestamps = false;

    public function stocks() {
        return $this->hasMany('App\Stock', 'product_id', 'id');
    }
    
    public function production_stocks() {
        return $this->hasMany('App\ProductionStock', 'product_id', 'id');
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public static function create_new_product($data) {

        $insert_data = array();
        $key = strtoupper(uniqid());
        $user_id = Auth::user()->id;
        $insert_data['category_id'] = $data->input('product_category');
        $insert_data['name'] = $data->input('product_name');
        $insert_data['created_by'] = $user_id;
        $insert_data['_key'] = $key;

        $result = DB::table('products')->insert($insert_data);
        return $result;
    }

    public static function update_product_by_id($id) {
        $user_id = Auth::user()->id;
        $update = array();
        $update['category_id'] = $id->input('product_category');
        $update['name'] = $id->input('product_name');
        $update['modified_by'] = $user_id;
        $key = $id->input('hid');

        $result = DB::table('products')->where('_key', '=', $key)->update($update);
        return $result;
    }

    public static function delete_product_by_id($id) {
        $result = DB::table('products')->where('_key', '=', $id)->delete();
        return $result;
    }

    public static function get_product_name_by_id($id) {
        $result = Product::where('id', '=', $id)->first();
        return $result;
    }

    public static function get_product_number_by_id($id) {
        $result = DB::table('product_items')->where('id', '=', $id)->first();
        return $result;
    }

    //Method for Product Number

    public static function get_product_number() {
        $result = DB::table('product_items')->paginate($this->getSettings()->pagesize);
        return $result;
    }

    public static function create_new_product_number($data) {

        $insert_data = array();
        $key = strtoupper(uniqid());
        $user_id = Auth::user()->id;
        $insert_data['category_id'] = $data->input('product_category');
        $insert_data['product_id'] = $data->input('product_name');
        $insert_data['name'] = $data->input('product_number');
        $insert_data['created_by'] = $user_id;
        $insert_data['_key'] = $key;

        $result = DB::table('product_items')->insert($insert_data);
        return $result;
    }

    public static function edit_product_number($id) {
        $result = DB::table('product_items')->where('id', '=', $id)->first();
        return $result;
    }

    public static function update_product_number_by_id($id) {
        $user_id = Auth::user()->id;
        $update = array();
        $update['category_id'] = $id->input('product_category');
        $update['product_id'] = $id->input('product_name');
        $update['name'] = $id->input('product_number');
        $update['modified_by'] = $user_id;
        $key = $id->input('hid');

        $result = DB::table('product_items')->where('id', '=', $key)->update($update);
        return $result;
    }

    public static function delete_product_number_by_id($id) {
        $result = DB::table('product_items')->where('_key', '=', $id)->delete();
        return $result;
    }

    public static function create_new_after_production($data) {

        $insert_data = array();
        $key = strtoupper(uniqid());
        $user_id = Auth::user()->id;
        $insert_data['category_id'] = $data->input('product_category');
        $insert_data['name'] = $data->input('after_product_name');
        $insert_data['created_by'] = $user_id;
        $insert_data['_key'] = $key;

        $result = DB::table('after_production')->insert($insert_data);
        return $result;
    }

    public static function edit_after_product($id) {
        $result = DB::table('after_production')->where('id', '=', $id)->first();
        return $result;
    }

    public static function update_after_product($id) {
        $user_id = Auth::user()->id;
        $update = array();
        $update['category_id'] = $id->input('product_category');
        $update['name'] = $id->input('after_product_name');
        $update['modified_by'] = $user_id;
        $id = $id->input('hid');

        $result = DB::table('after_production')->where('id', '=', $id)->update($update);
        return $result;
    }

    public static function delete_after_product($id) {
        $result = DB::table('after_production')->where('_key', '=', $id)->delete();
        return $result;
    }

    public static function get_after_production_by_id($id) {
        $result = DB::table('after_production')->where('id', '=', $id)->first();
        return $result;
    }

}
