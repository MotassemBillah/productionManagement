<?php

namespace App\Http\Controllers;

use Exception;
use App\Agent;
use App\Customer;
use App\Product;
use App\ProductItem;
use App\Stock;
use App\Weight;
use App\Payment;
use App\User;
use App\Category;
use App\ProductionOrder;
use App\ProductionStock;
use App\ProductionItem;
use Illuminate\Http\Request;
use Response;
use DB;

class AjaxController extends HomeController {

    //Function for Ajax Request to get Thany by District ID
    public function get_thana(Request $r) {
        if ($r->ajax()) {
            $dist_id = $r->input('dist');
            $result = Agent::get_thana_by_dist_id($dist_id);
            // echo "<pre>";
            // print_r ($result);
            return view('Ajax.thana', compact('result'));
        }
    }

    //Function for Ajax Request to get Product by CAtegory ID
    public function get_product_by_category($id) {
        if (isset($id)) {
            $result = Product::where('category_id', '=', $id)->get();
            return view('Ajax.product', compact('result'));
        }
    }

    //Function for Ajax Request to check Invoice
    public function check_invoice($invoice) {
        if (isset($invoice)) {
            if (Weight::where('invoice_no', '=', $invoice)->get()->count() > 0) {
                return "<label class='text-danger'>Invoice already exists</label>";
            }
        }
    }

    //Function for Ajax Request to check Production Order Number
    public function check_order($order) {
        if (isset($order)) {
            if (ProductionOrder::where('process_order_no', '=', $order)->get()->count() > 0) {
                return "<label class='text-danger'>Order Number already exists</label>";
            }
        }
    }

    //Function for Ajax Request to get Product by CAtegory ID
    public function get_product_number($id) {
        if (isset($id)) {
            $result = DB::table('product_items')->where('product_id', '=', $id)->get();
            return view('Ajax.product-number', compact('result'));
        }
    }

    //Function for Ajax Request to get Product by CAtegory ID
//    public function get_customer_info($id) {
//        if (isset($id)) {
//            $result = DB::table('tbl_customer')->where('id', '=', $id)->first();
//            return view('Ajax.customer-info', compact('result'));
//        }
//    }
    //Function for Ajax Request to get Product by CAtegory ID
    public function get_agent_info($id) {
        if (isset($id)) {
            $result = DB::table('tbl_agent')->where('id', '=', $id)->first();
            return view('Ajax.agent-info', compact('result'));
        }
    }

    public function get_supplier_info() {
        //pr($_POST);
        $resp = [];
        $_sid = $_POST['sid'];
        $supplier = Agent::find($_sid);
        if (!empty($supplier)) {
            $resp['success'] = true;
            $resp['data']['name'] = $supplier->agent_name;
            $resp['data']['father_name'] = $supplier->agent_father;
            $resp['data']['code'] = $supplier->agent_code;
            $resp['data']['mobile'] = $supplier->agent_mobile;
            $resp['data']['email'] = $supplier->agent_email;
            $resp['data']['address'] = $supplier->address;
        } else {
            $resp['success'] = false;
            $resp['data'] = null;
        }
        return json_encode($resp);
    }

    public function get_customer_info() {
        //pr($_POST);
        $resp = [];
        $_cid = $_POST['cid'];
        $customer = Customer::find($_cid);
        if (!empty($customer)) {
            $resp['success'] = true;
            $resp['data']['name'] = $customer->customer_name;
            $resp['data']['father_name'] = $customer->customer_father;
            $resp['data']['code'] = $customer->customer_code;
            $resp['data']['mobile'] = $customer->customer_mobile;
            $resp['data']['email'] = $customer->customer_email;
            $resp['data']['address'] = $customer->address;
        } else {
            $resp['success'] = false;
            $resp['data'] = null;
        }
        return json_encode($resp);
    }

    //Function for Ajax Request to get Product by CAtegory ID
    public function get_company_info($id) {
        if (isset($id)) {
            $result = DB::table('tbl_company')->where('id', '=', $id)->first();
            return view('Ajax.company-info', compact('result'));
        }
    }

    public function get_production_order_info($id) {
        if (isset($id)) {
            $results = ProductionItem::where([['production_id', '=', $id], ['process_status', '=', 1], ['stock_status', '=', 0]])->get();
            //pr($results);
            return view('Ajax.production_info', compact('results'));
        }
    }

    public function get_complete_production_info($id) {
        if (isset($id)) {
            $products = ProductionItem::find($id);
            $cat_id = $products->category_id;
            $sub_cat = DB::table('after_production')->where('category_id', '=', $cat_id)->get();
            return view('Ajax.after_production', compact('products', 'sub_cat'));
        }
    }

    public function get_purchase_invoice($invoice) {
        if (isset($invoice)) {
            $payment_info = Payment::where('invoice_no', '=', $invoice)->first();
            return view('Ajax.purchase_invoice', compact('payment_info'));
        }
    }

    // Method for Retriving Search Request
    public function get_production_stocks_list(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $product_no = $r->product_no;
        $sort_by = 'after_production_id';
        $sort_type = 'ASC';
        $search = $r->search;
        $query = ProductionStock::query();
        if (!empty($category)) {
            $query->where('category_id', $category);
        }
        if (!empty($product)) {
            $query->where('product_id', $product);
        }
        if (!empty($product_no)) {
            $query->where('product_no_id', $product_no);
        }
        if (!empty($search)) {
            $productarr = [];
            $products = ProductItem::where('name', 'like', '%' . $search . '%')->get();
            foreach ($products as $product) {
                $productarr[] = $product->id;
            }
            $query->whereIn('product_no_id', $productarr);
        }

        $query->orderBy($sort_by, $sort_type)->groupBy('product_id', 'product_no_id', 'after_production_id');
        $query->limit($item_count);

        $category = new Category();
        $product = new Product();
        $product_no = new ProductItem();
        $dataset = $query->get();
        return view('Ajax.production_stock_list', compact('dataset', 'category', 'product', 'product_no'));
    }

    public function get_stocks_list(Request $r) {
        $item_count = $r->input('item_count');
        $weight_type = 'in_weight';
        $category = $r->category;
        $product = $r->product;
        $product_no = $r->product_no;
        $sort_by = 'date';
        $sort_type = 'ASC';
        $search = $r->search;
        $query = Stock::where('weight_type', '=', $weight_type);
        if (!empty($category)) {
            $query->where('category_id', $category);
        }
        if (!empty($product)) {
            $query->where('product_id', $product);
        }
        if (!empty($product_no)) {
            $query->where('product_no_id', $product_no);
        }
        if (!empty($search)) {
            $productarr = [];
            $products = ProductItem::where('name', 'like', '%' . $search . '%')->get();
            foreach ($products as $product) {
                $productarr[] = $product->id;
            }
            $query->whereIn('product_no_id', $productarr);
        }

        $query->orderBy($sort_by, $sort_type)->groupBy('product_no_id');
        $query->limit($item_count);

        $category = new Category();
        $product = new Product();
        $product_no = new ProductItem();
        $dataset = $query->get();
        return view('Admin.Stocks._list', compact('dataset', 'category', 'product', 'product_no'));
    }

    public function get_order_info(Request $r) {
        $item_count = $r->input('item_count');
        $order_type = 'in_weight';
        $search_by = $r->input('search_by');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = Weight::where('weight_type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                $query->where('weight_type', '=', $order_type);
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('invoice_no', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $orders = $query->get();
        return view('Ajax.order_list', compact('orders'));
    }

    public function get_purchase_list(Request $r) {
        //pr ($_POST);
        $item_count = $r->input('item_count');
        $order_type = 'in_weight';
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $query = Weight::where('weight_type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search)) {
            if ($sort_by == 'invoice_no') {
                $query->where('invoice_no', 'like', '%' . $search . '%');
            } else {
                $query->where('challan_no', 'like', '%' . $search . '%');
            }
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        //dd($query); 
        $orders = $query->get();
        return view('Ajax.purchase_list', compact('orders'));
    }

    public function get_sales_list_details(Request $r) {
        //pr ($_POST);
        $item_count = $r->input('item_count');
        $order_type = 'out_weight';
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $query = Weight::where('weight_type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search)) {
            if ($sort_by == 'invoice_no') {
                $query->where('invoice_no', 'like', '%' . $search . '%');
            } else {
                $query->where('challan_no', 'like', '%' . $search . '%');
            }
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        //pr($query->toSql(),false); 
        $orders = $query->get();
        return view('Ajax.sales_list_details', compact('orders'));
    }

    public function get_production_order_list(Request $r) {
        $item_count = $r->input('item_count');
        $search_by = $r->input('search_by');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = ProductionOrder::where('id', '!=', null);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('process_order_no', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $orders = $query->get();
        return view('Ajax.production_order_list', compact('orders'));
    }

    public function get_sale_info(Request $r) {
        $item_count = $r->input('item_count');
        $order_type = 'out_weight';
        $search_by = $r->input('search_by');
        $search_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty($r->input('end_date')) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');

        $query = Weight::where('weight_type', '=', $order_type);
        if (!empty($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        if (!empty($search_by)) {
            if ($search_by == 'all') {
                $query->where('weight_type', '=', $order_type);
            } else if ($search_by == 'pending') {
                $query->where('process_status', '=', '0');
            } else {
                $query->where('process_status', '=', '1');
            }
        }
        if (!empty($search)) {
            $query->where('invoice_no', 'like', '%' . $search . '%');
        }
        $query->limit($item_count);
        $orders = $query->get();
        return view('Ajax.sales_list', compact('orders'));
    }

    public function get_production_sale_info(Request $r) {
        $item_count = $r->input('item_count');
        $order_type = 'out_weight';
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $from_date = date_ymd($r->input('from_date'));
        $end_date = !empty(date_ymd($r->input('end_date'))) ? date_ymd($r->input('end_date')) : date('Y-m-d');
        $search = $r->input('search');
        $orders = ProductionStock::where('type', '=', $order_type)->whereBetween('date', [$from_date, $end_date])->orderBy($sort_by, $sort_type)->orWhere('invoice_no', 'like', '%' . $search . '%')->limit($item_count)->get();
        return view('Ajax.production_sales_list', compact('orders'));
    }

    public function get_customer_list(Request $r) {
        $item_count = $r->input('item_count');
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = DB::table('tbl_customer');
        if (!empty($search)) {
            $query->where('customer_name', 'like', '%' . $search . '%')->orWhere('customer_code', 'like', '%' . $search . '%')->orWhere('customer_mobile', 'like', '%' . $search . '%')->orWhere('customer_father', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $customer = $query->get();
        return view('Ajax.customer_list', compact('customer'));
    }

    public function get_company_list(Request $r) {
        $item_count = $r->input('item_count');
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = DB::table('tbl_company');
        if (!empty($search)) {
            $query->where('company_name', 'like', '%' . $search . '%')->orWhere('company_code', 'like', '%' . $search . '%')->orWhere('company_mobile', 'like', '%' . $search . '%')->orWhere('company_address', 'like', '%' . $search . '%')->orWhere('company_email', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $company = $query->get();
        return view('Ajax.company_list', compact('company'));
    }

    public function get_agent_list(Request $r) {
        $item_count = $r->input('item_count');
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = DB::table('tbl_agent');
        if (!empty($search)) {
            $query->where('agent_name', 'like', '%' . $search . '%')->orWhere('agent_mobile', 'like', '%' . $search . '%')->orWhere('agent_code', 'like', '%' . $search . '%')->orWhere('agent_father', 'like', '%' . $search . '%')->orWhere('agent_company', 'like', '%' . $search . '%')->orWhere('agent_email', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $agent = $query->get();
        return view('Ajax.agent_list', compact('agent'));
    }

    public function get_category_list(Request $r) {
        $item_count = $r->input('item_count');
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $query = DB::table('categories');
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('unit', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
        }
        $query->orderBy($sort_by, $sort_type);
        $query->limit($item_count);
        $product_cat = $query->get();
        return view('Ajax.category_list', compact('product_cat'));
    }

    public function get_after_product_category_list(Request $r) {
        //pr($_POST);
        $item_count = $r->input('item_count');
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $after_production = DB::table('after_production')->Where('name', 'like', '%' . $search . '%')->orderBy($sort_by, $sort_type)->limit($item_count)->get();
        return view('Ajax.after_category_list', compact('after_production'));
    }

    public function get_product_list(Request $r) {
        //pr($_POST);
        $item_count = $r->input('item_count');
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $products = Product::where('name', 'like', '%' . $search . '%')->orderBy($sort_by, $sort_type)->limit($item_count)->get();
        return view('Ajax.product_list', compact('products'));
    }

    public function get_product_number_list(Request $r) {
        $item_count = $r->input('item_count');
        $sort_by = $r->input('sort_by');
        $sort_type = $r->input('sort_type');
        $search = $r->input('search');
        $product_number = DB::table('product_items')->orderBy($sort_by, $sort_type)->orWhere('name', 'like', '%' . $search . '%')->limit($item_count)->get();
        return view('Ajax.product_number_list', compact('product_number'));
    }

    public function delete_users_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $user = DB::table('users')->where('id', '=', $id);
                if (!$user->delete()) {
                    throw new Exception("Error while Deleting Records from User.");
                }
                $permisstion = DB::table('permissions')->where('user_id', '=', $id);
                if (!$permisstion->delete()) {
                    throw new Exception("Error while Deleting Records from Permisstion.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Users has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    //Function for Delete Agent by ID
    public function delete_agent_by_id() {
        check_user_access('supplier_delete');
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result = DB::table('tbl_agent')->where('id', '=', $id);
                if (!$result->delete()) {
                    throw new Exception("Error while Deleting Records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Supplier has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_customer_by_id() {
        check_user_access('customer_delete');
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result = DB::table('tbl_customer')->where('id', '=', $id);
                if (!$result->delete()) {
                    throw new Exception("Error while Deleting Records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Customer has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_company_by_id() {
        check_user_access('company_delete');
        //pr($_POST);
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result = DB::table('tbl_company')->where('id', '=', $id);
                if (!$result->delete()) {
                    throw new Exception("Error while Deleting Records.");
                }
                $pcode = $_POST['pcode'][$id];
                $particular = DB::table('ca_ledger_particulers')->where('p_code', '=', $pcode);
                if (!$particular->delete()) {
                    throw new Exception("Error while Deleting Records from Particular.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Company has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_category_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result = DB::table('categories')->where('id', '=', $id);
                if (!$result->delete()) {
                    throw new Exception("Error while Deleting Records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Product Category has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_after_production_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result = DB::table('after_production')->where('id', '=', $id);
                if (!$result->delete()) {
                    throw new Exception("Error while Deleting Records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'After Production has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_product_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result = DB::table('products')->where('id', '=', $id);
                if (!$result->delete()) {
                    throw new Exception("Error while Deleting Records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Product has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_product_number_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result = DB::table('product_items')->where('id', '=', $id);
                if (!$result->delete()) {
                    throw new Exception("Error while Deleting Records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Product Items has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_purchase_order_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Weight::with('items', 'stocks', 'purchase_supplier_transaction', 'purchase_customer_transaction')->find($id);

                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Items.");
                        }
                    }
                }

                if (!empty($data->stocks)) {
                    foreach ($data->stocks as $stock) {
                        if (!$stock->delete()) {
                            throw new Exception("Error while deleting records from Stocks.");
                        }
                    }
                }

                if (!empty($data->purchase_customer_transaction)) {
                    if (!empty($data->purchase_customer_transaction->transactions)) {
                        foreach ($data->purchase_customer_transaction->transactions as $transaction) {
                            if (!$transaction->delete()) {
                                throw new Exception("Error while deleting records from Transaction.");
                            }
                        }
                    }
                    if (!$data->purchase_customer_transaction->delete()) {
                        throw new Exception("Error while deleting records from Customer Transaction.");
                    }
                }

                if (!empty($data->purchase_supplier_transaction)) {
                    if (!empty($data->purchase_supplier_transaction->transactions)) {
                        foreach ($data->purchase_supplier_transaction->transactions as $transaction) {
                            if (!$transaction->delete()) {
                                throw new Exception("Error while deleting records from Transaction.");
                            }
                        }
                    }
                    if (!$data->purchase_supplier_transaction->delete()) {
                        throw new Exception("Error while deleting records from Supplier Transaction.");
                    }
                }

                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }

            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Purchase Order has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_production_order_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $result_production = DB::table('production_orders')->where('id', '=', $id);
                if (!$result_production->delete()) {
                    throw new Exception("Error while Deleting Records from Production Order.");
                }
                $items = DB::table('production_items')->where('production_id', '=', $id);
                if (!$items->delete()) {
                    throw new Exception("Error while Deleting Records from Production Items.");
                }
                $stocks = DB::table('stocks')->where('production_id', '=', $id);
                if (!$stocks->delete()) {
                    throw new Exception("Error while Deleting Records from Stocks.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Production Order has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function delete_sales_order_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $data = Weight::with('items', 'production_stocks', 'sale_supplier_transaction', 'sale_customer_transaction')->find($id);
                if (!empty($data->items)) {
                    foreach ($data->items as $item) {
                        if (!$item->delete()) {
                            throw new Exception("Error while deleting records from Items.");
                        }
                    }
                }

                if (!empty($data->production_stocks)) {
                    foreach ($data->production_stocks as $stock) {
                        if (!$stock->delete()) {
                            throw new Exception("Error while deleting records from Production Stocks.");
                        }
                    }
                }

                if (!empty($data->sale_customer_transaction)) {
                    if (!empty($data->sale_customer_transaction->transactions)) {
                        foreach ($data->sale_customer_transaction->transactions as $transaction) {
                            if (!$transaction->delete()) {
                                throw new Exception("Error while deleting records from Transaction.");
                            }
                        }
                    }
                    if (!$data->sale_customer_transaction->delete()) {
                        throw new Exception("Error while deleting records from Customer Transaction.");
                    }
                }

                if (!empty($data->sale_supplier_transaction)) {
                    if (!empty($data->sale_supplier_transaction->transactions)) {
                        foreach ($data->sale_supplier_transaction->transactions as $transaction) {
                            if (!$transaction->delete()) {
                                throw new Exception("Error while deleting records from Transaction.");
                            }
                        }
                    }
                    if (!$data->sale_supplier_transaction->delete()) {
                        throw new Exception("Error while deleting records from Supplier Transaction.");
                    }
                }

                if (!$data->delete()) {
                    throw new Exception("Error while deleting records.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Sales Order has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function make_user_active_by_id($id) {
        $resp = array();
        DB::beginTransaction();
        try {
            $result = DB::table('users')->where('id', '=', $id);
            if (!$result->update(['status' => 1])) {
                throw new Exception("Error while Updating Records from Users.");
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'User has been Activated Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    public function make_user_inactive_by_id($id) {
        $resp = array();
        DB::beginTransaction();
        try {

            $result = DB::table('users')->where('id', '=', $id);
            if (!$result->update(['status' => 0])) {
                throw new Exception("Error while Updating Records from Users.");
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'User has been Inactivated Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
