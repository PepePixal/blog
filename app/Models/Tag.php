<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //asignacion masiva
    protected $fillable = [
        'name',
    ];
}
