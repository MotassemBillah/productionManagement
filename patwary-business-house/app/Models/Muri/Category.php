<?php

namespace App;

use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';
    public $timestamps = false;

    public function products() {
        return $this->hasMany('App\Product', 'category_id', 'id');
    }

    public function after_production() { 
        return $this->hasMany('App\AfterProduction', 'category_id', 'id');
    }

    public static function create_new_product_category($data) {
        $insert_data = array();
        $key = strtoupper(uniqid());
        $user_id = Auth::user()->id;
        $insert_data['name'] = $data->input('cat_name');
        $insert_data['unit'] = $data->input('cat_unit');
        $insert_data['description'] = $data->input('cat_description');
        $insert_data['created_by'] = $user_id;
        $insert_data['_key'] = $key;

        $result = DB::table('categories')->insert($insert_data);
        return $result;
    }

    public static function update_product_category_by_id($id) {
        $user_id = Auth::user()->id;
        $update = array();
        $update['name'] = $id->input('cat_name');
        $update['unit'] = $id->input('cat_unit');
        $update['description'] = $id->input('cat_description');
        $update['modified_by'] = $user_id;
        $key = $id->input('hid');

        $result = DB::table('categories')->where('_key', '=', $key)->update($update);
        return $result;
    }

    public static function delete_category_by_id($id) {
        $result = DB::table('categories')->where('_key', '=', $id)->delete();
        return $result;
    }

    public static function get_category_name_by_id($id) {
        $result = Category::where('id', '=', $id)->first();
        return $result;
    }

}
