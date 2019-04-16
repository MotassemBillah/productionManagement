<?php

namespace App\Http\Controllers\Inv;

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
        $this->model['breadcrumb_title'] = "Inventory Dashboard";
        return view('inv.dashboard.index', $this->model);
    }

}
