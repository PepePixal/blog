<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    //retorna vista dashboard
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('categories', CategoryController::class);