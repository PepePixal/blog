<?php

namespace App\Http\Controllers;
use App\Models\Post;    

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // obtener los posts pulicados, ordenados por fecha de publicación desc y paginados de a 8
        $posts = Post::orderBy('published_at', 'desc')
            ->where('is_published', 1)
            ->paginate(8);

        // retornar la vista con los posts obtenidos
        return view('welcome', compact('posts'));
    }
}
