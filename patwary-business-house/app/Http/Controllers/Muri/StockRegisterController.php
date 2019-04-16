<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Weight;
use App\WeightItem;
use App\Models\Transaction;
use App\Models\EmptyBag;
use App\User;
use Session;
use Illuminate\Http\Request;

class StockRegisterController extends HomeController {

    public function index() {
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d');
        $modelWeightItem = new WeightItem();
        $modelEmptyBag = new EmptyBag();
        $purchases = $modelWeightItem->totalPurchaseBetweenDate($from_date, $end_date);
        $sales = $modelWeightItem->totalSaleBetweenDate($from_date, $end_date);
        $empty_bag_rec = $modelEmptyBag->totalReceiveByDate();
        $empty_bag_pay = $modelEmptyBag->totalPaymentByDate();
        return view('Admin.stock_register.index', compact('purchases', 'sales', 'empty_bag_rec', 'empty_bag_pay'));
    }

    public function search(Request $r) {
        $from_date = !empty($r->from_date) ? date_ymd($r->from_date) : '1970-01-01';
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $modelWeightItem = new WeightItem();
        $modelEmptyBag = new EmptyBag();
        $purchases = $modelWeightItem->totalPurchaseBetweenDate($from_date, $end_date);
        $sales = $modelWeightItem->totalSaleBetweenDate($from_date, $end_date);
        $empty_bag_rec = $modelEmptyBag->totalReceiveByDate();
        $empty_bag_pay = $modelEmptyBag->totalPaymentByDate();
        return view('Admin.stock_register._list', compact('purchases', 'sales', 'empty_bag_rec', 'empty_bag_pay'));
    }

}
