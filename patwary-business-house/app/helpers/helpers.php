<?php

function pr($object, $exit = true) {
    echo '<pre>';
    print_r($object);
    echo '</pre>';

    if ($exit == true) {
        exit;
    }
}

function adminMsg() {
    return redirect()->back()->with('danger', 'Please contact with Head office to perform this action')->send();
}

function date_ymd($date) {
    return !empty($date) ? date("Y-m-d", strtotime($date)) : '';
}

function date_dmy($date, $sy = false) {
    $_format = "d-m-Y";
    if ($sy == true) {
        $_format = "d-m-y";
    }
    return !empty($date) ? date($_format, strtotime($date)) : '';
}

function uniqueKey() {
    return strtoupper(uniqid() . date('s'));
}

function has_flash_message() {
    return Session::has('success') OR Session::has('info') OR Session::has('warning') OR Session::has('danger');
}

function view_flash_message() {
    $retVal = "";
    if (Session::get('success')) {
        $retVal = "<div class='alert alert-success no_mrgn'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" . Session::get('success') . "</div>";
    } elseif (Session::get('info')) {
        $retVal = "<div class='alert alert-info no_mrgn'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" . Session::get('info') . "</div>";
    } elseif (Session::get('warning')) {
        $retVal = "<div class='alert alert-warning no_mrgn'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" . Session::get('warning') . "</div>";
    } elseif (Session::get('danger')) {
        $retVal = "<div class='alert alert-danger no_mrgn'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" . Session::get('danger') . "</div>";
    } else {
        $retVal = "";
    }

    return $retVal;
}

function user_access_item_by_institute($id) {
    $permissions = DB::table('institute_permissions')->where('institute_id', '=', $id)->first()->permissions;
    $access_items = json_decode($permissions, true);
    return $access_items;
}

function permission_common() {
    $access_items = array(
        'setting' => 'Setting',
        'generel_setting' => 'General Setting',
        'generel_setting_update' => 'General Setting Update',
        'manage_user' => 'Manage User',
        'user_access' => 'User Access',
        'reset_order' => 'Reset Order',
    );
    return $access_items;
}

function permission_accounts() {
    $access_items = array(
        'manage_head' => 'Manage Head',
        'manage_subhead' => 'Manage Subhead',
        'manage_particular' => 'Manage Particular',
        'manage_transaction' => 'Manage Transaction',
    );
    return $access_items;
}

function permission_admin() {
    $access_items = array(
        'setting' => 'Setting',
        'generel_setting' => 'General Setting',
        'generel_setting_update' => 'General Setting Update',
        'manage_user' => 'Manage User',
        'user_access' => 'User Access',
        'user_status' => 'User Status',
        'manage_institute' => 'Manage Institute',
        'institute_access' => 'Institute Access',
        'institute_status' => 'Institute Status',
        'reset_order' => 'Reset Order',
    );
    return $access_items;
}

function permission_rice() {
    $access_items = array(
        'rice_drawer_setting' => 'Rice Drawer Setting',
        'rice_drawer_delete' => 'Rice Drawer Delete',
        'rice_godown_setting' => 'Rice Godown Setting',
        'rice_godown_delete' => 'Rice Godown Delete',
        'rice_emptybag_setting' => 'Rice Empty Bag Setting',
        'rice_emptybag_setting_delete' => 'Rice Empty Bag Setting Delete',
        'rice_manage_product' => 'Rice Manage Product',
        'rice_category' => 'Rice Category',
        'rice_product' => 'Rice Product',
        'rice_after_production' => 'Rice After Production',
        'rice_manage_production' => 'Rice Manage Production',
        'rice_manage_production_stocks' => 'Rice Manage Production Stocks',
        'rice_manage_stocks' => 'Rice Manage Stocks',
        'rice_production_confirm' => 'Rice Production Confirm',
        'rice_production_delete' => 'Rice Production Delete',
        'rice_manage_purchase' => 'Rice Manage Purchase',
        'rice_purchase_challan' => 'Rice Purchase Challan',
        'rice_purchase_challan_delete' => 'Rice Purchase Challan Delete',
        'rice_manage_sales' => 'Rice Manage Sales',
        'rice_sale_challan' => 'Rice Sale Challan',
        'rice_sale_challan_delete' => 'Rice Sale Challan Delete',
        'rice_production_stocks' => 'Rice Production Stocks',
        'rice_empty_bags' => 'Rice Empty Bags',
    );
    return $access_items;
}

function permission_flour() {
    $access_items = array(
        'flour_drawer_setting' => 'Flour Drawer Setting',
        'flour_drawer_delete' => 'Flour Drawer Delete',
        'flour_godown_setting' => 'Flour Godown Setting',
        'flour_godown_delete' => 'Flour Godown Delete',
        'flour_emptybag_setting' => 'Flour Empty Bag Setting',
        'flour_emptybag_setting_delete' => 'Flour Empty Bag Setting Delete',
        'flour_manage_product' => 'Flour Manage Product',
        'flour_category' => 'Flour Category',
        'flour_product' => 'Flour Product',
        'flour_after_production' => 'Flour After Production',
        'flour_manage_production' => 'Flour Manage Production',
        'flour_manage_production_stocks' => 'Flour Manage Production Stocks',
        'flour_manage_stocks' => 'Flour Manage Stocks',
        'flour_production_confirm' => 'Flour Production Confirm',
        'flour_production_delete' => 'Flour Production Delete',
        'flour_manage_purchase' => 'Flour Manage Purchase',
        'flour_purchase_challan' => 'Flour Purchase Challan',
        'flour_purchase_challan_delete' => 'Flour Purchase Challan Delete',
        'flour_manage_sales' => 'Flour Manage Sales',
        'flour_sale_challan' => 'Flour Sale Challan',
        'flour_sale_challan_delete' => 'Flour Sale Challan Delete',
        'flour_production_stocks' => 'Flour Production Stocks',
        'flour_empty_bags' => 'Flour Empty Bags',
    );
    return $access_items;
}

function permission_oven() {
    $access_items = array(
        'oven_manage_production' => 'Oven Manage Production',
        'oven_manage_finishgoods' => 'Oven Manage Finish Goods',
        'oven_manage_stocks' => 'Oven Manage Stocks',
        'oven_production_confirm' => 'Oven Production Confirm',
        'oven_finishgoods_confirm' => 'Oven Finish Goods Confirm',
        'oven_finishgoods_delete' => 'Oven Finish Goods Delete',
        'oven_production_delete' => 'Oven Production Delete',
        'oven_manage_purchase' => 'Oven Manage Purchase',
        'oven_purchase_challan' => 'Oven Purchase Challan',
        'oven_purchase_challan_delete' => 'Oven Purchase Challan Delete',
        'oven_manage_sales' => 'Oven Manage Sales',
        'oven_sale_challan' => 'Oven Sale Challan',
        'oven_sale_challan_delete' => 'Oven Sale Challan Delete',
        'oven_production_stocks' => 'Oven Production Stocks',
        'oven_empty_bags' => 'Oven Empty Bags',
    );
    return $access_items;
}

function permission_packaging() {
    $access_items = array(
        'packaging_manage_production' => 'Packaging Manage Production',
        'packaging_manage_finishgoods' => 'Packaging Manage Finish Goods',
        'packaging_manage_stocks' => 'Packaging Manage Stocks',
        'packaging_production_confirm' => 'Packaging Production Confirm',
        'packaging_finishgoods_confirm' => 'Packaging Finish Goods Confirm',
        'packaging_finishgoods_delete' => 'Packaging Finish Goods Delete',
        'packaging_production_delete' => 'Packaging Production Delete',
        'packaging_manage_purchase' => 'Packaging Manage Purchase',
        'packaging_purchase_challan' => 'Packaging Purchase Challan',
        'packaging_purchase_challan_delete' => 'Packaging Purchase Challan Delete',
        'packaging_manage_sales' => 'Packaging Manage Sales',
        'packaging_sale_challan' => 'Packaging Sale Challan',
        'packaging_sale_challan_delete' => 'Packaging Sale Challan Delete',
        'packaging_production_stocks' => 'Packaging Production Stocks',
        'packaging_empty_bags' => 'Packaging Empty Bags',
    );
    return $access_items;
}

function permission_dal() {
    $access_items = array(
        'dal_manage_production' => 'Dal Manage Production',
        'dal_manage_finishgoods' => 'Dal Manage Finish Goods',
        'dal_manage_stocks' => 'Dal Manage Stocks',
        'dal_production_confirm' => 'Dal Production Confirm',
        'dal_finishgoods_confirm' => 'Dal Finish Goods Confirm',
        'dal_finishgoods_delete' => 'Dal Finish Goods Delete',
        'dal_production_delete' => 'Dal Production Delete',
        'dal_manage_purchase' => 'Dal Manage Purchase',
        'dal_purchase_challan' => 'Dal Purchase Challan',
        'dal_purchase_challan_delete' => 'Dal Purchase Challan Delete',
        'dal_manage_sales' => 'Dal Manage Sales',
        'dal_sale_challan' => 'Dal Sale Challan',
        'dal_sale_challan_delete' => 'Dal Sale Challan Delete',
        'dal_production_stocks' => 'Dal Production Stocks',
        'dal_empty_bags' => 'Dal Empty Bags',
    );
    return $access_items;
}

function permission_rental() {
    $access_items = array(
        'rental_building' => 'Rental Building',
        'rental_building_delete' => 'Rental Building Delete',
        'rental_floor' => 'Rental Floor',
        'rental_floor_delete' => 'Rental Floor Delete',
        'rental_flat' => 'Rental Flat',
        'rental_flat_delete' => 'Rental Flat Delete',
        'rental_party' => 'Rental Party',
        'rental_party_delete' => 'Rental Party Delete',
    );
    return $access_items;
}

function permission_murimill() {
    $access_items = array(
        'muri_category' => 'Muri Category',
        'muri_product' => 'Muri Product',
        'muri_production' => 'Muri Production',
        'muri_stocks' => 'Muri Stocks',
    );
    return $access_items;
}

function permission_chiramill() {
    $access_items = array(
        'chira_category' => 'Chira_Category',
        'chira_product' => 'Chira_Product',
        'chira_production' => 'Chira_Production',
        'chira_stocks' => 'Chira_Stocks',
    );
    return $access_items;
}

function permission_inv() {
    $access_items = array(
        'inv_category' => 'Inv Category',
        'inv_category_create' => 'Inv Category Create',
        'inv_category_edit' => 'Inv Category Edit',
        'inv_category_delete' => 'Inv Category Delete',
        'inv_product' => 'Inv Product',
        'inv_product_create' => 'Inv Product Create',
        'inv_product_edit' => 'Inv Product Edit',
        'inv_product_delete' => 'Inv Product Delete',
        'inv_production' => 'Inv Production',
        'inv_stocks' => 'Inv Stocks',
        'inv_purchase' => 'Inv Purchase',
        'inv_purchase_create' => 'Inv Purchase Create',
        'inv_purchase_edit' => 'Inv Purchase Edit',
        'inv_purchase_delete' => 'Inv Purchase Delete',
        'inv_sales' => 'Inv Sales',
        'inv_sales_create' => 'Inv Sales Create',
        'inv_sales_edit' => 'Inv Sales Edit',
        'inv_sales_delete' => 'Inv Sales Delete',
        'inv_detail' => 'Inv Detail',
        'inv_payment' => 'Inv Payment',
    );
    return $access_items;
}

function permission_bag() {
    $access_items = array(
        'bag_category' => 'Bag Category',
        'bag_product' => 'Bag Product',
        'bag_production' => 'Bag Production',
        'bag_stocks' => 'Bag Stocks',
        'bag_bag' => 'Bag Bag Type',
        'bag_bag_size' => 'Bag Bag Size',
    );
    return $access_items;
}

function default_user_access_items() {
    $access_items = array(
        'setting' => 'Setting',
        'generel_setting' => 'General Setting',
        'generel_setting_update' => 'General Setting Update',
    );
    return $access_items;
}

function institute_access_items() {
    $access_items = array(
        'permission_admin' => 'Admin Setting',
        'permission_accounts' => 'Accounts Setting',
        'permission_rice' => 'Rice Mill',
        'permission_flour' => 'Flour Mill',
        'permission_oven' => 'Oven Factory',
        'permission_packaging' => 'Packaging Factory',
        'permission_dal' => 'Dal Mill',
        'permission_rental' => 'Rental Management',
        'permission_chiramill' => 'Chira Mill',
        'permission_murimill' => 'Muri Mill',
        'permission_inv' => 'Inventory',
        'permission_bag' => 'Bag Production',
    );
    return $access_items;
}

function default_institute_access_items() {
    $access_items = array(
        'setting' => 'Setting',
        'generel_setting' => 'General Setting',
        'generel_setting_update' => 'General Setting Update',
        'manage_user' => 'Manage User',
    );
    return $access_items;
}

function allAccessItems($jsn = FALSE) {
    $items = [];
    $items[] = permission_accounts();
    $items[] = permission_admin();
    $items[] = permission_rice();
    $items[] = permission_flour();
    $items[] = permission_oven();
    $items[] = permission_packaging();
    $items[] = permission_dal();
    $items[] = permission_murimill();
    $items[] = permission_chiramill();
    $items[] = permission_inv();
    $items[] = permission_bag();
    $result = call_user_func_array("array_merge", $items);

    if ($jsn == TRUE) {
        $data = json_encode($result);
    } else {
        $data = $result;
    }

    return $data;
}

function has_user_access($access) {
    $id = Auth::id();
    $permissions = DB::table('user_permissions')->where('user_id', '=', $id)->first()->permissions;
    $access_items = json_decode($permissions, true);
    if (!empty($access_items)) {
        if (array_key_exists($access, $access_items)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function check_user_access($access) {
    if (has_user_access($access)) {
        return true;
    } else {
        return redirect()->back()->with('danger', 'You are not authorized to perform this action')->send();
    }
}

function is_Admin() {
    if (Auth::user()->type == 'admin') {
        return true;
    } else {
        return false;
    }
}

function is_Ajax($request) {
    if ($request->ajax()) {
        return true;
    } else {
        return redirect()->back()->with('danger', 'Invalid URL')->send();
    }
}

function show_hide() {
    return is_Admin() ? "" : "hide_column";
}

function colspan($a, $b) {
    return is_Admin() ? $a : $b;
}

function institute_id() {
    return Auth::user()->institute_id;
}

function print_header($title, $_mpmt = true, $_visible = false) {
    $_sip = ($_visible == true) ? '' : 'show_in_print';
    $_mt = ($_mpmt == false) ? '' : 'mpmt';

    $setting = \App\Models\GeneralSetting::get_setting();
    $str = "<div class='invoice_heading {$_mt} {$_sip}'>";
    $str .= "<div class='text-center'>";
    $str .= "<h3 style='font-size:20px;margin:3px 0px;'>{$setting->title}</h3>";
    $str .= "<span>{$setting->address}</span><br/>";
    $str .= "<span>Contact : " . change_lang($setting->mobile) . "</span><br/>";
    $str .= "<strong style='text-decoration:underline;'>{$title}</strong>";
    $str .= "</div>";
    $str .= "</div>";
    echo $str;
}

function number_dropdown($start, $end, $jump, $page_size = null, $xs_cls = null) {
    $setting = \App\Models\GeneralSetting::get_setting();
    $_page = $setting->pagesize;
    if (!is_null($page_size)) {
        $_page = $page_size;
    }
    $cls_xs = "";
    if (!is_null($xs_cls)) {
        $cls_xs = $xs_cls;
    }
    $_str = "<select class='form-control {$xs_cls}' id='itemCount' name='item_count' style='width:58px'>";

    for ($i = $start; $i <= $end; $i += $jump):
        if ($i == $_page) {
            $_str .= "<option value='{$i}' selected='selected'>{$i}</option>";
        } else {
            $_str .= "<option value='{$i}'>{$i}</option>";
        }
    endfor;

    $_str .= "</select>";
    return $_str;
}

function int_to_words($x) {
    $nwords = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen", "twenty", 30 => "thirty", 40 => "forty", 50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty", 90 => "ninety");
    if (!is_numeric($x)) {
        $w = '#';
    } else if (fmod($x, 1) != 0) {
        $w = '#';
    } else {
        if ($x < 0) {
            $w = 'minus ';
            $x = -$x;
        } else {
            $w = '';
        }
        if ($x < 21) {
            $w .= $nwords[floor($x)];
        } else if ($x < 100) {
            $w .= $nwords[10 * floor($x / 10)];
            $r = fmod($x, 10);
            if ($r > 0) {
                $w .= '-' . $nwords[$r];
            }
        } else if ($x < 1000) {
            $w .= $nwords[floor($x / 100)] . ' hundred';
            $r = fmod($x, 100);
            if ($r > 0) {
                $w .= ' and ' . int_to_words($r);
            }
        } else if ($x < 100000) {
            $w .= int_to_words(floor($x / 1000)) . ' thousand';
            $r = fmod($x, 1000);
            if ($r > 0) {
                $w .= ' ';
                if ($r < 100) {
                    $w .= 'and ';
                }
                $w .= int_to_words($r);
            }
        } else {
            $w .= int_to_words(floor($x / 100000)) . ' lakh';
            $r = fmod($x, 100000);
            if ($r > 0) {
                $w .= ' ';
                if ($r < 100) {
                    $word .= 'and ';
                }
                $w .= int_to_words($r);
            }
        }
    }
    return $w;
}

function cur_date_time() {
    date_default_timezone_set("Asia/Dhaka");
    return date('Y-m-d h:i:s');
}

function cur_date() {
    date_default_timezone_set("Asia/Dhaka");
    return date('Y-m-d');
}

function print_date() {
    date_default_timezone_set("Asia/Dhaka");
    return date("d/m/Y g:i A", strtotime(date("Y-m-d H:i:s")));
}

function unit_list() {
    return [
        "Kg" => "Kg",
        "Liter" => "Liter",
        "Bag" => "Bag",
        "Cartoon" => "Cartoon",
        "Piece" => "Piece",
        "Packet" => "Packet",
        "Meter" => "Meter",
        "Foot" => "Foot",
        "Inch" => "Inch",
        "Drum" => "Drum",
        "Khaca" => "Khaca",
        "Tin" => "Tin",
    ];
}

function type_list() {
    return [
        "Raw" => "Raw",
        "Finish" => "Finish",
        "Others" => "Others",
    ];
}

function building_type_list() {
    return [
        "Dokan" => "Dokan",
        "House" => "House",
        "Godown" => "Godown",
        "Hostel" => "Hostel",
        "Others" => "Others",
    ];
}

function production_types() {
    return [
        "মোটা " => "মোটা",
        "পাতলা" => "পাতলা",
        "রঙ্গিন" => "রঙ্গিন",
        "পানিয়া" => "পানিয়া",
        "প্রিন্ট" => "প্রিন্ট",
    ];
}

function bank_account_type_list() {
    return [
        "CC loan A/C" => "CC loan A/C",
        "Savings A/C" => "Savings A/C",
        "Current A/C" => "Current A/C",
        "LC A/C" => "LC A/C",
        "LTR A/C" => "LTR A/C",
        "Loan A/C (Monthly Installment)" => "Loan A/C (Monthly Installment)",
    ];
}

function printed_list() {
    return [
        "Graviour" => "Graviour",
        "Blocked" => "Blocked",
        "No" => "No",
    ];
}

function yes_no_list() {
    return [
        "Yes" => "Yes",
        "No" => "No",
    ];
}

function full_url() {
    return Request::url();
}

function body_class() {
    $_fullUri = full_url();
    $_uriArr = explode('/', $_fullUri);

    $_clsName = "column1";
    $_route_prefix = ['bag', 'chira', 'dal', 'flour', 'oven', 'rental', 'inv', 'muri', 'oil', 'rice'];
    foreach ($_route_prefix as $_rpkey => $_rpval) {
        if (array_search($_rpval, $_uriArr)) {
            $_clsName = "column2";
        }
    }

    return $_clsName;
}

function en2bnNumber($number) {
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $bn_number = str_replace($en, $bn, $number);
    return $bn_number;
}

function en2bnDate($date) {
    $bn = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', 'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', '
বুধবার', 'বৃহস্পতিবার', 'শুক্রবার'
    );
    $en = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
    $bn_date = str_replace($en, $bn, $date);
    return $bn_date;
}

function change_lang($str) {
    $_lang = App::getLocale();
    $en = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $bn = array('o', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    if ($_lang == 'bn') {
        $tstr = str_replace($en, $bn, $str);
    } else {
        $tstr = str_replace($bn, $en, $str);
    }
    return $tstr;
}

function to_eng($str) {
    $bn = array('o', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $en = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $tstr = str_replace($bn, $en, $str);
    return $tstr;
}

function printf_number($value) {
    return sprintf("%'.08d\n", $value);
}
