<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


#[ObservedBy(PostObserver::class)]

class Post extends Model
{
    //agrega el trait HasFactory, para poder usar el factory PostFactory
    //requiere agregar la importacion de HasFactory 
    use HasFactory;

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

    // Accesores - genera un atributo donde obtiene el path de la imagen, cuando se obtiene el post
    protected function image(): Attribute
    {
        return Attribute::make(
            // si existe el path de la imagen ? obtiene su url y la muestra, si no :, muestra la imagen por defecto.
            // el $this es porque estamos dentro del própio objeto del modelo Post
            get: fn() => $this->image_path ? Storage::url($this->image_path) : '/storage/no-image.jpg',
        );
    }

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
