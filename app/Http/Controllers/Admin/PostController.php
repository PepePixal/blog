<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ResizeImage;


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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'is_published' => 'nullable|integer|in:0,1',
            // validación de que el campo excerpt sea requerido si el post está publicado
            'excerpt' => 'required_if:is_published,1|string|nullable',
            'content' => 'required_if:is_published,1|string|nullable',
        ]);

        // validar si en el campo image se envió un archivo
        if ($request->hasFile('image')) {

            // validar si en el campo image_path contiene un path,
            // borra el archivo existente con nombre = al path, antes de subir un nuevo archivo de imagen
            if ($post->image_path) {
                Storage::delete($post->image_path);
            }   

            //** generar un nombre a partir del slug del post y la extensión del archivo, para cambiarselo al archivo a subir */
            // Obtener la extensión del archivo
            $extension = $request->image->extension();
            // Generar un nombre para el archivo, con el slug del post y la extensión obtenida en $extension
            $fileName = $post->slug . '.' . $extension;

            // Mientras exista en la carpeta 'posts' el archivo con el nombre del slug del post,
            while(Storage::exists('posts/' . $fileName)) {
                // reasignar el nombre del archivo, sustituyendo la .extensión por -copia.extensión
                $fileName = str_replace('.' . $extension, '-copia.' . $extension, $fileName);
            }

            // guardar en una subcarpeta 'posts', el archivo que vienen en $request->image, con el nombre del slug del post en $fileName
            // agrega la llave image_path a $data, con el valor que nos retorna Storage, que es el path del archivo guardado en la carpeta 'posts'
            $data['image_path'] = Storage::putFileAs('posts', $request->image, $fileName);

            //llamar al job ResizeImage, enviando el path, para que el trabajo sea encolado.
            //En desarrollo local, configura la variable de entorno QUEUE_CONNECTION con el driver sync,
            //para que el trabajo se ejecute de forma síncrona y no sea encolado.
            ResizeImage::dispatch($data['image_path']);
        }
        
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
        // valida si el post a eliminar tiene una imagen guardada en la carpeta 'posts'
        if ($post->image_path) {
            // borra el archivo existente con nombre = al path, antes de eliminar el post
            Storage::delete($post->image_path);
        }   

        //borra el post
        $post->delete();

        //variable de sesion flash 'swal' de un solo uso, que servirá para mostrar la alerta sweetalert2,
        //con icono, titulo y texto, cuando se recrgue la vista index de posts
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡Post ELIMINADO!',
            'text' => 'Post ' . $post->title . ' eliminado correctamente',
        ]);

        //redirigir a la ruta index de posts
        return redirect()->route('admin.posts.index');
             
       
    }
}
