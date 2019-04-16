<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\WeightItem;
use App\Product;
use App\AfterProduction;
use App\Models\Transaction;
use App\User;
use Session;
use Illuminate\Http\Request;

class LedgerController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = Head::all();
        $tmodel = new Transaction();
        return view('Admin.ledger.index', compact('dataset', 'tmodel'));
    }

    public function show($id) {
        echo "silence is best";
    }

    public function view_ledger() {
        $dataset = Head::all();
        $tmodel = new Transaction();
        return view('Admin.ledger.view', compact('dataset', 'tmodel'));
    }

    public function head_transaction($id) {
        //pr($id);
        $all_debit = Transaction::where('dr_head_id', $id)->orderBy('pay_date', 'ASC')->get();
        $all_credit = Transaction::where('cr_head_id', $id)->orderBy('pay_date', 'ASC')->get();
        $head_id = $id;
        $head = new Head();
        return view('Admin.ledger.ledger_head', compact('head', 'head_id', 'all_debit', 'all_credit'));
    }

    public function subhead_transaction($id) {
        $all_debit = Transaction::where('dr_subhead_id', $id)->orderBy('pay_date', 'ASC')->get();
        $all_credit = Transaction::where('cr_subhead_id', $id)->orderBy('pay_date', 'ASC')->get();
        $head_id = $id;
        $head = new SubHead();
        return view('Admin.ledger.ledger_subhead', compact('head', 'head_id', 'all_debit', 'all_credit'));
    }

    public function particular_transaction($id) {
        $all_debit = Transaction::where('dr_particular_id', $id)->orderBy('pay_date', 'ASC')->get();
        $all_credit = Transaction::where('cr_particular_id', $id)->orderBy('pay_date', 'ASC')->get();
        $particular = Particular::find($id);
        $product = new Product();
        $after_product = new AfterProduction();
        $head = $particular->head->id;
        if ($head == HEAD_CREDITORS) {
            return view('Admin.ledger.ledger_particular_cr', compact('particular', 'product', 'all_debit', 'all_credit'));
        } elseif ($head == HEAD_DEBTORS) {
            return view('Admin.ledger.ledger_particular_dr', compact('particular', 'after_product', 'product', 'all_debit', 'all_credit'));
        } else {
            return view('Admin.ledger.ledger_particular', compact('particular', 'all_debit', 'all_credit'));
        }
    }

    public function ledger_search(Request $r) {
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $dataset = Head::all();
        $tmodel = new Transaction();
        return view('Admin.ledger._list', compact('dataset', 'tmodel', 'from_date', 'end_date'));
    }

    public function head_transaction_search(Request $r) {
        $id = $r->head;
        $sort_by = 'pay_date';
        $sort_type = 'ASC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $debit = Transaction::where('dr_head_id', $id);
        $credit = Transaction::where('cr_head_id', $id);
        if (!empty($from_date)) {
            $debit->whereBetween('pay_date', [$from_date, $end_date]);
            $credit->whereBetween('pay_date', [$from_date, $end_date]);
        }
        $all_debit = $debit->orderBy($sort_by, $sort_type)->get();
        $all_credit = $credit->orderBy($sort_by, $sort_type)->get();
        $head_id = $id;
        $head = new Head();

        return view('Admin.ledger.ledger_head_search', compact('all_debit', 'all_credit', 'head', 'head_id'));
    }

    public function subhead_transaction_search(Request $r) {
        $id = $r->head;
        $sort_by = 'pay_date';
        $sort_type = 'ASC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $debit = Transaction::where('dr_subhead_id', $id);
        $credit = Transaction::where('cr_subhead_id', $id);
        if (!empty($from_date)) {
            $debit->whereBetween('pay_date', [$from_date, $end_date]);
            $credit->whereBetween('pay_date', [$from_date, $end_date]);
        }
        $all_debit = $debit->orderBy($sort_by, $sort_type)->get();
        $all_credit = $credit->orderBy($sort_by, $sort_type)->get();
        $head_id = $id;
        $head = new SubHead();
        return view('Admin.ledger.ledger_subhead_search', compact('all_debit', 'all_credit', 'head', 'head_id'));
    }

    public function particular_transaction_search(Request $r) {
        $id = $r->head;
        $sort_by = 'pay_date';
        $sort_type = 'ASC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $debit = Transaction::where('dr_particular_id', $id);
        $credit = Transaction::where('cr_particular_id', $id);
        if (!empty($from_date)) {
            $debit->whereBetween('pay_date', [$from_date, $end_date]);
            $credit->whereBetween('pay_date', [$from_date, $end_date]);
        }
        $all_debit = $debit->orderBy($sort_by, $sort_type)->get();
        $all_credit = $credit->orderBy($sort_by, $sort_type)->get();
        $particular = Particular::find($id);
        $product = new Product();
        $after_product = new AfterProduction();
        $head = $particular->head->id;
        if ($head == HEAD_CREDITORS) {
            return view('Admin.ledger.ledger_particular_cr_search', compact('particular', 'product', 'all_debit', 'all_credit'));
        } elseif ($head == HEAD_DEBTORS) {
            return view('Admin.ledger.ledger_particular_dr_search', compact('particular', 'after_product', 'all_debit', 'all_credit'));
        } else {
            return view('Admin.ledger.ledger_particular_search', compact('particular', 'all_debit', 'all_credit'));
        }
    }

    public function daily_sheet() {
        $modelWeightItem = new WeightItem();
        $modelTrans = new Transaction();
        $head = new Head();
        $purchases = $modelWeightItem->totalPurchaseByDate();
        $sales = $modelWeightItem->totalSaleByDate();
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
        return view('Admin.ledger.daily_sheet', compact('purchases', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'head'));
    }

    // Ajax Functions
    public function daily_sheet_search(Request $r) {
        $modelWeightItem = new WeightItem();
        $modelTrans = new Transaction();
        $date = date_ymd($r->date);
        $head = $r->head_id;
        $purchases = $modelWeightItem->totalPurchaseByDate($date);
        $sales = $modelWeightItem->totalSaleByDate($date);
        $payments = $modelTrans->totalPaymentByDate($date, $head);
        $receives = $modelTrans->totalReceiveByDate($date, $head);
        $from_date = '1970-01-01';
        $end_date = date('Y-m-d', strtotime($date . ' -1 day'));
        $sumReceive = $modelTrans->sumReceiveByDate($from_date, $end_date, $head);
        $sumPayment = $modelTrans->sumPaymentByDate($from_date, $end_date, $head);
        $sumReceiveCurDate = $modelTrans->sumReceiveByDate($date, $date, $head);
        $sumPaymentCurDate = $modelTrans->sumPaymentByDate($date, $date, $head);
        $opening_balance = ($sumReceive - $sumPayment);
        $closing_balance = ( ($opening_balance + $sumReceiveCurDate) - $sumPaymentCurDate );
        return view('Admin.ledger.daily_sheet_search', compact('purchases', 'sales', 'payments', 'receives', 'opening_balance', 'closing_balance', 'date', 'head'));
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
        $all_debit = $modelTransaction->where('pay_date', $cur_date)->whereNotNull('dr_head_id')->get();
        $all_credit = $modelTransaction->where('pay_date', $cur_date)->whereNotNull('cr_head_id')->get();
        return view('Admin.ledger.daily_sheet', compact('head', 'all_debit', 'all_credit', 'opening_balance', 'closing_balance'));
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
            $all_debit = $modelTransaction->where([['dr_head_id', $head_id], ['pay_date', $date]])->get();
            $all_credit = $modelTransaction->where([['cr_head_id', $head_id], ['pay_date', $date]])->get();
        } else {
            $all_debit = $modelTransaction->where('pay_date', $date)->whereNotNull('dr_head_id')->get();
            $all_credit = $modelTransaction->where('pay_date', $date)->whereNotNull('cr_head_id')->get();
        }

        return view('Admin.ledger.daily_sheet_search', compact('all_debit', 'all_credit', 'opening_balance', 'closing_balance'));
    }

    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $head = $r->head;
        $sort_by = 'pay_date';
        $sort_type = 'DESC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $query = Transaction::where('dr_head_id', $id)->orWhere('cr_head_id', $id);
        if (!empty($from_date)) {
            $query->whereBetween('pay_date', [$from_date, $end_date]);
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
        return view('Admin.transactions._list', compact('dataset', 'subhead'));
    }

}
