<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RoleController extends Controller implements HasMiddleware
{
    // proteger las rutas roles con el permiso manage roles
    static function middleware(): array
    {
        return [
            new Middleware('can:manage roles'),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        //obtener todos los roles, ordenados del más reciente al más antiguo por su id
        $roles = Role::latest('id')->get();

        //pasar los roles a la vista index
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //obtener todos los permisos
        $permissions = Permission::all();
        
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
           'name' => 'required|unique:roles,name',
           'permissions' => 'required|array',
           //valida que todos los elementos (id) del array permissions, existan en el campo id de la tabla permissions
           'permissions.*' => 'exists:permissions,id',
        ]);

        // crear un nuevo rol con el campo name 
        $role = Role::create([
           'name' => $request->name,
        ]);

        //asignar los permisos recibidos, al nuevo rol,
        //a traves de la relación permissions() del modelo Role, creada por el paquete Spatie Laravel Permission,
        //se insertaran los registros en la tabla pivote model_has_permissions (crada por el paquete)
        $role->permissions()->attach($request->permissions);

        //agregar una variable de sesión, con una alerta tipo swal
        session()->flash('swal', [
           'icon' => 'success', 
           'title' => 'Rol creado exitosamente',
           'text' => $role->name
        ]);

        //redirigir a la vista edit
        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //obtener todos los permisos
        $permissions = Permission::all();
        
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // validar los campos recibidos en $request
        $request->validate([
            //valida que el campo name sea requerido y que sea único, excepto si es el mismo del rol actual
            'name' => 'required|unique:roles,name, ' . $role->id,
            'permissions' => 'required|array',
            //valida que todos los elementos (id) del array permissions, existan en el campo id de la tabla permissions
            'permissions.*' => 'exists:permissions,id',
        ]);

        // actualizar el rol con el campo name
        $role->update([
            'name' => $request->name,
        ]);

        //sincronizar los permisos recibidos, con los permisos del rol actual,
        //a traves de la relación permissions() del modelo Role, creada por el paquete Spatie Laravel Permission,
        //para sincronizarlos en la tabla pivote model_has_permissions (creada por el paquete )
        //elimina los que sobra, agrega los nuevos y mantiene los que ya existen
        $role->permissions()->sync($request->permissions);

        //agregar una variable de sesión, con una alerta tipo swal
        session()->flash('swal', [
            'icon' => 'success', 
            'title' => 'Rol actualizado exitosamente',
            'text' => $role->name
        ]);

        //redirigir a la ruta edit, enviando el rol actualizado
        return redirect()->route('admin.roles.edit', $role);

    }           

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // eliminar el registro del rol
        $role->delete();

        //agregar una variable de sesión, con una alerta tipo swal
        session()->flash('swal', [
            'icon' => 'success', 
            'title' => 'Rol eliminado',
            'text' => $role->name
        ]);

        //redirigir a la ruta index
        return redirect()->route('admin.roles.index');
    }
}
