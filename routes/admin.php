<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    //retorna vista dashboard
    return view('admin.dashboard');
})->name('dashboard');

// Crea las 7 rutas necesarias para CRUD de categorias, asignadas al controlador CategoryController
Route::resource('categories', CategoryController::class);

// Crea las 7 rutas necesarias para CRUD de posts, asignadas al controlador PostController
Route::resource('posts', PostController::class);