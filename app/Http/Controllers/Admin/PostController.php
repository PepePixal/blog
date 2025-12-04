<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // obtener todos los posts paginados, de 15 por defecto
        $posts = Post::paginate();

        // retornar la vista admin.posts.index con los posts
        return view('admin.posts.index', compact('posts')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // obtener todas las categorías
        $categories = Category::all(); 

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* validaciones de la info del formulario,
         en el caso de que no se cumplan, se redirige a la misma página con los errores */
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'category_id' => 'required|exists:categories,id'
        ]);

        //agregar a $data el campo user_id, con el valor del id del usuario autenticado
        $data['user_id'] = auth('web')->user()->id;

        //crear el registro post en la tabla posts
        $post = Post::create($data);
        
        // crear una variable de sesión para mostrar un mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post creado correctamente',
            'text' => $post->title,
        ]);

        //redirigir a la ruta admin.posts.edit con el id del post
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
       return view("admin.posts.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
