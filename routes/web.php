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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Coupons@generateDefault');
Route::get('/prefix/{prefix}', 'Coupons@generateWithPrefix');
Route::get('/quantity/{quantity}', 'Coupons@generateWithQuantity');
Route::get('/prefix/{prefix}/quantity/{quantity}', 'Coupons@generateWithBoth');
