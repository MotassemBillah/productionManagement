<?php

/* Rental Mananement Software Related Route */

/* Building Related Route */
Route::get('rental', 'Rental\DashboardController@index');
Route::resource('rental/building', 'Rental\BuildingController');
Route::post('rental/building/search', 'Rental\BuildingController@search');
Route::post('rental/building/delete', 'Rental\BuildingController@delete');
Route::post('rental/building/delete', 'Rental\BuildingController@delete');
Route::post('rental/building/floor', 'Rental\BuildingController@get_floor_list');

/* Building Related Route */
Route::resource('rental/floor', 'Rental\FloorController');
Route::post('rental/floor/search', 'Rental\FloorController@search');
Route::post('rental/floor/delete', 'Rental\FloorController@delete');
Route::post('rental/floor/flat', 'Rental\FloorController@get_flat_list');

/* Building Related Route */
Route::resource('rental/flat', 'Rental\FlatController');
Route::post('rental/flat/search', 'Rental\FlatController@search');
Route::post('rental/flat/delete', 'Rental\FlatController@delete');

/* Building Related Route */
Route::resource('rental/party', 'Rental\PartyController');
Route::post('rental/party/search', 'Rental\PartyController@search');
Route::post('rental/party/delete', 'Rental\PartyController@delete');
