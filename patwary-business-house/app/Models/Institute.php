<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Institute extends Model {

    //

    public function users() {
        return $this->hasMany('App\Models\User', 'institute_id', 'id');
    }

    public function chambers() {
        return $this->hasMany('App\Models\Chamber', 'institute_id', 'id');
    }

    public function mills() {
        return $this->hasMany('App\Models\Mill', 'institute_id', 'id');
    }

    public function heads() {
        return $this->hasMany('App\Models\Head', 'institute_id', 'id');
    }

    public function subheads() {
        return $this->hasMany('App\Models\SubHead', 'institute_id', 'id');
    }

    public function transactions() {
        return $this->hasMany('App\Models\CustomerTransaction', 'institute_id', 'id');
    }

    public function stocks() {
        return $this->hasMany('App\Models\Stock', 'institute_id', 'id');
    }

    public function drawer() {
        return $this->hasMany('App\Models\Rice\Drawer', 'institute_id', 'id');
    }

    public static function get_institute_name_by_id($id) {
        $institute = Institute::find($id);
        return !empty($institute) ? $institute->name : '';
    }

    public static function get_institute_permission_by_id($id) {
        $permissions = DB::table('institute_permissions')->where('institute_id', '=', $id)->first()->permissions;
        return json_decode($permissions, true);
    }

    public function businessType($id) {
        $data = "";
        if (!empty($id)) {
            $data = BusinessType::find($id);
        }
        $_name = !empty($data) ? $data->business_type : '';
        return $_name;
    }

    public function businessPrefix($id) {
        $data = "";
        if (!empty($id)) {
            $data = BusinessType::find($id);
        }
        $_name = !empty($data) ? $data->prefix : '';
        return $_name;
    }

}
