<?php

/* Ricemill Related Route */


/* Category Related Route */
//Route::resource('rice/category', 'Rice\CategoryController');
Route::get('rice', 'Rice\DashboardController@index');
Route::resource('rice/category', 'Rice\CategoryController');
Route::post('rice/category/search', 'Rice\CategoryController@search');
Route::post('rice/category/delete', 'Rice\CategoryController@delete');

/* Drawer Related Route */
Route::resource('rice/drawers', 'Rice\DrawerController');
Route::post('rice/drawers/search', 'Rice\DrawerController@search');
Route::post('rice/drawers/delete', 'Rice\DrawerController@delete');

/* Godown Related Route */
Route::resource('rice/godowns', 'Rice\GodownController');
Route::post('rice/godowns/search', 'Rice\GodownController@search');
Route::post('rice/godowns/delete', 'Rice\GodownController@delete');

/* Empty Bag Setting Related Route */
Route::resource('rice/emptybag-setting', 'Rice\EmptybagSettingController');
Route::post('rice/emptybag-setting/search', 'Rice\EmptybagSettingController@search');
Route::post('rice/emptybag-setting/delete', 'Rice\EmptybagSettingController@delete');

/* Products Related Route */
Route::resource('rice/product', 'Rice\ProductController');
Route::post('rice/product/search', 'Rice\ProductController@search');
Route::post('rice/product/delete', 'Rice\ProductController@delete');

/* After Production Related Route */
Route::resource('rice/after-production', 'Rice\AfterProductionController');
Route::post('rice/after-production/search', 'Rice\AfterProductionController@search');
Route::post('rice/after-production/delete', 'Rice\AfterProductionController@delete');

/* Production Order Related Route */
Route::resource('rice/production', 'Rice\ProductionController');
Route::post('rice/production/search', 'Rice\ProductionController@search');
Route::post('rice/production/delete', 'Rice\ProductionController@delete');
Route::get('rice/production-list', 'Rice\ProductionController@order_list');
Route::post('rice/production-list/search', 'Rice\ProductionController@order_list_search');
Route::get('rice/production/{id}/confirm', 'Rice\ProductionController@confirm');
Route::get('rice/production/{id}/item', 'Rice\ProductionController@order_items');
Route::get('rice/production/{id}/complete', 'Rice\ProductionController@order_complete');

// Resource Route for Empty Bag
Route::resource('rice/emptybags', 'Rice\EmptyBagController');
Route::get('rice/emptybags/create/{tp}', 'Rice\EmptyBagController@create');
Route::post('rice/emptybags/search', 'Rice\EmptyBagController@search');
Route::post('rice/emptybags/delete', 'Rice\EmptyBagController@delete');
Route::post('rice/emptybags/subhead', 'Rice\EmptyBagController@get_sub_head');

/* Purchase Challan Related Route */
Route::resource('rice/purchase-challan', 'Rice\PurchaseChallanController');
Route::post('rice/purchase-challan/search', 'Rice\PurchaseChallanController@search');
Route::post('rice/purchase-challan/delete', 'Rice\PurchaseChallanController@delete');

/* Stocks Related Route */
Route::resource('rice/stocks', 'Rice\StockController');
Route::post('rice/stocks/search', 'Rice\StockController@search');

// Stock Register Controller
Route::get('stock-register', 'StockRegisterController@index');
Route::post('stock-register/search', 'StockRegisterController@search');

/* Production Stock Related Route */ 
Route::get('rice/production-stocks/details', 'Rice\ProductionStockController@details');
Route::get('rice/production-stocks/report', 'Rice\ProductionStockController@stocks');
Route::resource('rice/production-stocks', 'Rice\ProductionStockController');
Route::post('rice/production-stocks/search', 'Rice\ProductionStockController@search');
Route::post('rice/production-stocks/report/search', 'Rice\ProductionStockController@stocks_search');
Route::post('rice/productionstocks/details/search', 'Rice\ProductionStockController@details_search');

/* Raw Opening Stock Related Route */
Route::resource('rice/raw-opening-stocks', 'Rice\RawOpeningStockController');
Route::post('rice/raw-osupdate', 'Rice\RawOpeningStockController@update');

/* Finish Opening Stock Related Route */
Route::resource('rice/finish-opening-stocks', 'Rice\FinishOpeningStockController');
Route::post('rice/finish-osupdate', 'Rice\FinishOpeningStockController@update');

/* Sales Challan Related Route */
Route::get('rice/sales-challan/details', 'Rice\SalesChallanController@details');
Route::resource('rice/sales-challan', 'Rice\SalesChallanController');
Route::post('rice/sales-challan/search', 'Rice\SalesChallanController@search');
Route::post('rice/sales-challan/search-items', 'Rice\SalesChallanController@search_items');
Route::post('rice/sales-challan/delete', 'Rice\SalesChallanController@delete');
