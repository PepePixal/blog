<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    //retorna vista dashboard
    return view('admin.dashboard');
})->name('dashboard');

// Genera las 7 rutas necesarias para CRUD de categorias, asignadas al controlador CategoryController
Route::resource('categories', CategoryController::class);