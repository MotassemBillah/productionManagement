<?php

namespace App\Http\Controllers\Dal;

use App\Http\Controllers\HomeController;
use Exception;
use Auth;
use App\User;
use Session;
use DB;
use Validator;
use Illuminate\Http\Request;

class DashboardController extends HomeController {

    public function index() {
        return view('dal.dashboard.index');
    }

}
