<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Transaction;
use App\User;
use Session;
use Illuminate\Http\Request;

class BusinessLedgerController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = Head::all();
        $tmodel = new Transaction();
        return view('Admin.ledger.index', compact('dataset', 'tmodel'));
    }

    public function view($id) {
        $data = Head::find($id);
        if (!empty($data)) {
            $tmodel = new Transaction();
            return view('Admin.ledger.business_ledger_view', compact('data', 'tmodel'));
        } else {
            return redirect('ledger-view')->with('warning', 'You are trying to access an invalid URL.');
        }
    }

}
