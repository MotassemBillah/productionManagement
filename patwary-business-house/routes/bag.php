<?php

/* Inventory Category Related Route */
Route::get('bag', 'Bag\DashboardController@index');

/* Raw Category Related Route */
Route::resource('bag/rawcategory', 'Bag\RawCategoryController');
Route::post('bag/rawcategory/search', 'Bag\RawCategoryController@search');
Route::post('bag/rawcategory/delete', 'Bag\RawCategoryController@delete');
Route::post('bag/rawcategory/rawproduct', 'Bag\RawCategoryController@get_raw_product');

/* Raw Product Related Route */
Route::resource('bag/rawproduct', 'Bag\RawProductController');
Route::post('bag/rawproduct/search', 'Bag\RawProductController@search');
Route::post('bag/rawproduct/delete', 'Bag\RawProductController@delete');

/* Finish Category Related Route */
Route::resource('bag/finishcategory', 'Bag\FinishCategoryController');
Route::post('bag/finishcategory/search', 'Bag\FinishCategoryController@search');
Route::post('bag/finishcategory/delete', 'Bag\FinishCategoryController@delete');
Route::post('bag/finishcategory/finishproduct', 'Bag\FinishCategoryController@get_finish_product');

/* Finish Product Related Route */
Route::resource('bag/finishproduct', 'Bag\FinishProductController');
Route::post('bag/finishproduct/search', 'Bag\FinishProductController@search');
Route::post('bag/finishproduct/delete', 'Bag\FinishProductController@delete');
