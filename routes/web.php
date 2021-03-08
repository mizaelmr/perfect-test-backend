<?php

use Illuminate\Support\Facades\Route;



/*
Telas para ver o funcionamento sem dados
*/
Route::get('/', function () {
    return view('dashboard');
});

// Route::get('/sales', function () {
//     return view('crud_sales');
// });

// Route::get('/products', function () {
//     return view('crud_products');
// });

//products
Route::get('/products', 'ProductController@index')->name('products.index');
Route::post('/products', 'ProductController@store')->name('products.store');
Route::get('/products/edit/{id}', 'ProductController@edit')->name('products.edit');
Route::put('/products/update/{id}', 'ProductController@update')->name('products.update');
Route::delete('/products/destroy/{id}', 'ProductController@destroy')->name('products.delete');

//sale
Route::get('/sale', 'SaleController@index')->name('sale.index');
Route::get('/sale/resume', 'SaleController@resume')->name('sale.resume');
Route::post('/sale', 'SaleController@store')->name('sale.store');
Route::get('/sale/edit/{id}', 'SaleController@edit')->name('sale.edit');
Route::put('/sale/update/{id}', 'SaleController@update')->name('sale.update');
Route::delete('/sale/destroy/{id}', 'SaleController@destroy')->name('sale.delete');


Route::get('/clients', 'ClientController@index')->name('client.index');




