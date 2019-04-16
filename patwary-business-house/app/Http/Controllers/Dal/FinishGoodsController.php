<?php

namespace App\Http\Controllers\Dal;

use App\Http\Controllers\HomeController;
use Exception;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;
use DB;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Dal\SalesChallan;
use App\Models\Dal\SalesChallanItem;

class FinishGoodsController extends HomeController {

    public function index() {
        check_user_access('dal_manage_finishgoods');
        $dataset = SalesChallan::where('type', 'in')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('dal.finishgoods.index', compact('dataset'));
    }

    public function finishgoodsList() {
        check_user_access('dal_manage_finishgoods');
        $categories = Category::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', DALMILL]])->get();
        $dataset = SalesChallanItem::where('type', 'in')->orderBy('date', 'DESC')->paginate($this->getSettings()->pagesize);
        return view('dal.finishgoods.list', compact('dataset', 'categories'));
    }

    public function create() {
        $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', DALMILL]])->orderBy('category_id')->get();
        return view('dal.finishgoods.create', compact('products'));
    }

    public function store(Request $r) {
        //pr($_POST);
        $resp = [];
        $invoice = $r->invoice_no;

        DB::beginTransaction();
        try {
            $inv = SalesChallan::where('invoice_no', $invoice)->first();
            if (!empty($inv)) {
                throw new Exception("Invoice already exist.");
            }

            if (empty($_POST['product'])) {
                throw new Exception("No Product has been selected. Please Select atleast one Product.");
            }

            $model = new SalesChallan();
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->invoice_no = $r->invoice_no;
            $model->type = 'in';
            $model->total_quantity = array_sum($_POST['quantity']);
            $model->created_by = Auth::id();
            $model->_key = uniqueKey();

            if (!$model->save()) {
                throw new Exception("Error! while creating purchase.");
            }

            $last_id = DB::getPdo()->lastInsertId();

            $total_price = [];
            if (!empty($_POST['product'])) {
                foreach ($_POST['product'] as $key => $value) {
                    if (!empty($_POST['product'][$key])) {
                        $_productName = Product::find($value)->name;
                        if (empty($_POST['quantity'][$value])) {
                            throw new Exception("Please Provide Quantity for <b>{$_productName}</b>.");
                        }

                        $modelItem = new SalesChallanItem();
                        $modelItem->date = $model->date;
                        $modelItem->sales_challan_id = $last_id;
                        $modelItem->type = $model->type;
                        $modelItem->invoice_no = $model->invoice_no;
                        $modelItem->category_id = $_POST['category_id'][$value];
                        $modelItem->product_id = $_POST['product_id'][$value];
                        $modelItem->quantity = $_POST['quantity'][$value];
                        $modelItem->created_by = $model->created_by;
                        $modelItem->_key = uniqueKey() . $key;
                        if (!$modelItem->save()) {
                            throw new Exception("Error! while creating Record items.");
                        }
                    }
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Record has been successfully inserted.';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function show($id) {
        $data = SalesChallan::find($id);
        return view('dal.finishgoods.details', compact('data'));
    }

    public function edit($id) {
        $data = SalesChallan::find($id);
        $products = Product::where([['type', 'Finish'], ['is_deleted', 0], ['business_type_id', DALMILL]])->orderBy('category_id')->get();
        return view('dal.finishgoods.edit', compact('data', 'products'));
    }

    public function update(Request $r, $id) {
        //pr($_POST);
        $input = $r->all();
        $rule = array(
            'date' => 'required',
        );

        $messages = array(
            'invoice_no.required' => 'Please insert invoice no',
        );

        $valid = Validator::make($input, $rule, $messages);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        DB::beginTransaction();
        try {
            $model = SalesChallan::find($id);
            $model->date = !empty($r->date) ? date_ymd($r->date) : date('Y-m-d');
            $model->type = 'in';
            $model->total_quantity = array_sum($_POST['quantity']);
            $model->modified_by = Auth::id();
            if (!$model->save()) {
                throw new Exception("Error! while updating purchase.");
            }
            foreach ($_POST['hid'] as $key => $value) {
                if (!empty($_POST['hid'][$key])) {
                    if (empty($_POST['quantity'][$value])) {
                        throw new Exception("Please Provide Quantity");
                    }

                    $modelItem = SalesChallanItem::find($value);
                    $modelItem->date = $model->date;
                    $modelItem->quantity = $_POST['quantity'][$value];
                    $modelItem->modified_by = $model->modified_by;

                    if (!$modelItem->save()) {
                        throw new Exception("Error! while updating purchase items.");
                    }
                }
            }
            DB::commit();
            return redirect('dal/finishgoods')->with('success', 'Record Updated Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function confirm($id) {
        $data = SalesChallan::find($id);
        DB::beginTransaction();
        try {
            $data->process_status = 1;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }

            DB::commit();
            return redirect('dal/finishgoods')->with('success', 'Record Processed Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function reset($id) {
        $data = SalesChallan::find($id);
        DB::beginTransaction();
        try {

            $data->process_status = 0;
            $data->modified_by = Auth::id();

            if (!$data->save()) {
                throw new Exception("Something Went Wrong. Please Re Submit your request.");
            }

            DB::commit();
            return redirect('dal/finishgoods')->with('success', 'SalesChallan Order Reset Successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function ledger() {
        $category = new Category();
        $dataset = SalesChallanItem::where('type', 'in')->paginate($this->getSettings()->pagesize);
        return view('dal.finishgoods.ledger', compact('dataset', 'subhead', 'particular', 'category'));
    }

    public function stocks() {
        $dataset = Product::orderBy('category_id', 'DESC')->get();
        $category = new Category();
        $product = new Product();
        return view('dal.finishgoods.stocks', compact('dataset', 'category', 'product', 'stock'));
    }

    public function stocks_search(Request $r) {
        //pr($_POST);
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $category = $r->category;
        $product = $r->product;
        $query = Product::query();
        if (!empty($category)) {
            $query->where('category_id', $category);
        }
        if (!empty($product)) {
            $query->where('id', $product);
        }
        $query->orderBy('category_id', 'DESC');
        $dataset = $query->paginate($item_count);
        $category = new Category();
        $product = new Product();
        return view('dal.finishgoods.stocks_search', compact('dataset', 'category', 'product'));
    }

// Ajax Functions
    public function search(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $order_type = 'in';
        $search_by = $r->input('search_by');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = SalesChallan::where('type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                $query->where('type', '=', $order_type);
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('invoice_no', 'like', '%' . $search . '%');
        }
        $dataset = $query->orderBy('date', 'DESC')->paginate($item_count);
        return view('dal.finishgoods._list', compact('dataset'));
    }

    public function finishgoodsListSearch(Request $r) {
        $item_count = !empty($r->item_count) ? $r->item_count : $this->getSettings()->pagesize;
        $order_type = 'in';
        $search_by_category = $r->input('search_by_category');
        $search_by_product = $r->input('search_by_product');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $order = $r->input('order');

        $query = SalesChallanItem::where('type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by_category)) {
            $query->where('category_id', $search_by_category);
        }
        if (!empty($search_by_product)) {
            $query->where('product_id', $search_by_product);
        }
        if (!empty($order)) {
            $query->where('invoice_no', 'like', '%' . $order . '%');
        }
        $dataset = $query->paginate($item_count);
        return view('dal.finishgoods.list_search', compact('dataset'));
    }

    public function delete() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = SalesChallan::with('items')->find($id);

                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Items.");
                        }
                    }
                }

                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Records  has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
