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

class FinancialController extends HomeController {

    public function index() {
        $from_date = '1970-01-01';
        $date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $modelTrans = new Transaction();
        $payments = $modelTrans->totalPaymentBetweenDate($from_date, $end_date)->groupBy('cr_subhead_id')->get();
        $receives = $modelTrans->totalReceiveBetweenDate($from_date, $end_date)->groupBy('dr_subhead_id')->get();
        $sumReceive = $modelTrans->sumReceiveByDate($from_date, $end_date);
        $sumPayment = $modelTrans->sumPaymentByDate($from_date, $end_date);
        $opening_balance = 0;
        $closing_balance = ( ($opening_balance + $sumReceive) - $sumPayment );
        return view('Admin.financial_statements.index', compact('payments', 'receives', 'opening_balance', 'closing_balance', 'from_date', 'end_date', 'modelTrans'));
    }

    public function search(Request $r) {
        //pr($_POST);
        $modelTrans = new Transaction();
        $date = date('Y-m-d');
        $opening_balance = 0;
        $from_date = !empty($r->from_date) ? date_ymd($r->from_date) : '1970-01-01';
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : $date;
        $from_date_befor = date('Y-m-d', strtotime($from_date . ' -1 day'));
        $payments = $modelTrans->totalPaymentBetweenDate($from_date, $end_date)->groupBy('cr_subhead_id')->get();
        $receives = $modelTrans->totalReceiveBetweenDate($from_date, $end_date)->groupBy('dr_subhead_id')->get();
        $sumReceive = $modelTrans->sumReceiveByDate('1970-01-01', $from_date_befor);
        $sumPayment = $modelTrans->sumPaymentByDate('1970-01-01', $from_date_befor);
        //pr($sumPayment);
        $sumReceiveCurDate = $modelTrans->sumReceiveByDate($from_date, $end_date);
        $sumPaymentCurDate = $modelTrans->sumPaymentByDate($from_date, $end_date);
        $opening_balance = ($sumReceive - $sumPayment);
        $closing_balance = ( ($opening_balance + $sumReceiveCurDate) - $sumPaymentCurDate );
        return view('Admin.financial_statements._list', compact('payments', 'receives', 'opening_balance', 'closing_balance', 'from_date', 'end_date', 'modelTrans'));
    }

}
