<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // obtener todos los posts, ordenados por id (descendente) y paginarlos
        $posts = Post::latest("id")->paginate(10);

        // retornar la vista admin.posts.index con los posts
        return view('admin.posts.index', compact('posts')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //obtener todas las categorías para el select del formulario crear post
        $categories = Category::all(); 

        // retornar la vista admin.posts.create, enviando las categorías
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

        //redirigir a la ruta admin.posts.edit, enviando el post,
        //para que se muestre el formulario de edición y agregar los campos del nuevo post
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

        //obtener todas las categorías para el select del formulario editar post
        $categories = Category::all();
        //obtener todas las etiquetas para el select2 del formulario editar post
        $tags = Tag::all();

        //retornar la vista admin.posts.edit, enviando el post, categorías y etiquetas
        return view("admin.posts.edit", compact("post", "categories", "tags"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {   
        // validar los datos del formulario antes de actualizar el post y almacenarlos
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'is_published' => 'nullable|integer|in:0,1',
            // validación de que el campo excerpt sea requerido si el post está publicado
            'excerpt' => 'required_if:is_published,1|string|nullable',
            'content' => 'required_if:is_published,1|string|nullable'
        ]);

        
        // actualizar el post editado con los datos del formulario
        $post->update($data);
     
        //** para agregar a la tabla tags, las nuevas etiquetas generadas en el select tags y enviadas con el formulario */
        //define un array vacío, para almacenar las etiquetas
        $tags = [];
        // si $request->tags contiene NULL, sustituirlo por un array vacío
        foreach ($request->tags ?? [] as $tag){
            $tags[] = Tag::firstOrCreate(['name' => $tag]);
        }

        // sincronizar las etiquetas con el post, a través de la tabla pivot post_tag
        $post->tags()->sync($tags);

        // crear una variable temporal de sesión para mostrar un mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Actualizado el post:',
            'text' => $post->title,
        ]);

        // redirigir a la ruta admin.posts.edit, enviando el post,
        // para que se muestre el formulario de edición y agregar los campos del nuevo post
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
