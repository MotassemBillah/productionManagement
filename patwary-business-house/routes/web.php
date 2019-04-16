<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('site.index');
});

Auth::routes();

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    //Cache::flush();
    return redirect()->back()->with('success', 'Page Refresh Successfull');
});

Route::get('/home', 'HomeController@index')->name('home');


// General Settings Route
Route::get('/general-setting', 'GeneralSettingController@index');
Route::post('/update-setting', 'GeneralSettingController@update_setting');


// Resource Route for HeadController
Route::resource('head', 'HeadController');
Route::post('head/search', 'HeadController@search');
Route::post('head/delete', 'HeadController@delete');

// Resource Route for SubHeadController
Route::resource('subhead', 'SubHeadController');
Route::post('subhead/search', 'SubHeadController@search');
Route::post('subhead/delete', 'SubHeadController@delete');
Route::post('subhead/subhead', 'SubHeadController@get_sub_head');
Route::post('subhead/particular', 'SubHeadController@get_particular');


// Resource Route for Particular
Route::resource('particulars', 'ParticularController');
Route::post('particulars/search', 'ParticularController@search');
Route::post('particulars/delete', 'ParticularController@delete');
Route::post('particulars/particular', 'ParticularController@get_particular');

// Resource Route for Transactions
Route::resource('transactions', 'TransactionController');
Route::get('transactions/create/{tp}', 'TransactionController@create');
Route::post('transactions/search', 'TransactionController@search');
Route::post('transactions/delete', 'TransactionController@delete');
Route::post('transactions/subhead', 'TransactionController@get_sub_head');
Route::get('transaction/expense', 'TransactionController@expenses');
Route::post('transactions/expense-search', 'TransactionController@expense_search');

// Resource Route for Ledger Controller
Route::get('ledger/dailysheet', 'LedgerController@daily_sheet');
Route::post('ledger/dailysheet/search', 'LedgerController@daily_sheet_search');
Route::get('business-ledger/{id}', 'BusinessLedgerController@view');
Route::resource('ledger', 'LedgerController');
Route::get('ledger-view', 'LedgerController@view_ledger');
Route::post('ledger/search', 'LedgerController@ledger_search');
Route::get('ledger/head/{id}', 'LedgerController@head_transaction');
Route::post('ledger/head/search', 'LedgerController@head_transaction_search');
Route::get('ledger/subhead/{id}', 'LedgerController@subhead_transaction');
Route::post('ledger/subhead/search', 'LedgerController@subhead_transaction_search');
Route::get('ledger/particular/{id}', 'LedgerController@particular_transaction');
Route::post('ledger/particular/search', 'LedgerController@particular_transaction_search');


// Daily Report Controller
Route::get('dailyreport', 'DailyReportController@index');
Route::post('dailyreport/search', 'DailyReportController@search');

// Financial Controller
Route::get('financial-statement', 'FinancialController@index');
Route::post('financial-statement/search', 'FinancialController@search');



// Institute Route
Route::resource('institute', 'InstituteController');
Route::post('institute/search', 'InstituteController@search');
Route::post('institute/delete', 'InstituteController@delete');
Route::get('institute/{id}/access', 'InstituteController@institute_access_by_id');
Route::post('institute/acess/update', 'InstituteController@update_institute_access_by_id');
Route::post('institute/type', 'InstituteController@get_institute_by_type');
Route::post('institute/head', 'InstituteController@get_head');
Route::post('institute/subhead', 'InstituteController@get_subhead');
Route::post('institute/ledger', 'InstituteController@get_ledger');


// User Route
Route::resource('user', 'UserController');
Route::get('password', 'UserController@change_user_password');
Route::post('password/update', 'UserController@update_user_password');
Route::get('user/{id}/access', 'UserController@user_access_by_id');
Route::post('user/acess/update', 'UserController@update_user_access_by_id');

/* Route for Receiving Ajax Request */
//Users Ajax Request
Route::post('/delete-users', 'AjaxController@delete_users_by_id');
Route::get('user-active/{id}', 'AjaxController@make_user_active_by_id');
Route::get('user-inactive/{id}', 'AjaxController@make_user_inactive_by_id');
//Institute Ajax Request
Route::get('institute-active/{id}', 'AjaxController@make_institute_active_by_id');
Route::get('institute-inactive/{id}', 'AjaxController@make_institute_inactive_by_id');
Route::post('/delete-institute', 'AjaxController@delete_institute_by_id');