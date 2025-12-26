<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        //Obterner los posts relacionados con el post que se está mostrando, según sus etiquetas (tags):
        
        //solo los post publicados
        $relatedPosts = Post::where('is_published', 1)
            //posts cuyos id sean diferentes al id del post actual
            ->where('id', '!=', $post->id)
            //posts cuyas etiquetas,
            ->whereHas('tags', function($query) use ($post){
                //estén en la lista (pluck) de etiquetas del post actual
                $query->whereIn('tags.id', $post->tags->pluck('id'));   
            })
            //gernera una columna con el conteo de etiquetas
            ->withCount(['tags' =>  function($query) use ($post){ 
                    $query->whereIn('tags.id', $post->tags->pluck('id'));  
            }])
            //ordena los posts por el conteo de etiquetas
            ->orderBy('tags_count', 'desc')
            //ordenados de forma descendente según el campo puglished_at
            ->orderBy('published_at', 'desc')
            //solo 4 posts
            ->take(4)
            //obtener
            ->get(); 

        //si la cantida de posts obtenidos según las etiquetas es menor a 4,
        //obtener los post realcionados por la categoria
        if($relatedPosts->count() < 4)
        {
            //solo los post publicados
            $relatedPosts2 = Post::where('is_published', 1)
            //posts cuyos id sean diferentes al id del post actual
            ->where('id', '!=', $post->id)
            //posts cuyas categorias sean iguales a la categoria del post actual
            ->where('category_id', $post->category_id)
            //posts cuyos id no estén en la lista (pluck) de ids de los posts obtenidos según las etiquetas
            ->whereNotIn('id', $relatedPosts->pluck('id'))
            //ordenados de forma descendente según el campo puglished_at
            ->orderBy('published_at', 'desc')
            //solo 4 posts menos la cantidad de posts obtenidos según las etiquetas
            ->take(4 - $relatedPosts->count())
            //obtener
            ->get();

            //concatenar los posts obtenidos según las etiquetas y los posts obtenidos según la categoria
            $relatedPosts = $relatedPosts->concat($relatedPosts2);
        }

        // enviar a la vista posts.show, el post actual y los posts relacionados obtenidos
        return view('posts.show', compact('post', 'relatedPosts')); 
    }
}
