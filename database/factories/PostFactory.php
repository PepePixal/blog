<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title"=> $this->faker->sentence(),
            "slug"=> $this->faker->unique()->slug(),
            "excerpt"=> $this->faker->paragraph(),
            "content"=> $this->faker->paragraph(20, true),
            "is_published"=> $this->faker->boolean(),
            "published_at"=> $this->faker->dateTime(),
            
            //** llaves foraneas */
            //obtener todos los usuarios, seleccionar uno al azar y obtener su id
            "user_id"=> \App\Models\User::all()->random()->id,
            //obtener todas las categorias, seleccionar una al azar y obtener su id
            "category_id"=> \App\Models\Category::all()->random()->id,
        ];
    }
}
