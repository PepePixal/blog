<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //asignacion masiva
    protected $fillable = [
        'title',
        'slug',
        'image_path',
        'excerpt',
        'content',
        'is_published',
        'published_at',
        'user_id',
        'category_id',
    ];

    //castear los campos especiales
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    //relacion inversa muchos a uno con category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //relación inversa muchos a uno con user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relación uno a muchos con comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //relación muchos a muchos con tags a traves de la tabla intermedia post_tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }   

}
