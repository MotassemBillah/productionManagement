<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;

class HomeController extends Controller {

    // variables added by Rakib Hasan
    public $_settings = [];
    public $model = [];
    public $cssArray = [];
    public $jsArray = [];
    public $version = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$language = Session::get('locale');
        //App::setLocale($language);
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.dashboard');
    }

    public function getSettings() {
        return GeneralSetting::get_setting();
    }

    public function UrlEncrypt($id) {
        return Crypt::encrypt($id);
    }

    public function UrlDecrypt($id) {
        return Crypt::decrypt($id);
    }

    // method added by Rakib Hasan
    public function addCss($str) {
        if (!empty($str)) {
            $this->cssArray[] = $str;
        }
    }

    public function writeCss() {
        if (!empty($this->cssArray) && count($this->cssArray) > 0) {
            for ($i = 0; $i < count($this->cssArray); $i++) {
                echo '<link href="' . url('/') . 'css/' . $this->cssArray[$i] . '" rel="stylesheet" type="text/css">' . PHP_EOL;
            }
        }
    }

    public function addJs($str) {
        if (!empty($str)) {
            $this->jsArray[] = $str;
        }
    }

    public function writeJs() {
        if (!empty($this->jsArray) && count($this->jsArray) > 0) {
            for ($i = 0; $i < count($this->jsArray); $i++) {
                echo '<script src="' . url('/') . 'js/' . $this->jsArray[$i] . '" type="text/javascript"></script>' . PHP_EOL;
            }
        }
    }

}
