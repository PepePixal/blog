<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    // antes de que se actualice un post
    public function updating(Post $post)    
    {
        // 
        if ($post->is_published == 1 && !$post->published_at){
            //asigna la fecha actual al campo published_at
            $post->published_at = now();  
        }
    }
}
