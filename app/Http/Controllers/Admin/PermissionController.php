<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// El modelo Permission viene con el paquete Spatie de Laravel Permission
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // obtener todos los permisos
        $permissions = Permission::orderBy('id', 'desc')->get();
        
        return view("admin.permissions.index", compact("permissions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.permissions.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar los datos recibidos y almacenarlos en $data
        $data = $request->validate([
            'name'=> 'required|string|max:255|unique:permissions',
        ]);

        //crear el permiso con los datos validados
        Permission::create($data);

        //variable de sesion flash 'swal' de un solo uso, que servirá para mostrar la alerta sweetalert2,
        //con icono, titulo y texto, cuando se recrgue la vista index de permissions
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡Permiso creado!',
            'text' => $data['name'],
        ]); 

        //redirigir a la vista index
        return redirect()->route("admin.permissions.index");    
    }

    /**
     * Display the specified resource.
     * El modelo Permission viene con el paquete Spatie de Laravel Permission
     */
    public function show(Permission $permission)
    {
        return view("admin.permissions.show", compact("permission"));
    }

    /**
     * Show the form for editing the specified resource.
     * El modelo Permission viene con el paquete Spatie de Laravel Permission
     */
    public function edit(Permission $permission)
    {
        return view("admin.permissions.edit", compact("permission"));
    }

    /**
     * Update the specified resource in storage.
     * El modelo Permission viene con el paquete Spatie de Laravel Permission
     */
    public function update(Request $request, Permission $permission)
    {
       $request->validate([
        // "required" es un validador que requiere que el campo no esté vacío
        // "unique:permissions,name" es un validador que requiere que el valor del campo no exista en la tabla permissions
        // ".$permission->id" excluye de la validación unique el registro actual que estamos editando
           'name' => 'required|unique:permissions,name,' . $permission->id . '|string|max:255',
       ]);



    // actualizar el registro en la tabla permissions
    $permission->update([
        'name' => $request->name,
    ]);

    // crear variable de sesión flash, para mostrar mensaje modal de éxito
    session()->flash("swal", [
        'icon' => 'success',
        'title' => '¡Permiso actualizado!',
        'text' => $permission->name
    ]);

    // redirigir a la vista de index
    return to_route("admin.permissions.index");

  }

    /**
     * Remove the specified resource from storage.
     * El modelo Permission viene con el paquete Spatie de Laravel Permission
     */
    public function destroy(Permission $permission)
    {
        // eliminar el registro de la categoría
        $permission->delete();

        //variable de sesion flash 'swal' de un solo uso, que servirá para mostrar la alerta sweetalert2,
        //con icono, titulo y texto, cuando se recrgue la vista index de categories
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡Permiso Eliminado!',
            'text' => $permission->name
        ]);

        //redirigir a la ruta index de permissions
        return redirect()->route('admin.permissions.index');
    }   
}
