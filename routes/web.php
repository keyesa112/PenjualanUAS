<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['title' => 'Praktikum Basis Data']);
});

//home
Route::get('home', function () {
    return view('home');
});

//role
Route::get('/role', 'App\Http\Controllers\RoleController@data'); //data
Route::get('/role/add', 'App\Http\Controllers\RoleController@add'); //add
Route::post('/role', 'App\Http\Controllers\RoleController@addProcess'); //prosesadding
Route::get('/role/edit/{id}', 'App\Http\Controllers\RoleController@edit'); //edit
Route::patch('/role/{id}', 'App\Http\Controllers\RoleController@editProcess'); //prosesediting
Route::delete('/role/{id}', 'App\Http\Controllers\RoleController@delete'); //delete
Route::get('role/{id}', 'App\Http\Controllers\RoleController@show')->name('role.show'); //show


//user
Route::resource('user', 'App\Http\Controllers\UserController');

//satuan
Route::resource('satuan', 'App\Http\Controllers\SatuanController');

//barang
Route::resource('barang', 'App\Http\Controllers\BarangController');

//vendor
Route::resource('vendor', 'App\Http\Controllers\VendorController');

//pengadaan
Route::resource('pengadaan', 'App\Http\Controllers\PengadaanController');

//penjualan
Route::resource('penjualan', 'App\Http\Controllers\PenjualanController');

//det.pengadaan
Route::resource('detpengadaan', 'App\Http\Controllers\DetailPengadaanController');

//penerimaan
Route::resource('penerimaan', 'App\Http\Controllers\PenerimaanController');

//det.penerimaan
Route::resource('detpenerimaan', 'App\Http\Controllers\DetailPenerimaanController');

//retur
Route::resource('retur', 'App\Http\Controllers\ReturController');

//det.retur
Route::resource('detretur', 'App\Http\Controllers\DetailReturController');