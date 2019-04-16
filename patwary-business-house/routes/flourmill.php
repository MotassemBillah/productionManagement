<?php

/* Flour Related Route */
Route::get('flour', 'Flour\DashboardController@index');

Route::resource('flour/category', 'Flour\CategoryController');
Route::post('flour/category/search', 'Flour\CategoryController@search');
Route::post('flour/category/delete', 'Flour\CategoryController@delete');

/* Drawer Related Route */
Route::resource('flour/drawers', 'Flour\DrawerController');
Route::post('flour/drawers/search', 'Flour\DrawerController@search');
Route::post('flour/drawers/delete', 'Flour\DrawerController@delete');

/* Godown Related Route */
Route::resource('flour/godowns', 'Flour\GodownController');
Route::post('flour/godowns/search', 'Flour\GodownController@search');
Route::post('flour/godowns/delete', 'Flour\GodownController@delete');

/* Empty Bag Setting Related Route */
Route::resource('flour/emptybag-setting', 'Flour\EmptybagSettingController');
Route::post('flour/emptybag-setting/search', 'Flour\EmptybagSettingController@search');
Route::post('flour/emptybag-setting/delete', 'Flour\EmptybagSettingController@delete');

/* Products Related Route */
Route::resource('flour/product', 'Flour\ProductController');
Route::post('flour/product/search', 'Flour\ProductController@search');
Route::post('flour/product/delete', 'Flour\ProductController@delete');

/* After Production Related Route */
Route::resource('flour/after-production', 'Flour\AfterProductionController');
Route::post('flour/after-production/search', 'Flour\AfterProductionController@search');
Route::post('flour/after-production/delete', 'Flour\AfterProductionController@delete');

/* Production Order Related Route */
Route::resource('flour/production', 'Flour\ProductionController');
Route::post('flour/production/search', 'Flour\ProductionController@search');
Route::post('flour/production/delete', 'Flour\ProductionController@delete');
Route::get('flour/production-list', 'Flour\ProductionController@order_list');
Route::post('flour/production-list/search', 'Flour\ProductionController@order_list_search');
Route::get('flour/production/{id}/confirm', 'Flour\ProductionController@confirm');
Route::get('flour/production/{id}/item', 'Flour\ProductionController@order_items');
Route::get('flour/production/{id}/complete', 'Flour\ProductionController@order_complete');

// Resource Route for Empty Bag
Route::resource('flour/emptybags', 'Flour\EmptyBagController');
Route::get('flour/emptybags/create/{tp}', 'Flour\EmptyBagController@create');
Route::post('flour/emptybags/search', 'Flour\EmptyBagController@search');
Route::post('flour/emptybags/delete', 'Flour\EmptyBagController@delete');
Route::post('flour/emptybags/subhead', 'Flour\EmptyBagController@get_sub_head');

/* Purchase Challan Related Route */
Route::resource('flour/purchase-challan', 'Flour\PurchaseChallanController');
Route::post('flour/purchase-challan/search', 'Flour\PurchaseChallanController@search');
Route::post('flour/purchase-challan/delete', 'Flour\PurchaseChallanController@delete');

/* Stocks Related Route */
Route::resource('flour/stocks', 'Flour\StockController');
Route::post('flour/stocks/search', 'Flour\StockController@search');

// Stock Register Controller
Route::get('stock-register', 'StockRegisterController@index');
Route::post('stock-register/search', 'StockRegisterController@search');

/* Production Stock Related Route */
Route::get('flour/production-stocks/details', 'Flour\ProductionStockController@details');
Route::get('flour/production-stocks/report', 'Flour\ProductionStockController@stocks');
Route::resource('flour/production-stocks', 'Flour\ProductionStockController');
Route::post('flour/production-stocks/search', 'Flour\ProductionStockController@search');
Route::post('flour/production-stocks/report/search', 'Flour\ProductionStockController@stocks_search');
Route::post('flour/productionstocks/details/search', 'Flour\ProductionStockController@details_search');

/* Production Stock Related Route */
Route::resource('flour/raw-opening-stocks', 'Flour\RawOpeningStockController');
Route::post('flour/raw-osupdate', 'Flour\RawOpeningStockController@update');

/* Production Stock Related Route */
Route::resource('flour/finish-opening-stocks', 'Flour\FinishOpeningStockController');
Route::post('flour/finish-osupdate', 'Flour\FinishOpeningStockController@update');

/* Sales Challan Related Route */
Route::get('flour/sales-challan/details', 'Flour\SalesChallanController@details');
Route::resource('flour/sales-challan', 'Flour\SalesChallanController');
Route::post('flour/sales-challan/search', 'Flour\SalesChallanController@search');
Route::post('flour/sales-challan/search-items', 'Flour\SalesChallanController@search_items');
Route::post('flour/sales-challan/delete', 'Flour\SalesChallanController@delete');

