<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class GeneralSetting extends Model {

    protected $table = 'general_settings';

    public static function get_setting() {
        $institute_id = Auth::user()->institute_id;
        $setting = GeneralSetting::where('institute_id', $institute_id)->first();
        if ($setting == null) {
            $setting = '';
        }
        return $setting;
    }

}
