<?php

namespace App\Http\Controllers;

use Exception;
use Auth;
use App\Models\Customer;
use App\Models\Transactions;
use App\Models\LedgerHead;
use App\Models\LedgerSubHead;
use Validator;
use DB;
use Illuminate\Http\Request;

class CustomerController extends HomeController {

    public function index() {
        $transaction = new Transactions();
        $dataset = Customer::where('is_deleted', 0)->orderBy('name', 'ASC')->get();
        return view('Admin.customer.index', compact('dataset', 'transaction'));
    }

    public function create() {
        $heads = LedgerHead::where('is_deleted', 0)->get();
        return view('Admin.customer.create', compact('heads'));
    }

    public function store(Request $r) {
        $input = $r->all();
        $rules = array(
            'head' => 'required',
            'name' => 'required',
            'mobile' => 'required',
        );

        $messages = array(
            'head.required' => 'Please Select a Head.',
            'name.required' => 'Customer name can not be empty.',
            'mobile.required' => 'Mobile can not be empty.',
        );

        $valid = Validator::make($input, $rules, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $modelHead = new LedgerSubHead();
        $modelHead->head_id = $r->head;
        $modelHead->name = $r->name;
        $modelHead->code = time();
        $modelHead->_key = uniqueKey();

        DB::beginTransaction();
        try {
            if (!$modelHead->save()) {
                throw new Exception("Query Problem on Creating Subhead.");
            }
            $subhead_id = DB::getPdo()->lastInsertId();
            $modelCus = new Customer();
            $modelCus->head_id = $modelHead->head_id;
            $modelCus->subhead_id = $subhead_id;
            $modelCus->name = $modelHead->name;
            $modelCus->mobile = $r->mobile;
            $modelCus->email = $r->email;
            $modelCus->address = $r->address;
            $modelCus->created_by = $modelHead->created_by;

            if (!$modelCus->save()) {
                throw new Exception("Query Problem on Creating Record.");
            }

            DB::commit();
            return redirect('customers')->with('success', 'New Record Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function edit($id) {
        $data = Customer::find($id);
        $heads = LedgerHead::where('is_deleted', 0)->get();
        return view('Admin.customer.edit', compact('data', 'heads'));
    }

    public function update(Request $r, $id) {
        $input = $r->all();
        $rules = array(
            'head' => 'required',
            'name' => 'required',
            'mobile' => 'required',
        );

        $messages = array(
            'head.required' => 'Please Select a Head.',
            'name.required' => 'Customer name can not be empty.',
            'mobile.required' => 'Mobile can not be empty.',
        );

        $valid = Validator::make($input, $rules, $messages);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $modelCust = Customer::find($id);
        $modelCust->head_id = $r->head_id;
        $modelCust->name = $r->name;
        $modelCust->mobile = $r->mobile;
        $modelCust->email = $r->email;
        $modelCust->address = $r->address;
        $modelCust->modified_by = Auth::id();
        DB::beginTransaction();
        try {
            if (!$modelCust->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }
            
            $modelHead = LedgerSubHead::find($modelCust->subhead_id);
            $modelHead->head_id = $modelCust->head_id;
            $modelHead->name = $modelCust->name;
            
             if (!$modelHead->save()) {
                throw new Exception("Query Problem on Updating Record.");
            }

            DB::commit();
            return redirect('category')->with('success', 'Category Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    // Ajax Functions
    public function search(Request $r) {
        //$this->is_ajax_request(Request $request);
        $item_count = $r->input('item_count');
        $sort_by = 'name';
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = Category::query();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $dataset = $query->get();
        return view('Admin.category._list', compact('dataset'));
    }

    public function delete() {
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Category::with('products', 'after_production')->find($id);
                //pr($data);
                if (!empty($data->products)) {
                    if (!empty($data->products->stocks)) {
                        foreach ($data->products->stocks as $stock) {
                            if (!$stock->delete()) {
                                throw new Exception("Error while deleting records from Stock.");
                            }
                        }
                    }
                    if (!empty($data->products->production_stocks)) {
                        foreach ($data->products->production_stocks as $pstock) {
                            if (!$pstock->delete()) {
                                throw new Exception("Error while deleting records from Production Stock.");
                            }
                        }
                    }
                    foreach ($data->products as $product) {
                        if (!$product->delete()) {
                            throw new Exception("Error while deleting records from Product.");
                        }
                    }
                }
                if (!empty($data->after_production)) {
                    foreach ($data->after_production as $aproduct) {
                        if (!$aproduct->delete()) {
                            throw new Exception("Error while deleting records from After Production.");
                        }
                    }
                }
                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Category has been deleted successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
