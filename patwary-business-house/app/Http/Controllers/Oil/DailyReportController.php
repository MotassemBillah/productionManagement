<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\SalesItem;
use App\Models\Transaction;
use App\Models\EmptyBag;
use App\User;
use Session;
use Illuminate\Http\Request;

class DailyReportController extends HomeController {

    public function index() {
        $modelPurchaseItem = new PurchaseItem();
        $modelSalesItem = new SalesItem();
        $modelTrans = new Transaction();
        $modelEmptyBag = new EmptyBag();
        $purchases = $modelPurchaseItem->totalPurchaseByDate();
        $empty_bag_rec = $modelEmptyBag->totalReceiveByDate();
        $empty_bag_pay = $modelEmptyBag->totalPaymentByDate();
        $sales = $modelSalesItem->totalSaleByDate();
        $payments = $modelTrans->totalPaymentByDate();
        $receives = $modelTrans->totalReceiveByDate();
        $date = date('Y-m-d');
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $sumReceive = $modelTrans->sumReceiveByDate($from_date, $end_date);
        $sumPayment = $modelTrans->sumPaymentByDate($from_date, $end_date);
        $sumReceiveCurDate = $modelTrans->sumReceiveByDate($date, $date);
        $sumPaymentCurDate = $modelTrans->sumPaymentByDate($date, $date);
        $opening_balance = ($sumReceive - $sumPayment);
        $closing_balance = ( ($opening_balance + $sumReceiveCurDate) - $sumPaymentCurDate );
        return view('Admin.dailyreport.index', compact('purchases', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'empty_bag_rec', 'empty_bag_pay'));
    }

    public function search(Request $r) {
        $modelPurchaseItem = new PurchaseItem();
        $modelSalesItem = new SalesItem();
        $modelTrans = new Transaction();
        $modelEmptyBag = new EmptyBag();
        $date = date_ymd($r->date);
        $purchases = $modelPurchaseItem->totalPurchaseByDate($date);
        $empty_bag_rec = $modelEmptyBag->totalReceiveByDate($date);
        $empty_bag_pay = $modelEmptyBag->totalPaymentByDate($date);
        $sales = $modelSalesItem->totalSaleByDate($date);
        $payments = $modelTrans->totalPaymentByDate($date);
        $receives = $modelTrans->totalReceiveByDate($date);
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $sumReceive = $modelTrans->sumReceiveByDate($from_date, $end_date);
        $sumPayment = $modelTrans->sumPaymentByDate($from_date, $end_date);
        $sumReceiveCurDate = $modelTrans->sumReceiveByDate($date, $date);
        $sumPaymentCurDate = $modelTrans->sumPaymentByDate($date, $date);
        $opening_balance = ($sumReceive - $sumPayment);
        $closing_balance = ( ($opening_balance + $sumReceiveCurDate) - $sumPaymentCurDate );
        return view('Admin.dailyreport._list', compact('purchases', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'empty_bag_rec', 'empty_bag_pay'));
    }

}
