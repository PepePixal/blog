<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; 
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //define un gate para permitir la edición de un post, solo a su Autor
        Gate::define('author', function ($user, $post) {
            //valida si el id del usuario registrado es igual al campo user_id del post
		    return $user->id === $post->user_id;
	    });
    }
}
