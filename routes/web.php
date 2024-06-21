<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangmasukController;
use App\Http\Controllers\BarangkeluarController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/kategori', \App\Http\Controllers\KategoriController::class);

Route::resource('/barang', \App\Http\Controllers\BarangController::class);
Route::resource('barang', BarangController::class);
Route::resource('/barangmasuk', \App\Http\Controllers\BarangmasukController::class);
Route::resource('/barangkeluar', \App\Http\Controllers\BarangkeluarController::class);

Route::get('login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class,'authenticate']);

Route::get('logout', [LoginController::class,'logout']);
Route::post('logout', [LoginController::class,'logout']);

Route::get('register', [RegisterController::class,'create']);
Route::post('register', [RegisterController::class,'store']);

