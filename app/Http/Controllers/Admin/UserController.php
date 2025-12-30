<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtener todos los usuarios ordenados desde el último id de forma descendente y paginados de a 10
        $users = User::latest('id')->paginate(10);
        
        //retornar la vista admin.users.index, enviando los usuarios
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //validación de los campos del formulario recibidos en $request
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            //confirmed confirma que el campo password sea igual al campo password_confirmation
            'password' => 'required|string|min:8|confirmed',
        ]);

        //encripta la contraseña
        $data['password'] = bcrypt($data['password']);

        //crea un nuevo registro de usuario en la tabla users
        $user = User::create($data);

        //variable de sesión con clave 'swal' para mostrar alerta de éxito
        session()->flash('swal',
            [
                'icon' => 'success',
                'title' => 'Usuario creado',
                'text' => $user->name
            ]);

        //redirige a la vista admin.users.edit, enviando el usuario creado
        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /** 
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //validación de los campos del formulario recibidos en $request
        $data = $request->validate([
            'name' => 'required|string|max:255',
            //unique:users' . $user->id, permite que el email sea único, excepto el del usuario actual
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            //en la edición, el campo password es opcional, por si no se desea cambiar la contraseña
            //confirmed confirma que el campo password sea igual al campo password_confirmation
            'password' => 'nullable|string|min:8|confirmed',
        ]);

       
        //actualiza el nombre y el email del usuario, con los datos validados
        $user->name = $data['name'];
        $user->email = $data['email'];


        
        //si se envió una nueva contraseña con el formulario, encriptarla y
        if (isset($data['password'])) {

            //encripta la contraseña recibida y la reasigna al usuario
            $user->password = bcrypt($data['password']);

        }
       
        //guardar el usuario con los datos validados y encriptados
        $user->save();

        //variable de sesión con clave 'swal' para mostrar alerta de éxito
        session()->flash('swal',
            [
                'icon' => 'success',
                'title' => 'Usuario actualizado',
                'text' => $user->name
            ]); 

        //redirige a la ruta admin.users.edit, enviando el usuario actualizado
        return redirect()->route('admin.users.edit', $user);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();    

        //variable de sesión con clave 'swal' para mostrar alerta de éxito  
        session()->flash('swal',
            [
                'icon' => 'success',
                'title' => 'Usuario eliminado',
                'text' => $user->name
            ]); 

        //redirige a la ruta admin.users.index
        return redirect()->route('admin.users.index');  
    }
}
