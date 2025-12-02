<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //asignacion masiva
    protected $fillable = [
        'body',
    ];

    //relación inversa muchos a uno con post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }   
}
