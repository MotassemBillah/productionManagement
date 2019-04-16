<?php

/* Oven Related Route */
Route::get('oven', 'Oven\DashboardController@index');

/* Raw Category Related Route */
Route::resource('oven/rawcategory', 'Oven\RawCategoryController');
Route::post('oven/rawcategory/search', 'Oven\RawCategoryController@search');
Route::post('oven/rawcategory/delete', 'Oven\RawCategoryController@delete');
Route::post('oven/rawcategory/rawproduct', 'Oven\RawCategoryController@get_raw_product');

/* Raw Product Related Route */
Route::resource('oven/rawproduct', 'Oven\RawProductController');
Route::post('oven/rawproduct/search', 'Oven\RawProductController@search');
Route::post('oven/rawproduct/delete', 'Oven\RawProductController@delete');

/* Finish Category Related Route */
Route::resource('oven/finishcategory', 'Oven\FinishCategoryController');
Route::post('oven/finishcategory/search', 'Oven\FinishCategoryController@search');
Route::post('oven/finishcategory/delete', 'Oven\FinishCategoryController@delete');
Route::post('oven/finishcategory/finishproduct', 'Oven\FinishCategoryController@get_finish_product');

/* Finish Product Related Route */
Route::resource('oven/finishproduct', 'Oven\FinishProductController');
Route::post('oven/finishproduct/search', 'Oven\FinishProductController@search');
Route::post('oven/finishproduct/delete', 'Oven\FinishProductController@delete');


/* Purchase Challan Related Route */
Route::get('oven/purchase-challan/details', 'Oven\PurchaseChallanController@details');
Route::resource('oven/purchase-challan', 'Oven\PurchaseChallanController');
Route::post('oven/purchase-challan/search', 'Oven\PurchaseChallanController@search');
Route::post('oven/purchase-challan/search-items', 'Oven\PurchaseChallanController@search_items');
Route::post('oven/purchase-challan/delete', 'Oven\PurchaseChallanController@delete');

/* Sales Challan Related Route */
Route::get('oven/sales-challan/details', 'Oven\SalesChallanController@details');
Route::resource('oven/sales-challan', 'Oven\SalesChallanController');
Route::post('oven/sales-challan/search', 'Oven\SalesChallanController@search');
Route::post('oven/sales-challan/search-items', 'Oven\SalesChallanController@search_items');
Route::post('oven/sales-challan/delete', 'Oven\SalesChallanController@delete');


/* Finish Stocks Related Route */
Route::get('oven/finishstocks/details', 'Oven\FinishStockController@details');
Route::get('oven/finishstocks/opening', 'Oven\FinishStockController@opening_stocks');
Route::post('oven/finishstocks/opening', 'Oven\FinishStockController@store_opening_stocks');
Route::post('oven/finishstocks/opening/update', 'Oven\FinishStockController@update_opening_stocks');
Route::resource('oven/finishstocks', 'Oven\FinishStockController');
Route::post('oven/finishstocks/search', 'Oven\FinishStockController@search');
Route::post('oven/finishstocks/details/search', 'Oven\FinishStockController@details_search');


/* Raw Stocks Related Route */
Route::get('oven/rawstocks/details', 'Oven\RawStockController@details');
Route::get('oven/rawstocks/opening', 'Oven\RawStockController@opening_stocks');
Route::post('oven/rawstocks/opening', 'Oven\RawStockController@store_opening_stocks');
Route::post('oven/rawstocks/opening/update', 'Oven\RawStockController@update_opening_stocks');
Route::resource('oven/rawstocks', 'Oven\RawStockController');
Route::post('oven/rawstocks/search', 'Oven\RawStockController@search');
Route::post('oven/rawstocks/details/search', 'Oven\RawStockController@details_search');

/* Raw Stocks Related Route */
Route::get('oven/finishstocks/details', 'Oven\FinishStockController@details');
Route::get('oven/finishstocks/opening', 'Oven\FinishStockController@opening_stocks');
Route::post('oven/finishstocks/opening', 'Oven\FinishStockController@store_opening_stocks');
Route::post('oven/finishstocks/opening/update', 'Oven\FinishStockController@update_opening_stocks');
Route::resource('oven/finishstocks', 'Oven\FinishStockController');
Route::post('oven/finishstocks/search', 'Oven\FinishStockController@search');
Route::post('oven/finishstocks/details/search', 'Oven\FinishStockController@details_search');


/* Purchase Related Route */
Route::resource('oven/purchases', 'Oven\PurchaseController');
Route::get('oven/purchase/ledger', 'Oven\PurchaseController@ledger');
Route::post('oven/purchase/ledger/search', 'Oven\PurchaseController@ledger_search');
Route::post('oven/purchases/search', 'Oven\PurchaseController@search');
Route::post('oven/purchases/delete', 'Oven\PurchaseController@delete');
Route::get('oven/purchase/stocks', 'Oven\PurchaseController@stocks');
Route::post('oven/purchase/stocks/search', 'Oven\PurchaseController@stocks_search');
Route::get('oven/purchases/{id}/confirm', 'Oven\PurchaseController@confirm');
Route::get('oven/purchases/{id}/reset', 'Oven\PurchaseController@reset');
Route::get('oven/purchase/payment_form/{id}', 'Oven\PurchaseController@payment_form');
Route::post('oven/purchase/payment/update', 'Oven\PurchaseController@payment_update');


/* Production Related Route */
Route::get('oven/production-list', 'Oven\ProductionController@productionList');
Route::get('oven/production/stocks', 'Oven\ProductionController@stocks');
Route::resource('oven/production', 'Oven\ProductionController');
Route::post('oven/production/list/search', 'Oven\ProductionController@productionListSearch');
Route::post('oven/production/search', 'Oven\ProductionController@search');
Route::post('oven/production/delete', 'Oven\ProductionController@delete');
Route::post('oven/production/stocks/search', 'Oven\ProductionController@stocks_search');
Route::get('oven/production/{id}/confirm', 'Oven\ProductionController@confirm');
Route::get('oven/production/{id}/reset', 'Oven\ProductionController@reset');

/* Production Related Route */
Route::get('oven/finishgoods-list', 'Oven\FinishGoodsController@finishgoodsList');
Route::get('oven/finishgoods/stocks', 'Oven\FinishGoodsController@stocks');
Route::resource('oven/finishgoods', 'Oven\FinishGoodsController');
Route::post('oven/finishgoods/list/search', 'Oven\FinishGoodsController@finishgoodsListSearch');
Route::post('oven/finishgoods/search', 'Oven\FinishGoodsController@search');
Route::post('oven/finishgoods/delete', 'Oven\FinishGoodsController@delete');
Route::post('oven/finishgoods/stocks/search', 'Oven\FinishGoodsController@stocks_search');
Route::get('oven/finishgoods/{id}/confirm', 'Oven\FinishGoodsController@confirm');
Route::get('oven/finishgoods/{id}/reset', 'Oven\FinishGoodsController@reset');

/* Sales Related Route */
Route::get('oven/sales/ledger', 'Oven\SalesController@ledger');
Route::resource('oven/sales', 'Oven\SalesController');
Route::post('oven/sales/ledger/search', 'Oven\SalesController@ledger_search');
Route::post('oven/sales/search', 'Oven\SalesController@search');
Route::post('oven/sales/delete', 'Oven\SalesController@delete');
Route::get('oven/sales/stocks', 'Oven\SalesController@stocks');
Route::post('oven/sales/stocks/search', 'Oven\SalesController@stocks_search');
Route::get('oven/sales/{id}/confirm', 'Oven\SalesController@confirm');
Route::get('oven/sales/{id}/reset', 'Oven\SalesController@reset');
Route::get('oven/sales/payment_form/{id}', 'Oven\SalesController@payment_form');
Route::post('oven/sales/payment/update', 'Oven\SalesController@payment_update');

// Resource Route for Empty Bag Size Controller
Route::resource('oven/bagsize', 'Oven\BagSizeController');
Route::post('oven/bagsize/search', 'Oven\BagSizeController@search');
Route::post('oven/bagsize/delete', 'Oven\BagSizeController@delete');

// Resource Route for Empty Bag Color Controller
Route::resource('oven/bagcolor', 'Oven\BagColorController');
Route::post('oven/bagcolor/search', 'Oven\BagColorController@search');
Route::post('oven/bagcolor/delete', 'Oven\BagColorController@delete');

// Resource Route for Empty Bag Color Controller
Route::resource('oven/bagtype', 'Oven\BagTypeController');
Route::post('oven/bagtype/search', 'Oven\BagTypeController@search');
Route::post('oven/bagtype/delete', 'Oven\BagTypeController@delete');






