<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\Transaction;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\Head;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class TransactionController extends HomeController {

    public function index() {
        $dataset = Transaction::orderBy('pay_date', 'DESC')->paginate($this->getSettings()->pagesize);
        $subhead = new SubHead();
        return view('Admin.transactions.index', compact('dataset', 'subhead'));
    }

    public function create($tp) {
        $heads = SubHead::get();
        return view('Admin.transactions.create', compact('tp', 'heads'));
    }

    public function store(Request $r) {
        $input = $r->all();
        $rule = array(
            'frm_subhead' => 'required',
            'to_subhead' => 'required',
            'amount' => 'required',
        );
        $messages = array(
            'frm_subhead.required' => 'Please select a head',
            'to_subhead.required' => 'Please select a head',
            'amount.required' => 'You must provide a amount',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if ($r->type == 'd') {
            $type = strtoupper($r->type);
            $voucher_type = RECEIVE_VOUCHER;
        } elseif ($r->type == 'c') {
            $type = strtoupper($r->type);
            $voucher_type = PAYMENT_VOUCHER;
        } else {
            $type = NULL;
            $voucher_type = DUE_VOUCHER;
        }

        $mSubhead = new SubHead();
        $cr_subhead = $r->frm_subhead;
        $cr_head = $mSubhead->find($cr_subhead)->head_id;
        $cr_particular = $r->frm_particular;
        $dr_subhead = $r->to_subhead;
        $dr_head = $mSubhead->find($dr_subhead)->head_id;
        $dr_particular = $r->to_particular;

        $model = new Transaction();
        $model->type = $type;
        $model->voucher_type = $voucher_type;
        $model->pay_date = date_ymd($r->transaction_date);
        $model->payment_method = $r->payment_method;
        $model->dr_head_id = $dr_head;
        $model->dr_subhead_id = $dr_subhead;
        $model->dr_particular_id = $dr_particular;
        $model->cr_head_id = $cr_head;
        $model->cr_subhead_id = $cr_subhead;
        $model->cr_particular_id = $cr_particular;
        $model->by_whom = $r->by_whom;
        $model->description = $r->description;
        $model->debit = $r->amount;
        $model->credit = $r->amount;
        $model->amount = $r->amount;
        $model->note = $r->description;
        $model->created_by = Auth::id();
        $model->is_edible = 1;
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Creating Transaction.");
            }

            DB::commit();
            return redirect('/transactions')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        $data = Transaction::find($id);
        $heads = SubHead::get();
        $particular = new Particular ();
        return view('Admin.transactions.edit', compact('data', 'heads', 'particular'));
    }

    public function show($id) {
        $data = Transaction::find($id);
        $subhead = new SubHead();
        return view('Admin.transactions.view', compact('data', 'subhead'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rule = array(
            'frm_subhead' => 'required',
            'to_subhead' => 'required',
            'amount' => 'required',
        );
        $messages = array(
            'frm_subhead.required' => 'Please select a head',
            'to_subhead.required' => 'Please select a head',
            'amount.required' => 'You must provide a amount',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if ($r->type == 'd') {
            $type = strtoupper($r->type);
            $voucher_type = RECEIVE_VOUCHER;
        } elseif ($r->type == 'c') {
            $type = strtoupper($r->type);
            $voucher_type = PAYMENT_VOUCHER;
        } else {
            $type = NULL;
            $voucher_type = DUE_VOUCHER;
        }

        $mSubhead = new SubHead();
        $cr_subhead = $r->frm_subhead;
        $cr_head = $mSubhead->find($cr_subhead)->head_id;
        $cr_particular = $r->frm_particular;
        $dr_subhead = $r->to_subhead;
        $dr_head = $mSubhead->find($dr_subhead)->head_id;
        $dr_particular = $r->to_particular;

        $model = Transaction::find($id);
        $model->pay_date = date_ymd($r->transaction_date);
        $model->dr_head_id = $dr_head;
        $model->dr_subhead_id = $dr_subhead;
        $model->dr_particular_id = $dr_particular;
        $model->cr_head_id = $cr_head;
        $model->cr_subhead_id = $cr_subhead;
        $model->cr_particular_id = $cr_particular;
        $model->by_whom = $r->by_whom;
        $model->description = $r->description;
        $model->debit = $r->amount;
        $model->credit = $r->amount;
        $model->amount = $r->amount;
        $model->note = $r->description;
        $model->modified_by = Auth::id();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }
            DB::commit();
            return redirect('/transactions')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $search_by = $r->search_by;
        $search_head = $r->search_head;
        $sort_by = 'pay_date';
        $sort_type = 'DESC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $search = $r->input('search');
        $query = Transaction::query();
        if (!empty($from_date)) {
            $query->whereBetween('pay_date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            $query->where('voucher_type', $search_by);
        }
        if (!empty($search_head)) {
            if (!empty($search_by)) {
                $query->where([['voucher_type',$search_by],['dr_subhead_id', $search_head]])->orWhere([['voucher_type',$search_by],['cr_subhead_id', $search_head]]);
            } else {
                $query->where('dr_subhead_id', $search_head)->orWhere('cr_subhead_id', $search_head);
            }
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

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Transaction::find($id);
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Transaction has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function expenses() {
        //check_user_access('supplier');
        $dataset = Transaction::where('voucher_type', PAYMENT_VOUCHER)->get();
        $head = new Head();
        $subhead = new SubHead();
        return view('Admin.transactions.expense', compact('dataset', 'subhead', 'head'));
    }

    public function expense_search(Request $r) {
        $item_count = $r->input('item_count');
        $search_by = $r->head_id;
        $sort_by = 'pay_date';
        $sort_type = 'DESC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        $search = $r->input('search');
        $query = Transaction::where('voucher_type', PAYMENT_VOUCHER);
        if (!empty($from_date)) {
            $query->whereBetween('pay_date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            $query->where('ledger_head_id', $search_by);
        }
        if (!empty($search)) {
            $headarr = [];
            $dr_head = SubHead::where('name', 'like', '%' . $search . '%')->get();
            foreach ($dr_head as $head) {
                $headarr[] = $head->id;
            }
            $query->whereIn('sub_head_id', $headarr);
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $dataset = $query->get();
        $head = new Head();
        $subhead = new SubHead();
        return view('Admin.transactions._expense_list', compact('dataset', 'subhead', 'head'));
    }

}
