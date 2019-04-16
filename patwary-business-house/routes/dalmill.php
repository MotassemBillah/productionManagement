<?php

/* Dal Related Route */
Route::get('dal', 'Dal\DashboardController@index');

/* Raw Category Related Route */
Route::resource('dal/rawcategory', 'Dal\RawCategoryController');
Route::post('dal/rawcategory/search', 'Dal\RawCategoryController@search');
Route::post('dal/rawcategory/delete', 'Dal\RawCategoryController@delete');
Route::post('dal/rawcategory/rawproduct', 'Dal\RawCategoryController@get_raw_product');

/* Raw Product Related Route */
Route::resource('dal/rawproduct', 'Dal\RawProductController');
Route::post('dal/rawproduct/search', 'Dal\RawProductController@search');
Route::post('dal/rawproduct/delete', 'Dal\RawProductController@delete');

/* Finish Category Related Route */
Route::resource('dal/finishcategory', 'Dal\FinishCategoryController');
Route::post('dal/finishcategory/search', 'Dal\FinishCategoryController@search');
Route::post('dal/finishcategory/delete', 'Dal\FinishCategoryController@delete');
Route::post('dal/finishcategory/finishproduct', 'Dal\FinishCategoryController@get_finish_product');

/* Finish Product Related Route */
Route::resource('dal/finishproduct', 'Dal\FinishProductController');
Route::post('dal/finishproduct/search', 'Dal\FinishProductController@search');
Route::post('dal/finishproduct/delete', 'Dal\FinishProductController@delete');


/* Purchase Challan Related Route */
Route::get('dal/purchase-challan/details', 'Dal\PurchaseChallanController@details');
Route::resource('dal/purchase-challan', 'Dal\PurchaseChallanController');
Route::post('dal/purchase-challan/search', 'Dal\PurchaseChallanController@search');
Route::post('dal/purchase-challan/search-items', 'Dal\PurchaseChallanController@search_items');
Route::post('dal/purchase-challan/delete', 'Dal\PurchaseChallanController@delete');

/* Sales Challan Related Route */
Route::get('dal/sales-challan/details', 'Dal\SalesChallanController@details');
Route::resource('dal/sales-challan', 'Dal\SalesChallanController');
Route::post('dal/sales-challan/search', 'Dal\SalesChallanController@search');
Route::post('dal/sales-challan/search-items', 'Dal\SalesChallanController@search_items');
Route::post('dal/sales-challan/delete', 'Dal\SalesChallanController@delete');


/* Finish Stocks Related Route */
Route::get('dal/finishstocks/details', 'Dal\FinishStockController@details');
Route::get('dal/finishstocks/opening', 'Dal\FinishStockController@opening_stocks');
Route::post('dal/finishstocks/opening', 'Dal\FinishStockController@store_opening_stocks');
Route::post('dal/finishstocks/opening/update', 'Dal\FinishStockController@update_opening_stocks');
Route::resource('dal/finishstocks', 'Dal\FinishStockController');
Route::post('dal/finishstocks/search', 'Dal\FinishStockController@search');
Route::post('dal/finishstocks/details/search', 'Dal\FinishStockController@details_search');


/* Raw Stocks Related Route */
Route::get('dal/rawstocks/details', 'Dal\RawStockController@details');
Route::get('dal/rawstocks/opening', 'Dal\RawStockController@opening_stocks');
Route::post('dal/rawstocks/opening', 'Dal\RawStockController@store_opening_stocks');
Route::post('dal/rawstocks/opening/update', 'Dal\RawStockController@update_opening_stocks');
Route::resource('dal/rawstocks', 'Dal\RawStockController');
Route::post('dal/rawstocks/search', 'Dal\RawStockController@search');
Route::post('dal/rawstocks/details/search', 'Dal\RawStockController@details_search');

/* Raw Stocks Related Route */
Route::get('dal/finishstocks/details', 'Dal\FinishStockController@details');
Route::get('dal/finishstocks/opening', 'Dal\FinishStockController@opening_stocks');
Route::post('dal/finishstocks/opening', 'Dal\FinishStockController@store_opening_stocks');
Route::post('dal/finishstocks/opening/update', 'Dal\FinishStockController@update_opening_stocks');
Route::resource('dal/finishstocks', 'Dal\FinishStockController');
Route::post('dal/finishstocks/search', 'Dal\FinishStockController@search');
Route::post('dal/finishstocks/details/search', 'Dal\FinishStockController@details_search');


/* Purchase Related Route */
Route::resource('dal/purchases', 'Dal\PurchaseController');
Route::get('dal/purchase/ledger', 'Dal\PurchaseController@ledger');
Route::post('dal/purchase/ledger/search', 'Dal\PurchaseController@ledger_search');
Route::post('dal/purchases/search', 'Dal\PurchaseController@search');
Route::post('dal/purchases/delete', 'Dal\PurchaseController@delete');
Route::get('dal/purchase/stocks', 'Dal\PurchaseController@stocks');
Route::post('dal/purchase/stocks/search', 'Dal\PurchaseController@stocks_search');
Route::get('dal/purchases/{id}/confirm', 'Dal\PurchaseController@confirm');
Route::get('dal/purchases/{id}/reset', 'Dal\PurchaseController@reset');
Route::get('dal/purchase/payment_form/{id}', 'Dal\PurchaseController@payment_form');
Route::post('dal/purchase/payment/update', 'Dal\PurchaseController@payment_update');


/* Production Related Route */
Route::get('dal/production-list', 'Dal\ProductionController@productionList');
Route::get('dal/production/stocks', 'Dal\ProductionController@stocks');
Route::resource('dal/production', 'Dal\ProductionController');
Route::post('dal/production/list/search', 'Dal\ProductionController@productionListSearch');
Route::post('dal/production/search', 'Dal\ProductionController@search');
Route::post('dal/production/delete', 'Dal\ProductionController@delete');
Route::post('dal/production/stocks/search', 'Dal\ProductionController@stocks_search');
Route::get('dal/production/{id}/confirm', 'Dal\ProductionController@confirm');
Route::get('dal/production/{id}/reset', 'Dal\ProductionController@reset');

/* Production Related Route */
Route::get('dal/finishgoods-list', 'Dal\FinishGoodsController@finishgoodsList');
Route::get('dal/finishgoods/stocks', 'Dal\FinishGoodsController@stocks');
Route::resource('dal/finishgoods', 'Dal\FinishGoodsController');
Route::post('dal/finishgoods/list/search', 'Dal\FinishGoodsController@finishgoodsListSearch');
Route::post('dal/finishgoods/search', 'Dal\FinishGoodsController@search');
Route::post('dal/finishgoods/delete', 'Dal\FinishGoodsController@delete');
Route::post('dal/finishgoods/stocks/search', 'Dal\FinishGoodsController@stocks_search');
Route::get('dal/finishgoods/{id}/confirm', 'Dal\FinishGoodsController@confirm');
Route::get('dal/finishgoods/{id}/reset', 'Dal\FinishGoodsController@reset');

/* Sales Related Route */
Route::get('dal/sales/ledger', 'Dal\SalesController@ledger');
Route::resource('dal/sales', 'Dal\SalesController');
Route::post('dal/sales/ledger/search', 'Dal\SalesController@ledger_search');
Route::post('dal/sales/search', 'Dal\SalesController@search');
Route::post('dal/sales/delete', 'Dal\SalesController@delete');
Route::get('dal/sales/stocks', 'Dal\SalesController@stocks');
Route::post('dal/sales/stocks/search', 'Dal\SalesController@stocks_search');
Route::get('dal/sales/{id}/confirm', 'Dal\SalesController@confirm');
Route::get('dal/sales/{id}/reset', 'Dal\SalesController@reset');
Route::get('dal/sales/payment_form/{id}', 'Dal\SalesController@payment_form');
Route::post('dal/sales/payment/update', 'Dal\SalesController@payment_update');

// Resource Route for Empty Bag Size Controller
Route::resource('dal/bagsize', 'Dal\BagSizeController');
Route::post('dal/bagsize/search', 'Dal\BagSizeController@search');
Route::post('dal/bagsize/delete', 'Dal\BagSizeController@delete');

// Resource Route for Empty Bag Color Controller
Route::resource('dal/bagcolor', 'Dal\BagColorController');
Route::post('dal/bagcolor/search', 'Dal\BagColorController@search');
Route::post('dal/bagcolor/delete', 'Dal\BagColorController@delete');

// Resource Route for Empty Bag Color Controller
Route::resource('dal/bagtype', 'Dal\BagTypeController');
Route::post('dal/bagtype/search', 'Dal\BagTypeController@search');
Route::post('dal/bagtype/delete', 'Dal\BagTypeController@delete');






