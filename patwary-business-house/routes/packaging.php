<?php

/* Packaging Related Route */
Route::get('packaging', 'Packaging\DashboardController@index');

/* Raw Category Related Route */
Route::resource('packaging/rawcategory', 'Packaging\RawCategoryController');
Route::post('packaging/rawcategory/search', 'Packaging\RawCategoryController@search');
Route::post('packaging/rawcategory/delete', 'Packaging\RawCategoryController@delete');
Route::post('packaging/rawcategory/rawproduct', 'Packaging\RawCategoryController@get_raw_product');

/* Raw Product Related Route */
Route::resource('packaging/rawproduct', 'Packaging\RawProductController');
Route::post('packaging/rawproduct/search', 'Packaging\RawProductController@search');
Route::post('packaging/rawproduct/delete', 'Packaging\RawProductController@delete');

/* Finish Category Related Route */
Route::resource('packaging/finishcategory', 'Packaging\FinishCategoryController');
Route::post('packaging/finishcategory/search', 'Packaging\FinishCategoryController@search');
Route::post('packaging/finishcategory/delete', 'Packaging\FinishCategoryController@delete');
Route::post('packaging/finishcategory/finishproduct', 'Packaging\FinishCategoryController@get_finish_product');

/* Finish Product Related Route */
Route::resource('packaging/finishproduct', 'Packaging\FinishProductController');
Route::post('packaging/finishproduct/search', 'Packaging\FinishProductController@search');
Route::post('packaging/finishproduct/delete', 'Packaging\FinishProductController@delete');


/* Purchase Challan Related Route */
Route::get('packaging/purchase-challan/details', 'Packaging\PurchaseChallanController@details');
Route::resource('packaging/purchase-challan', 'Packaging\PurchaseChallanController');
Route::post('packaging/purchase-challan/search', 'Packaging\PurchaseChallanController@search');
Route::post('packaging/purchase-challan/search-items', 'Packaging\PurchaseChallanController@search_items');
Route::post('packaging/purchase-challan/delete', 'Packaging\PurchaseChallanController@delete');

/* Sales Challan Related Route */
Route::get('packaging/sales-challan/details', 'Packaging\SalesChallanController@details');
Route::resource('packaging/sales-challan', 'Packaging\SalesChallanController');
Route::post('packaging/sales-challan/search', 'Packaging\SalesChallanController@search');
Route::post('packaging/sales-challan/search-items', 'Packaging\SalesChallanController@search_items');
Route::post('packaging/sales-challan/delete', 'Packaging\SalesChallanController@delete');


/* Finish Stocks Related Route */
Route::get('packaging/finishstocks/details', 'Packaging\FinishStockController@details');
Route::get('packaging/finishstocks/opening', 'Packaging\FinishStockController@opening_stocks');
Route::post('packaging/finishstocks/opening', 'Packaging\FinishStockController@store_opening_stocks');
Route::post('packaging/finishstocks/opening/update', 'Packaging\FinishStockController@update_opening_stocks');
Route::resource('packaging/finishstocks', 'Packaging\FinishStockController');
Route::post('packaging/finishstocks/search', 'Packaging\FinishStockController@search');
Route::post('packaging/finishstocks/details/search', 'Packaging\FinishStockController@details_search');


/* Raw Stocks Related Route */
Route::get('packaging/rawstocks/details', 'Packaging\RawStockController@details');
Route::get('packaging/rawstocks/opening', 'Packaging\RawStockController@opening_stocks');
Route::post('packaging/rawstocks/opening', 'Packaging\RawStockController@store_opening_stocks');
Route::post('packaging/rawstocks/opening/update', 'Packaging\RawStockController@update_opening_stocks');
Route::resource('packaging/rawstocks', 'Packaging\RawStockController');
Route::post('packaging/rawstocks/search', 'Packaging\RawStockController@search');
Route::post('packaging/rawstocks/details/search', 'Packaging\RawStockController@details_search');

/* Raw Stocks Related Route */
Route::get('packaging/finishstocks/details', 'Packaging\FinishStockController@details');
Route::get('packaging/finishstocks/opening', 'Packaging\FinishStockController@opening_stocks');
Route::post('packaging/finishstocks/opening', 'Packaging\FinishStockController@store_opening_stocks');
Route::post('packaging/finishstocks/opening/update', 'Packaging\FinishStockController@update_opening_stocks');
Route::resource('packaging/finishstocks', 'Packaging\FinishStockController');
Route::post('packaging/finishstocks/search', 'Packaging\FinishStockController@search');
Route::post('packaging/finishstocks/details/search', 'Packaging\FinishStockController@details_search');


/* Purchase Related Route */
Route::resource('packaging/purchases', 'Packaging\PurchaseController');
Route::get('packaging/purchase/ledger', 'Packaging\PurchaseController@ledger');
Route::post('packaging/purchase/ledger/search', 'Packaging\PurchaseController@ledger_search');
Route::post('packaging/purchases/search', 'Packaging\PurchaseController@search');
Route::post('packaging/purchases/delete', 'Packaging\PurchaseController@delete');
Route::get('packaging/purchase/stocks', 'Packaging\PurchaseController@stocks');
Route::post('packaging/purchase/stocks/search', 'Packaging\PurchaseController@stocks_search');
Route::get('packaging/purchases/{id}/confirm', 'Packaging\PurchaseController@confirm');
Route::get('packaging/purchases/{id}/reset', 'Packaging\PurchaseController@reset');
Route::get('packaging/purchase/payment_form/{id}', 'Packaging\PurchaseController@payment_form');
Route::post('packaging/purchase/payment/update', 'Packaging\PurchaseController@payment_update');


/* Production Related Route */
Route::get('packaging/production-list', 'Packaging\ProductionController@productionList');
Route::get('packaging/production/stocks', 'Packaging\ProductionController@stocks');
Route::resource('packaging/production', 'Packaging\ProductionController');
Route::post('packaging/production/list/search', 'Packaging\ProductionController@productionListSearch');
Route::post('packaging/production/search', 'Packaging\ProductionController@search');
Route::post('packaging/production/delete', 'Packaging\ProductionController@delete');
Route::post('packaging/production/stocks/search', 'Packaging\ProductionController@stocks_search');
Route::get('packaging/production/{id}/confirm', 'Packaging\ProductionController@confirm');
Route::get('packaging/production/{id}/reset', 'Packaging\ProductionController@reset');

/* Production Related Route */
Route::get('packaging/finishgoods-list', 'Packaging\FinishGoodsController@finishgoodsList');
Route::get('packaging/finishgoods/stocks', 'Packaging\FinishGoodsController@stocks');
Route::resource('packaging/finishgoods', 'Packaging\FinishGoodsController');
Route::post('packaging/finishgoods/list/search', 'Packaging\FinishGoodsController@finishgoodsListSearch');
Route::post('packaging/finishgoods/search', 'Packaging\FinishGoodsController@search');
Route::post('packaging/finishgoods/delete', 'Packaging\FinishGoodsController@delete');
Route::post('packaging/finishgoods/stocks/search', 'Packaging\FinishGoodsController@stocks_search');
Route::get('packaging/finishgoods/{id}/confirm', 'Packaging\FinishGoodsController@confirm');
Route::get('packaging/finishgoods/{id}/reset', 'Packaging\FinishGoodsController@reset');

/* Sales Related Route */
Route::get('packaging/sales/ledger', 'Packaging\SalesController@ledger');
Route::resource('packaging/sales', 'Packaging\SalesController');
Route::post('packaging/sales/ledger/search', 'Packaging\SalesController@ledger_search');
Route::post('packaging/sales/search', 'Packaging\SalesController@search');
Route::post('packaging/sales/delete', 'Packaging\SalesController@delete');
Route::get('packaging/sales/stocks', 'Packaging\SalesController@stocks');
Route::post('packaging/sales/stocks/search', 'Packaging\SalesController@stocks_search');
Route::get('packaging/sales/{id}/confirm', 'Packaging\SalesController@confirm');
Route::get('packaging/sales/{id}/reset', 'Packaging\SalesController@reset');
Route::get('packaging/sales/payment_form/{id}', 'Packaging\SalesController@payment_form');
Route::post('packaging/sales/payment/update', 'Packaging\SalesController@payment_update');

// Resource Route for Empty Bag Size Controller
Route::resource('packaging/bagsize', 'Packaging\BagSizeController');
Route::post('packaging/bagsize/search', 'Packaging\BagSizeController@search');
Route::post('packaging/bagsize/delete', 'Packaging\BagSizeController@delete');

// Resource Route for Empty Bag Color Controller
Route::resource('packaging/bagcolor', 'Packaging\BagColorController');
Route::post('packaging/bagcolor/search', 'Packaging\BagColorController@search');
Route::post('packaging/bagcolor/delete', 'Packaging\BagColorController@delete');

// Resource Route for Empty Bag Color Controller
Route::resource('packaging/bagtype', 'Packaging\BagTypeController');
Route::post('packaging/bagtype/search', 'Packaging\BagTypeController@search');
Route::post('packaging/bagtype/delete', 'Packaging\BagTypeController@delete');






