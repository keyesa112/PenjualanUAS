<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;


 
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

// Route::get('/', function () {
//     return view('welcome', ['title' => 'Praktikum Basis Data']);
// });

//register
Route::get('/', 'App\Http\Controllers\RegisterController@showRegistrationForm');
Route::post('/', 'App\Http\Controllers\RegisterController@register')->name('register');

//login
Route::get('/login', 'App\Http\Controllers\LoginController@showLoginForm');
Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login');


//home
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');


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
Route::post('/caribarang', 'App\Http\Controllers\BarangController@caribarang'); //prosesadding
Route::get('cari', function () {
    return view('barang/cari');
});

//vendor
Route::resource('vendor', 'App\Http\Controllers\VendorController');