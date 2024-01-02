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

//register
Route::get('/signup', 'App\Http\Controllers\RegisterController@showRegistrationForm');
Route::post('/signup', 'App\Http\Controllers\RegisterController@register')->name('register');

//login
Route::get('/', 'App\Http\Controllers\LoginController@showLoginForm');
Route::post('/', 'App\Http\Controllers\LoginController@login')->name('login');

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

//penjualan
Route::resource('penjualan', 'App\Http\Controllers\PenjualanController');

//marg.penjualan
Route::resource('margin', 'App\Http\Controllers\MarginPenjualanController');

//det.penjualan
Route::resource('detpenjualan', 'App\Http\Controllers\DetailPenjualanController');

//kartustok
Route::resource('kartustok', 'App\Http\Controllers\KartuStokController');