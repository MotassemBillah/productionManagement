<?php

namespace App\Http\Controllers;

use App\Setting;
use Session;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SettingController extends HomeController {

    public function index() {
        check_user_access('setting');
        $setting = Setting::get_setting();
        return view('Admin.Setting.setting', compact('setting'));
    }

    public function update_setting(Request $r) {

        check_user_access('generel_setting');
        $id = $r->input('hid');
        $insert_data = array();
        $user_id = Auth::user()->id;
        $insert_data['title'] = $r->input('site_name');
        $insert_data['owner'] = $r->input('author_name');
        $insert_data['address'] = $r->input('author_address');
        $insert_data['description'] = $r->input('site_description');
        $insert_data['email'] = $r->input('author_email');
        $insert_data['mobile'] = $r->input('author_mobile');
        $insert_data['phone'] = $r->input('author_phone');
        $insert_data['pagesize'] = $r->input('pagesize');
        $insert_data['copyright'] = $r->input('copyright');
        $insert_data['other_contact'] = $r->input('other_contacts');
        $insert_data['modified_by'] = $user_id;

        if (Input::hasFile('logo')) {
            $logo = Input::file('logo');
            $logo_name = 'logo' . '.' . $logo->getClientOriginalExtension();
            $path = public_path('uploads/');
            $insert_data['logo'] = $logo_name;
            Input::file('logo')->move($path, $logo_name);
        }

        if (Input::hasFile('favicon')) {
            $fav = Input::file('favicon');
            $fav_name = 'fav' . '.' . $fav->getClientOriginalExtension();
            $path = public_path('uploads/');
            $insert_data['favicon'] = $fav_name;
            Input::file('favicon')->move($path, $fav_name);
        }

        $update_agent = DB::table('tbl_settings')->where('_key', '=', $id)->update($insert_data);
        return redirect('setting')->with('success', 'General Information Updated Successfully.');
    }

}
