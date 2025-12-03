<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //obtener todas las categorias ordenadas por id ascendente
        $categories = Category::orderBy('id', 'desc')->get();

        //llamar vista index de categories, enviando las categorias
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar los datos y almacenarlos en la variable $data
        $data = $request->validate([
            'name'=> 'required|string|max:255|unique:categories',
        ]);

        // crear la categoria con los datos validados
        Category::create($data);

        //variable de sesion flash 'swal' de un solo uso, que servirá para mostrar la alerta sweetalert2,
        //con icono, titulo y texto, cuando se recrgue la vista index de categories
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡Categoría creada!',
            'text' => 'La Categoría se ha creado correctamente',
        ]);

        //redirigir a la vista index de categories
        return redirect()->route('admin.categories.index');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //llamar vista edit de categories, enviando la categoria
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //validar los datos. En unique, se excluye el id de la categoria actual editada,
        //para permitir que el nombre de esta se pueda reescribir.
        $data = $request->validate([
            'name'=> 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        //actualizar la categoria con los datos validados $data
        $category->update($data);

        //variable de sesion flash 'swal' de un solo uso, que servirá para mostrar la alerta sweetalert2,
        //con icono, titulo y texto, cuando se recrgue la vista index de categories
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡Categoría actualizada!',
            'text' => 'La Categoría se ha actualizado correctamente',
        ]);

        //redirigir a la ruta index de categories
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // eliminar el registro de la categoría
        $category->delete();

        //variable de sesion flash 'swal' de un solo uso, que servirá para mostrar la alerta sweetalert2,
        //con icono, titulo y texto, cuando se recrgue la vista index de categories
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡Categoría ELIMINADA!',
            'text' => 'Categoría ' . $category->name . ' eliminada correctamente',
        ]);

        //redirigir a la ruta index de categories
        return redirect()->route('admin.categories.index');
    }
}
