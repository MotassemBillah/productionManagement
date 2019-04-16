<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Weight;
use App\WeightItem;
use App\Models\Transaction;
use App\Models\Institute;
use App\User;
use Session;
use Illuminate\Http\Request;

class DailyReportController extends HomeController {

    public function index() {
        $insList = Institute::get();
        $institute_id = institute_id();
        //pr($institute_id);
        //$modelWeightItem = new WeightItem();
        $modelTrans = new Transaction();
        //$modelEmptyBag = new EmptyBag();
//        $purchases = $modelWeightItem->totalPurchaseByDate();
//        $empty_bag_rec = $modelEmptyBag->totalReceiveByDate();
//        $empty_bag_pay = $modelEmptyBag->totalPaymentByDate();
//        $sales = $modelWeightItem->totalSaleByDate();
        $payments = $modelTrans->totalPaymentByDate(null, null, $institute_id);
        $receives = $modelTrans->totalReceiveByDate(null, null, $institute_id);
        $date = date('Y-m-d');
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $sumReceive = $modelTrans->sumReceiveByDate($from_date, $end_date, null, $institute_id);
        $sumPayment = $modelTrans->sumPaymentByDate($from_date, $end_date, null, $institute_id);
        $sumReceiveCurDate = $modelTrans->sumReceiveByDate($date, $date, null, $institute_id);
        $sumPaymentCurDate = $modelTrans->sumPaymentByDate($date, $date, null, $institute_id);
        $opening_balance = ($sumReceive - $sumPayment);
        $closing_balance = ( ($opening_balance + $sumReceiveCurDate) - $sumPaymentCurDate );
        return view('institute.dailyreport.index', compact('purchases', 'insList', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'empty_bag_rec', 'empty_bag_pay'));
    }

    public function search(Request $r) {
        $institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
        //pr($institute_id);
        //$modelWeightItem = new WeightItem();
        $modelTrans = new Transaction();
        //$modelEmptyBag = new EmptyBag();
        $date = date_ymd($r->date);
//        $purchases = $modelWeightItem->totalPurchaseByDate($date);
//        $empty_bag_rec = $modelEmptyBag->totalReceiveByDate($date);
//        $empty_bag_pay = $modelEmptyBag->totalPaymentByDate($date);
//        $sales = $modelWeightItem->totalSaleByDate($date);
        $payments = $modelTrans->totalPaymentByDate($date, null, $institute_id);
        $receives = $modelTrans->totalReceiveByDate($date, null, $institute_id);
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $sumReceive = $modelTrans->sumReceiveByDate($from_date, $end_date, null, $institute_id);
        $sumPayment = $modelTrans->sumPaymentByDate($from_date, $end_date, null, $institute_id);
        $sumReceiveCurDate = $modelTrans->sumReceiveByDate($date, $date, null, $institute_id);
        $sumPaymentCurDate = $modelTrans->sumPaymentByDate($date, $date, null, $institute_id);
        $opening_balance = ($sumReceive - $sumPayment);
        $closing_balance = ( ($opening_balance + $sumReceiveCurDate) - $sumPaymentCurDate );
        return view('institute.dailyreport._list', compact('purchases', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'empty_bag_rec', 'empty_bag_pay'));
    }

}
