<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Head;
use App\Models\Institute;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Transaction;
use App\User;
use Session;
use Illuminate\Http\Request;

class LedgerController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $insList = Institute::where('type', 'institute')->get();
        $model = new Head();
        $query = is_Admin() ? $model : $model->where('institute_id', institute_id());
        $dataset = $query->where('institute_id', institute_id())->get();
        $tmodel = new Transaction();
        return view('institute.ledger.index', compact('dataset', 'tmodel', 'insList'));
    }

    public function show($id) {
        echo "silence is best";
    }

    public function view_ledger() {
        $dataset = Head::all();
        $tmodel = new Transaction();
        return view('institute.ledger.view', compact('dataset', 'tmodel'));
    }

    public function head_transaction($id) {
        //pr($id);
        $all_debit = Transaction::where('dr_head_id', $id)->orderBy('date', 'ASC')->get();
        $all_credit = Transaction::where('cr_head_id', $id)->orderBy('date', 'ASC')->get();
        $head_id = $id;
        $head = new Head();
        return view('institute.ledger.ledger_head', compact('head', 'head_id', 'all_debit', 'all_credit'));
    }

    public function subhead_transaction($id) {
        $all_debit = Transaction::where('dr_subhead_id', $id)->orderBy('date', 'ASC')->get();
        $all_credit = Transaction::where('cr_subhead_id', $id)->orderBy('date', 'ASC')->get();
        $head_id = $id;
        $head = new SubHead();
        return view('institute.ledger.ledger_subhead', compact('head', 'head_id', 'all_debit', 'all_credit'));
    }

    public function particular_transaction($id) {
        $all_debit = Transaction::where('dr_particular_id', $id)->orderBy('date', 'ASC')->get();
        $all_credit = Transaction::where('cr_particular_id', $id)->orderBy('date', 'ASC')->get();
        $particular = Particular::find($id);
        $head = $particular->head->id;
        return view('institute.ledger.ledger_particular', compact('particular', 'all_debit', 'all_credit'));
    }

    public function ledger_search(Request $r) {
        //pr($_POST);
        $institute_id = $r->institute_id;
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $dataset = Head::where('institute_id', $institute_id)->get();
        $tmodel = new Transaction();
        return view('institute.ledger._list', compact('dataset', 'tmodel', 'from_date', 'end_date'));
    }

    public function head_transaction_search(Request $r) {
        $id = $r->head;
        $sort_by = 'date';
        $sort_type = 'ASC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $debit = Transaction::where('dr_head_id', $id);
        $credit = Transaction::where('cr_head_id', $id);
        if (!empty($from_date)) {
            $debit->whereBetween('date', [$from_date, $end_date]);
            $credit->whereBetween('date', [$from_date, $end_date]);
        }
        $all_debit = $debit->orderBy($sort_by, $sort_type)->get();
        $all_credit = $credit->orderBy($sort_by, $sort_type)->get();
        $head_id = $id;
        $head = new Head();

        return view('institute.ledger.ledger_head_search', compact('all_debit', 'all_credit', 'head', 'head_id'));
    }

    public function subhead_transaction_search(Request $r) {
        $id = $r->head;
        $sort_by = 'date';
        $sort_type = 'ASC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $debit = Transaction::where('dr_subhead_id', $id);
        $credit = Transaction::where('cr_subhead_id', $id);
        if (!empty($from_date)) {
            $debit->whereBetween('date', [$from_date, $end_date]);
            $credit->whereBetween('date', [$from_date, $end_date]);
        }
        $all_debit = $debit->orderBy($sort_by, $sort_type)->get();
        $all_credit = $credit->orderBy($sort_by, $sort_type)->get();
        $head_id = $id;
        $head = new SubHead();
        return view('institute.ledger.ledger_subhead_search', compact('all_debit', 'all_credit', 'head', 'head_id'));
    }

    public function particular_transaction_search(Request $r) {
        $id = $r->head;
        $sort_by = 'date';
        $sort_type = 'ASC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $debit = Transaction::where('dr_particular_id', $id);
        $credit = Transaction::where('cr_particular_id', $id);
        if (!empty($from_date)) {
            $debit->whereBetween('date', [$from_date, $end_date]);
            $credit->whereBetween('date', [$from_date, $end_date]);
        }
        $all_debit = $debit->orderBy($sort_by, $sort_type)->get();
        $all_credit = $credit->orderBy($sort_by, $sort_type)->get();
        $particular = Particular::find($id);
        $head = $particular->head->id;
        return view('institute.ledger.ledger_particular_search', compact('particular', 'all_debit', 'all_credit'));
    }

    public function daily_sheet() {
        $insList = Institute::get();
        $institute_id = institute_id();
        // $modelWeightItem = new WeightItem();
        $modelTrans = new Transaction();
        $heads = Head::where('institute_id', institute_id())->get();
//        $purchases = $modelWeightItem->totalPurchaseByDate();
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
        return view('institute.ledger.daily_sheet', compact('purchases', 'insList', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'heads'));
    }

    public function trial_balance() {
        $dataset = SubHead::where('is_deleted', 0)->orderBy('name', 'ASC')->get();
        $tmodel = new Transaction();
        return view('institute.ledger.trial_balance', compact('dataset', 'tmodel'));
    }

    // Ajax Functions
    public function daily_sheet_search(Request $r) {
        $institute_id = !empty($r->institute_id) ? $r->institute_id : institute_id();
        //$modelWeightItem = new WeightItem();
        $modelTrans = new Transaction();
        $date = date_ymd($r->date);
        $head = $r->head_id;
//        $purchases = $modelWeightItem->totalPurchaseByDate($date);
//        $sales = $modelWeightItem->totalSaleByDate($date);
        $payments = $modelTrans->totalPaymentByDate($date, $head, $institute_id);
        $receives = $modelTrans->totalReceiveByDate($date, $head, $institute_id);
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $sumReceive = $modelTrans->sumReceiveByDate($from_date, $end_date, $head, $institute_id);
        $sumPayment = $modelTrans->sumPaymentByDate($from_date, $end_date, $head, $institute_id);
        $sumReceiveCurDate = $modelTrans->sumReceiveByDate($date, $date, $head, $institute_id);
        $sumPaymentCurDate = $modelTrans->sumPaymentByDate($date, $date, $head, $institute_id);
        $opening_balance = ($sumReceive - $sumPayment);
        $closing_balance = ( ($opening_balance + $sumReceiveCurDate) - $sumPaymentCurDate );
        return view('institute.ledger.daily_sheet_search', compact('purchases', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'head'));
    }

    public function daily_sheet_old() {
        $modelTransaction = new Transaction();
        $cur_date = date('Y-m-d');
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($cur_date . ' -1 day'));
        $sumDebit = $modelTransaction->sumDebitBetweenDate($from_date, $end_date);
        $sumCredit = $modelTransaction->sumCreditBetweenDate($from_date, $end_date);
        $sumDebitCurDate = $modelTransaction->sumDebitBetweenDate($cur_date, $cur_date);
        $sumCreditCurDate = $modelTransaction->sumCreditBetweenDate($cur_date, $cur_date);
        $opening_balance = ($sumDebit - $sumCredit);
        $closing_balance = ( ($opening_balance + $sumDebitCurDate) - $sumCreditCurDate );
        $head = new Head();
        $all_debit = $modelTransaction->where('date', $cur_date)->whereNotNull('dr_head_id')->get();
        $all_credit = $modelTransaction->where('date', $cur_date)->whereNotNull('cr_head_id')->get();
        return view('institute.ledger.daily_sheet', compact('head', 'all_debit', 'all_credit', 'opening_balance', 'closing_balance'));
    }

    // Ajax Functions
    public function daily_sheet_search_old(Request $r) {
        $modelTransaction = new Transaction();
        $date = date_ymd($r->date);
        $head = $r->head_id;
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $head_id = !empty($head) ? $head : NULL;
        $sumDebit = $modelTransaction->sumDebitBetweenDate($from_date, $end_date, $head_id);
        $sumCredit = $modelTransaction->sumCreditBetweenDate($from_date, $end_date, $head_id);
        $sumDebitCurDate = $modelTransaction->sumDebitBetweenDate($date, $date, $head_id);
        $sumCreditCurDate = $modelTransaction->sumCreditBetweenDate($date, $date, $head_id);
        $opening_balance = ($sumDebit - $sumCredit);
        $closing_balance = ( ($opening_balance + $sumDebitCurDate) - $sumCreditCurDate );

        if (!is_null($head_id)) {
            $all_debit = $modelTransaction->where([['dr_head_id', $head_id], ['date', $date]])->get();
            $all_credit = $modelTransaction->where([['cr_head_id', $head_id], ['date', $date]])->get();
        } else {
            $all_debit = $modelTransaction->where('date', $date)->whereNotNull('dr_head_id')->get();
            $all_credit = $modelTransaction->where('date', $date)->whereNotNull('cr_head_id')->get();
        }

        return view('institute.ledger.daily_sheet_search', compact('all_debit', 'all_credit', 'opening_balance', 'closing_balance'));
    }

    public function search(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $head = $r->head;
        $sort_by = 'date';
        $sort_type = 'DESC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $query = Transaction::where('dr_head_id', $id)->orWhere('cr_head_id', $id);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            $query->where('voucher_type', $search_by);
        }
        if (!empty($search_head)) {
            $query->where('dr_subhead_id', $search_head)->orWhere('cr_subhead_id', $search_head);
        }
        if (!empty($search)) {
            $headarr = [];
            $dr_head = Particular::where('name', 'like', '%' . $search . '%')->get();
            foreach ($dr_head as $head) {
                $headarr[] = $head->id;
            }
            $query->whereIn('cr_particular_id', $headarr)->orWhereIn('dr_particular_id', $headarr);
        }
        $query->orderBy($sort_by, $sort_type);
        $dataset = $query->paginate($item_count);
        $subhead = new SubHead();
        return view('institute.transactions._list', compact('dataset', 'subhead'));
    }

}
