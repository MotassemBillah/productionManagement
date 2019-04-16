<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use DB;
use App\Models\EmptyBagStock;
use App\Models\BagSize;
use App\Models\BagColor;
use App\Models\BagType;
use App\Models\Transaction;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\User;
use Session;
use Validator;
use Illuminate\Http\Request;

class EmptyBagStockController extends HomeController {

    public function index() {
        $dataset = EmptyBagStock::orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        $subhead = new Particular();
        return view('Admin.emptybag_stock.index', compact('dataset', 'subhead'));
    }

    public function create($tp) {
        $heads = SubHead::get();
        $sizes = BagSize::get();
        $colors = BagColor::get();
        $types = BagType::get();
        return view('Admin.emptybag_stock.create', compact('tp', 'heads', 'sizes', 'colors', 'types'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'type' => 'required',
            'quantity' => 'required',
        );
        $messages = array(
            'frm_subhead.required' => 'Please select a Head',
            'to_subhead.required' => 'Please select a Head',
            'quantity.required' => 'You must provide a Quantity',
            'per_bag_price.required' => 'You must provide Per Bag Price',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if ($r->type == 'd') {
            $type = 'Receive';
            $debit = $r->total_price;
            $voucher_type = PURCHASE_VOUCHER;
            $credit = NULL;
        } else {
            $type = 'Payment';
            $debit = NULL;
            $voucher_type = SALES_VOUCHER;
            $credit = $r->total_price;
        }

        if ($r->type == 'd') {
            $mSubhead = new SubHead();
            $cr_subhead = $r->frm_subhead;
            $cr_head = $mSubhead->find($cr_subhead)->head_id;
            $cr_particular = $r->frm_particular;
//        $dr_subhead = $r->to_subhead;
//        $dr_head = $mSubhead->find($dr_subhead)->head_id;
//        $dr_particular = $r->to_particular;
        }

        $model = new EmptyBagStock();
        $model->type = $type;
        $model->date = date_ymd($r->date);
//        $model->dr_head_id = $dr_head;
//        $model->dr_subhead_id = $dr_subhead;
//        $model->dr_particular_id = $dr_particular;
        if ($r->type == 'd') {
            $model->cr_head_id = $cr_head;
            $model->cr_subhead_id = $cr_subhead;
            $model->cr_particular_id = $cr_particular;
        }
        $model->by_whom = $r->by_whom;
        $model->description = $r->description;
        $model->challan_no = $r->challan_no;
//        $model->debit = $debit;
//        $model->credit = $credit;
        $model->quantity = $r->quantity;
        $model->size = $r->size;
        $model->color = $r->color;
        $model->bag_type = $r->bag_type;
//        $model->per_bag_price = $r->per_bag_price;
//        $model->total_price = $r->total_price;
        $model->created_by = Auth::id();
        $model->is_edible = 1;
        $model->is_dbl = 1;
        $model->_key = uniqueKey();

        DB::beginTransaction();
        try {

            if (!$model->save()) {
                throw new Exception("Error! while creating Records.");
            }
//            $last_id = DB::getPdo()->lastInsertId();
//
//            $transaction = new Transaction();
//            $transaction->empty_bag_id = $last_id;
//            $transaction->type = 'D';
//            $transaction->voucher_type = $voucher_type;
//            $transaction->pay_date = $model->date;
//            $transaction->dr_head_id = $model->dr_head_id;
//            $transaction->dr_subhead_id = $model->dr_subhead_id;
//            $transaction->dr_particular_id = $model->dr_particular_id;
//            $transaction->cr_head_id = $model->cr_head_id;
//            $transaction->cr_subhead_id = $model->cr_subhead_id;
//            $transaction->cr_particular_id = $model->cr_particular_id;
//            $transaction->by_whom = $model->by_whom;
//            $transaction->description = $model->description;
//            $transaction->debit = $model->total_price;
//            $transaction->credit = $model->total_price;
//            $transaction->amount = $model->total_price;
//            $transaction->note = $transaction->description;
//            $transaction->created_by = $model->created_by;
//            $transaction->_key = uniqueKey();
//            if (!$transaction->save()) {
//                throw new Exception("Error while saving data in Transaction.");
//            }

            DB::commit();
            return redirect('/emptybag-stock')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        $data = EmptyBagStock::find($id);
        $heads = SubHead::get();
        $sizes = BagSize::get();
        $colors = BagColor::get();
        $types = BagType::get();
        return view('Admin.emptybag_stock.edit', compact('data', 'heads', 'sizes', 'colors', 'types'));
    }

    public function show($id) {
        $data = EmptyBagStock::find($id);
        $subhead = new SubHead();
        return view('Admin.emptybag_stock.view', compact('data', 'subhead'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
            'type' => 'required',
            'quantity' => 'required',
        );
        $messages = array(
            'frm_subhead.required' => 'Please select a Head',
            'to_subhead.required' => 'Please select a Head',
            'quantity.required' => 'You must provide a Quantity',
            'per_bag_price.required' => 'You must provide Per Bag Price',
        );

        $valid = Validator::make($input, $rule, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if ($r->type == 'd') {
            $type = 'Receive';
            $debit = $r->total_price;
            $voucher_type = PURCHASE_VOUCHER;
            $credit = NULL;
        } else {
            $type = 'Payment';
            $debit = NULL;
            $voucher_type = SALES_VOUCHER;
            $credit = $r->total_price;
        }

        if ($r->type == 'd') {
            $mSubhead = new SubHead();
            $cr_subhead = $r->frm_subhead;
            $cr_head = $mSubhead->find($cr_subhead)->head_id;
            $cr_particular = $r->frm_particular;
//        $dr_subhead = $r->to_subhead;
//        $dr_head = $mSubhead->find($dr_subhead)->head_id;
//        $dr_particular = $r->to_particular;
        }

        $model = EmptyBagStock::find($id);
        $model->date = date_ymd($r->date);
//        $model->dr_head_id = $dr_head;
//        $model->dr_subhead_id = $dr_subhead;
//        $model->dr_particular_id = $dr_particular;
        if ($r->type == 'd') {
            $model->cr_head_id = $cr_head;
            $model->cr_subhead_id = $cr_subhead;
            $model->cr_particular_id = $cr_particular;
        }
        $model->by_whom = $r->by_whom;
        $model->description = $r->description;
        $model->challan_no = $r->challan_no;
//        $model->debit = $debit;
//        $model->credit = $credit;
        $model->quantity = $r->quantity;
        $model->size = $r->size;
        $model->color = $r->color;
        $model->bag_type = $r->bag_type;
//        $model->per_bag_price = $r->per_bag_price;
//        $model->total_price = $r->total_price;
        $model->modified_by = Auth::id();

        DB::beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }
//            $transaction = Transaction::where('empty_bag_id', $model->id)->first();
//            $transaction->pay_date = $model->date;
//            $transaction->dr_head_id = $model->dr_head_id;
//            $transaction->dr_subhead_id = $model->dr_subhead_id;
//            $transaction->dr_particular_id = $model->dr_particular_id;
//            $transaction->cr_head_id = $model->cr_head_id;
//            $transaction->cr_subhead_id = $model->cr_subhead_id;
//            $transaction->cr_particular_id = $model->cr_particular_id;
//            $transaction->by_whom = $model->by_whom;
//            $transaction->description = $model->description;
//            $transaction->debit = $model->total_price;
//            $transaction->credit = $model->total_price;
//            $transaction->amount = $model->total_price;
//            $transaction->note = $transaction->description;
//            $transaction->modified_by = $model->modified_by;
//            if (!$transaction->save()) {
//                throw new Exception("Error while Updating data in Transaction.");
//            }
            DB::commit();
            return redirect('/emptybag-stock')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $search_by = $r->search_by;
        // $search_head = $r->search_head;
        $sort_by = 'date';
        $sort_type = 'DESC';
        $from_date = date_ymd($r->from_date);
        $end_date = !empty($r->end_date) ? date_ymd($r->end_date) : date('Y-m-d');
        //$search = $r->input('search');
        $query = EmptyBagStock::query();
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            $query->where('type', $search_by);
        }
//        if (!empty($search_head)) {
//            $query->where('dr_particular_id', $search_head)->orWhere('cr_particular_id', $search_head);
//        }
//        if (!empty($search)) {
//            $headarr = [];
//            $dr_head = Particular::where('name', 'like', '%' . $search . '%')->get();
//            foreach ($dr_head as $head) {
//                $headarr[] = $head->id;
//            }
//            $query->whereIn('dr_particular_id', $headarr)->orWhereIn('cr_particular_id', $headarr);
//        }
        $query->orderBy($sort_by, $sort_type);
        $dataset = $query->paginate($item_count);
        $subhead = new SubHead();
        return view('Admin.emptybag_stock._list', compact('dataset', 'subhead'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = EmptyBagStock::find($id);

//                if (!empty($data->transactions)) {
//                    foreach ($data->transactions as $trans) {
//                        if (!$trans->delete()) {
//                            throw new Exception("Error while deleting records from Transactions.");
//                        }
//                    }
//                }

                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Empty Bag has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
