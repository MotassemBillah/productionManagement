<?php

//Clear View cache:
Route::get('/clear_view_cache', function() {
    $exitCode = Artisan::call('view:clear');
    //Cache::flush();
    return redirect()->back()->with('success', 'Page Refresh Successfull');
});
Route::get('inv', 'Inv\DashboardController@index');

/* Inventory Category Related Route */
Route::get('inv/category/setting', 'Inv\CategoryController@setting');
Route::post('inv/category/setting', 'Inv\CategoryController@setting');
Route::resource('inv/category', 'Inv\CategoryController');
Route::post('inv/category/search', 'Inv\CategoryController@search');
Route::post('inv/category/delete', 'Inv\CategoryController@delete');
Route::post('inv/category/product', 'Inv\CategoryController@list_product');
Route::post('inv/list_buisness_category', 'Inv\CategoryController@list_category_by_buisness');
Route::post('inv/list_product', 'Inv\CategoryController@list_product_by_category');

/* Inventory Product Related Route */
Route::get('inv/product/ledger', 'Inv\ProductController@ledger');
Route::get('inv/product/form_opening_stock/{id}', 'Inv\ProductController@form_opening_stock');
Route::post('inv/product/update_opening_stock', 'Inv\ProductController@update_opening_stock');
Route::resource('inv/product', 'Inv\ProductController');
Route::post('inv/product/search', 'Inv\ProductController@search');
Route::post('inv/product/search_stock', 'Inv\ProductController@search_stock');
Route::post('inv/product/search_ledger', 'Inv\ProductController@search_ledger');
Route::post('inv/product/delete', 'Inv\ProductController@delete');

/* Inventory Purchase Related Route */
Route::get('inv/purchase/cart', 'Inv\PurchaseController@cart');
Route::post('inv/purchase/save_cart', 'Inv\PurchaseController@cart');
Route::get('inv/purchase/clear_cart', 'Inv\PurchaseController@clear_cart');
Route::get('inv/purchase/detail/{id}', 'Inv\PurchaseController@detail');
Route::get('inv/purchase/payment/{id}', 'Inv\PurchaseController@payment');
Route::post('inv/purchase/payment/{id}', 'Inv\PurchaseController@payment');
Route::get('inv/purchase/create_stock', 'Inv\PurchaseController@create_stock');
Route::get('inv/purchase/update_stock', 'Inv\PurchaseController@update_stock');
Route::get('inv/purchase/update_items', 'Inv\PurchaseController@update_items');
Route::get('inv/purchase/update_invoice_no', 'Inv\PurchaseController@update_invoice_no');
Route::get('inv/purchase/items', 'Inv\PurchaseController@items');
Route::resource('inv/purchase', 'Inv\PurchaseController');
Route::post('inv/purchase/search', 'Inv\PurchaseController@search');
Route::post('inv/purchase/search_items', 'Inv\PurchaseController@search_items');
Route::post('inv/purchase/delete', 'Inv\PurchaseController@delete');
Route::post('inv/purchase/search_product', 'Inv\PurchaseController@search_product');
Route::post('inv/purchase/add_cart_item', 'Inv\PurchaseController@add_to_cart');
Route::post('inv/purchase/delete_cart_item', 'Inv\PurchaseController@delete_cart_item');
Route::post('inv/purchase/delete_item', 'Inv\PurchaseController@delete_item');
Route::post('inv/purchase/process', 'Inv\PurchaseController@process');
Route::post('inv/purchase/reset', 'Inv\PurchaseController@reset');

/* Inventory Purchase Return Related Route */
Route::get('inv/purchase-return/cart', 'Inv\PurchaseReturnController@cart');
Route::post('inv/purchase-return/save_cart', 'Inv\PurchaseReturnController@cart');
Route::get('inv/purchase-return/clear_cart', 'Inv\PurchaseReturnController@clear_cart');
Route::get('inv/purchase-return/detail/{id}', 'Inv\PurchaseReturnController@detail');
Route::get('inv/purchase-return/payment/{id}', 'Inv\PurchaseReturnController@payment');
Route::post('inv/purchase-return/payment/{id}', 'Inv\PurchaseReturnController@payment');
Route::get('inv/purchase-return/create_stock', 'Inv\PurchaseReturnController@create_stock');
Route::get('inv/purchase-return/update_stock', 'Inv\PurchaseReturnController@update_stock');
Route::get('inv/purchase-return/update_items', 'Inv\PurchaseReturnController@update_items');
Route::get('inv/purchase-return/update_invoice_no', 'Inv\PurchaseReturnController@update_invoice_no');
Route::get('inv/purchase-return/items', 'Inv\PurchaseReturnController@items');
Route::resource('inv/purchase-return', 'Inv\PurchaseReturnController');
Route::post('inv/purchase-return/search', 'Inv\PurchaseReturnController@search');
Route::post('inv/purchase-return/delete', 'Inv\PurchaseReturnController@delete');
Route::post('inv/purchase-return/search_product', 'Inv\PurchaseReturnController@search_product');
Route::post('inv/purchase-return/add_cart_item', 'Inv\PurchaseReturnController@add_to_cart');
Route::post('inv/purchase-return/delete_cart_item', 'Inv\PurchaseReturnController@delete_cart_item');
Route::post('inv/purchase-return/delete_item', 'Inv\PurchaseReturnController@delete_item');
Route::post('inv/purchase-return/process', 'Inv\PurchaseReturnController@process');
Route::post('inv/purchase-return/reset', 'Inv\PurchaseReturnController@reset');

/* Inventory Sale Related Route */
Route::get('inv/sale/cart', 'Inv\SaleController@cart');
Route::post('inv/sale/save_cart', 'Inv\SaleController@cart');
Route::get('inv/sale/clear_cart', 'Inv\SaleController@clear_cart');
Route::get('inv/sale/detail/{id}', 'Inv\SaleController@detail');
Route::get('inv/sale/payment/{id}', 'Inv\SaleController@payment');
Route::post('inv/sale/payment/{id}', 'Inv\SaleController@payment');
Route::get('inv/sale/create_stock', 'Inv\SaleController@create_stock');
Route::get('inv/sale/update_stock', 'Inv\SaleController@update_stock');
Route::get('inv/sale/update_items', 'Inv\SaleController@update_items');
Route::get('inv/sale/update_invoice_no', 'Inv\SaleController@update_invoice_no');
Route::get('inv/sale/items', 'Inv\SaleController@items');
Route::resource('inv/sale', 'Inv\SaleController');
Route::post('inv/sale/search', 'Inv\SaleController@search');
Route::post('inv/sale/delete', 'Inv\SaleController@delete');
Route::post('inv/sale/search_product', 'Inv\SaleController@search_product');
Route::post('inv/sale/add_cart_item', 'Inv\SaleController@add_to_cart');
Route::post('inv/sale/delete_cart_item', 'Inv\SaleController@delete_cart_item');
Route::post('inv/sale/delete_item', 'Inv\SaleController@delete_item');
Route::post('inv/sale/process', 'Inv\SaleController@process');
Route::post('inv/sale/reset', 'Inv\SaleController@reset');

/* Inventory Sale Return Related Route */
Route::get('inv/sale-return/cart', 'Inv\SaleReturnController@cart');
Route::post('inv/sale-return/save_cart', 'Inv\SaleReturnController@cart');
Route::get('inv/sale-return/clear_cart', 'Inv\SaleReturnController@clear_cart');
Route::get('inv/sale-return/detail/{id}', 'Inv\SaleReturnController@detail');
Route::get('inv/sale-return/payment/{id}', 'Inv\SaleReturnController@payment');
Route::post('inv/sale-return/payment/{id}', 'Inv\SaleReturnController@payment');
Route::get('inv/sale-return/create_stock', 'Inv\SaleReturnController@create_stock');
Route::get('inv/sale-return/update_stock', 'Inv\SaleReturnController@update_stock');
Route::get('inv/sale-return/update_items', 'Inv\SaleReturnController@update_items');
Route::get('inv/sale-return/update_invoice_no', 'Inv\SaleReturnController@update_invoice_no');
Route::get('inv/sale-return/items', 'Inv\SaleReturnController@items');
Route::resource('inv/sale-return', 'Inv\SaleReturnController');
Route::post('inv/sale-return/search', 'Inv\SaleReturnController@search');
Route::post('inv/sale-return/delete', 'Inv\SaleReturnController@delete');
Route::post('inv/sale-return/search_product', 'Inv\SaleReturnController@search_product');
Route::post('inv/sale-return/add_cart_item', 'Inv\SaleReturnController@add_to_cart');
Route::post('inv/sale-return/delete_cart_item', 'Inv\SaleReturnController@delete_cart_item');
Route::post('inv/sale-return/delete_item', 'Inv\SaleReturnController@delete_item');
Route::post('inv/sale-return/process', 'Inv\SaleReturnController@process');
Route::post('inv/sale-return/reset', 'Inv\SaleReturnController@reset');
