<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        //crea un usuario si no existe, buscando por su email
        User::firstOrCreate(
            ['email' => 'pepepixal@gmail.com'],
            [
                'name' => 'Pepe Mari',
                'password' => bcrypt('987654321'),
                'email_verified_at' => now(),
            ]
        );

        //crear 10 categorias aleatorias falsas de prueba
        Category::factory(10)->create();

        //crear 100 posts aleatorios falsos de prueba
        Post::factory(100)->create();

        // llamar al seeder PermissionSeeder
        $this->call([
            PermissionSeeder::class
        ]);
    }
}
