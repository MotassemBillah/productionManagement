<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\GeneralSetting;
use Auth;
use DB;

class GeneralSettingController extends HomeController {

    public function index() {
        $setting = $this->getSettings();
        return view('institute.settings.setting', compact('setting'));
    }

    public function update_setting(Request $r) {
        //pr($r->input());
        $id = $r->input('hid');
        $insert_data = array();
        $user_id = Auth::user()->id;
        $institute_id = Auth::user()->institute_id;
        $insert_data['title'] = $r->input('site_name');
        $insert_data['institute_id'] = $institute_id;
        $insert_data['owner'] = $r->input('author_name');
        $insert_data['address'] = $r->input('author_address');
        $insert_data['description'] = $r->input('site_description');
        $insert_data['email'] = $r->input('author_email');
        $insert_data['mobile'] = $r->input('author_mobile');
        $insert_data['phone'] = $r->input('author_phone');
        $insert_data['copyright'] = $r->input('copyright');
        $insert_data['pagesize'] = $r->pagesize;
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

        $insert_data['modified_by'] = $user_id;
        $update = DB::table('general_settings')->where('id', '=', $id)->update($insert_data);
        return redirect('general-setting')->with('success', 'General Information Updated Successfully.');
    }

}
