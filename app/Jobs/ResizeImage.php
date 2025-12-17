<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ResizeImage implements ShouldQueue
{
    use Queueable;

    //atributo para almacenar el path de la imagen, reicibido en el constructor
    public $image_path;

    /**
     * Create a new job instance.
     */
    public function __construct($image_path)
    {
        //asignar el path de la imagen al atributo $image_path
        $this->image_path = $image_path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // obtener el archivo imagen almacenado, según el path
        $upload = Storage::get($this->image_path);
        
        // obtener la extensión del archivo
        $extension = pathinfo($this->image_path, PATHINFO_EXTENSION);

        // redimensionar la imagen y codificarla, según la extensión del archivo y la calidad deseada (compresión)
        $image = Image::read($upload)
            ->scale(width:1200)
            ->encodeByExtension($extension, quality: 70);

        // volver a guardar la imagen ($image) redimensionada, en su path original
        Storage::put($this->image_path, $image);    
    }
}
