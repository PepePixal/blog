<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function (){
    //retorna vista dashboard
    return view('admin.dashboard');
})->name('dashboard');

// Crea las 7 rutas necesarias para CRUD de categorias, asignadas al controlador CategoryController
Route::resource('categories', CategoryController::class);

// Crea las 7 rutas necesarias para CRUD de posts, asignadas al controlador PostController
Route::resource('posts', PostController::class);

// Crea las 7 rutas necesarias para CRUD de permisos, asignadas al controlador PermissionController
Route::resource('permissions', PermissionController::class);

// Crea las 7 rutas necesarias para CRUD de roles, asignadas al controlador RoleController
Route::resource('roles', RoleController::class);       

// Crea las 7 rutas necesarias para CRUD de usuarios, asignadas al controlador UserController
Route::resource('users', UserController::class);    

